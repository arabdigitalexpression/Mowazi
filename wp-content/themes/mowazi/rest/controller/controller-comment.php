<?php
class Comment extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'comment';

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
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من التعليق', array( 'status' => 401 ) );
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
   * @return array of user_id & post_id & parent comment & user agent | empty array if any request param is missing
   */
  public function prepare_item_for_database( $request ) {
    $result = array();
    $request_body = $request->get_json_params();
    $user_agent = $request->get_header( 'user_agent' );

    if ( !empty($request_body) ) {
        $result = $request_body;

        if ( $user_agent ) {
            $result['user_agent'] = $user_agent;
        }

    }


    return $result;
  }

  /**
   * Create Comment
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $comment_data = $this->prepare_item_for_database( $request );
 
    if ( !empty( $comment_data ) && is_array( $comment_data ) ) {

        if ( function_exists( 'mo_add_comment' ) ) {
            $result = mo_add_comment($comment_data);

            if ( $result && !empty( $result ) ) {
              	$response = array( 'html'    =>  $result, 'message' =>  'تمت إضافة التعليق بنجاح.' );
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>