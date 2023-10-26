<?php
class Publish_Post extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'publish-post';

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
        $post_author = get_post_field ('post_author', $post_id);
        $post_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );

        // user not logged in
        if ($cur_user == 0) {
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من نشر محتوى جديد', array( 'status' => 401 ) );
        } elseif ( !empty( $post_author ) && (int)$post_author !== $cur_user && !in_array( $cur_user, $post_collaborators ) && !mo_check_group_post( $post_id, $user_id ) ) {
            return new WP_Error( 'unauthorized', 'غير مسموح لك بتحديث هذا المحتوى', array( 'status' => 401 ) );
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

        if ( function_exists( 'mo_publish_post' ) ) {
            $post_created = mo_publish_post($post_data);

            if ( !empty( $post_created ) ) {
                $title = get_the_title($post_created['id']);
                $title = str_replace( 'Private: ', '', $title );
                $title = str_replace( 'خاص: ', '', $title );
                $perma = get_permalink($post_created['id']);

                $status = get_post_status($post_created['id']);

                if($status == 'private'){
                  $message = 'تم حفظ المحتوى بنجاح';
                }else{
                  $message = 'تم نشر المحتوى بنجاح';
                }

                $response = array( 'html'  =>  $post_created["html"], 'nav'  =>  $post_created["nav"], 'perma'  =>  $perma, 'title'  =>  $title, 'message' => $message);
                return new WP_REST_Response( $response, 200 );
            }
        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>