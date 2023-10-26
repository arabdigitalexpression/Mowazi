<?php
class Clone_Post extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'clone';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to bookmark a post
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> return true if user is logged in
   */
  public function create_item_permissions_check( $request ) {
    $request_body = $request->get_json_params();

    if (!empty($request_body) && isset($request_body['u'])) {
        $cur_user = (int)mo_crypt($request_body['u'], 'd');

        $post_id = $request_body['c'];
        $post_author = (int)get_post_field ('post_author', $post_id);

        // user not logged in
        if ($cur_user == 0) {
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من نسخ المحتوى', array( 'status' => 401 ) );
        } elseif ($cur_user == $post_author) {
            return new WP_Error( 'unauthorized', 'you are the author of this post, its already saved in your profile under posts tab', array( 'status' => 401 ) );
        }

    } else {
        return false;
    }
    return true;
  }


   /**
   * Prepare the item for bookmark operation
   *
   * @param WP_REST_Request $request Request object
   * @return array of user_id, post_id, action(bookmark/unbookmark) | empty array if any request param is missing
   */
  public function prepare_item_for_database( $request ) {
    $prepared_data = array();
    $request_body = $request->get_json_params();

    $prepared_data['user_id'] = (int)mo_crypt($request_body['u'], 'd');
    $prepared_data['post_id'] = $request_body['c'];

    return $prepared_data;
  }

  /**
   * Clone Post
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $clone_data = $this->prepare_item_for_database( $request );
    if ( !empty( $clone_data ) && is_array( $clone_data ) ) {

        if ( function_exists( 'mo_clone_post' ) ) {
            $result = mo_clone_post($clone_data);

            if (!empty($result)) {
              	$response = array( 'message' =>  $result['message'], 'url'  => $result['url'] );
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>