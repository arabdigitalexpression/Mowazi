<?php
class Report_Post extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'report-post';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to login
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> always return true to allow anyone to use login route
   */
  public function create_item_permissions_check( $request ) {
    $request_body = $request->get_json_params();

    if (!empty($request_body) && isset($request_body['u'])) {
        $cur_user = (int)mo_crypt($request_body['u'], 'd');
        $post_id = $request_body['post'];
        $post_reports = get_post_meta( $post_id, 'mo_reports_group', true );

        // user not logged in
        if ($cur_user == 0) {
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من الإبلاغ عن هذا المحتوى', array( 'status' => 401 ) );
        }

        // if user already reported the post
        if ( !empty( $post_reports ) ) {

            foreach ($post_reports as $post_report) {
                if ( isset( $post_report['user_id'] ) && (int)$post_report['user_id'] == $cur_user ) {
                    return new WP_Error( 'unauthorized', 'لقد أبلغت عن هذا المحتوى من قبل', array( 'status' => 401 ) );
                }
            }

        } else {
            return true;
        }

    } else {
        return false;
    }
    return true;
  }


   /**
   * Prepare the item for create operation
   *
   * @param WP_REST_Request $request Request object
   * @return array of email and password | empty array if any request param is missing
   */
  public function prepare_item_for_database( $request ) {
    $request_body = $request->get_json_params();
    return $request_body;
  }

  /**
   * login user
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $post_data = $this->prepare_item_for_database( $request );

 
    if ( !empty( $post_data ) && is_array( $post_data ) ) {

        if ( function_exists( 'mo_report_post' ) ) {
            $post_reported = mo_report_post($post_data);

            if ( $post_reported ) {
                $response = array('message' =>  'تم الإبلاغ عن المحتوى');
                return new WP_REST_Response( $response, 200 );
            }
        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>