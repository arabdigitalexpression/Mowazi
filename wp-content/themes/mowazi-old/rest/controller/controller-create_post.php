<?php
class Create_Post extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'create-post';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to create a post
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> return true if user is logged in
   */
  public function create_item_permissions_check( $request ) {
    $request_body = $request->get_json_params();

    if (!empty($request_body) && isset($request_body['u'])) {
        $cur_user = (int)mo_crypt($request_body['u'], 'd');

        // user not logged in
        if ($cur_user == 0) {
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من إنشاء محتوى جديد', array( 'status' => 401 ) );
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

        if ( function_exists( 'mo_create_post' ) ) {
            $result = mo_create_post($post_data);

            $title = get_the_title($result['id']);
            $title = str_replace( 'Private: ', '', $title );
            $title = str_replace( 'خاص: ', '', $title );
            $perma = get_permalink($result['id']);

            if (!empty($result)) {
              	$response = array( 'html'  =>  $result["html"], 'nav'  =>  $result["nav"], 'activity'  =>  $result["activity"], 'perma'  =>  $perma, 'title'  =>  $title, 'message' =>  'تم إنشاء المحتوى بنجاح');
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>