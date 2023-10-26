<?php
class Delete_Post extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'delete-post';

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
        $post_group = get_post_meta( $post_id, 'mo_workshop_shared_with', true );

        // user not logged in
        if ($cur_user == 0) {
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من حذف هذا المحتوى', array( 'status' => 401 ) );
        }

        // if post was in group check if cur user is in this group
        if ( !empty( $post_group ) && $post_group !== 'all' ) {
            $group_admins = get_post_meta( $post_group, 'mo_group_admins', true );
            $group_members = get_post_meta( $post_group, 'mo_group_members', true );
            $admins = array();
            $members = array();

            foreach ($group_admins as $admin) {
                if ( isset( $admin['user_id'] ) && !in_array( $admin['user_id'], $admins ) ) {
                    $admins[] = $admin['user_id'];
                }
            }

            foreach ($group_members as $member) {
                if ( isset( $member['user_id'] ) && !in_array( $member['user_id'], $members ) ) {
                    $members[] = $member['user_id'];
                }
            }

            if ( !in_array( $cur_user, $admins ) && !in_array( $cur_user, $members ) ) {
                return new WP_Error( 'unauthorized', 'غير مسموح لك بحذف هذا المحتوى', array( 'status' => 401 ) );
            }
        } elseif ( !empty( $post_author ) && (int)$post_author !== $cur_user ) {
            return new WP_Error( 'unauthorized', 'غير مسموح لك بحذف هذا المحتوى', array( 'status' => 401 ) );
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

        if ( function_exists( 'mo_delete_post' ) ) {
            $post_deleted = mo_delete_post($post_data);

            if ( $post_deleted ) {
                $response = array('message' =>  'post deleted');
                return new WP_REST_Response( $response, 200 );
            }
        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>