<?php
class Update_User extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'update-user';

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
    return true;
  }


   /**
   * Prepare the item for create operation
   *
   * @param WP_REST_Request $request Request object
   * @return array of new group information
   */
  public function prepare_item_for_database( $request ) {
    $user_info = array();

    if ( $_POST && !empty( $_POST ) ) {

        if ( isset( $_POST['u'] ) ) {
            $user_info['user_id'] = (int)mo_crypt($_POST['u'], 'd');
        }

        if ( isset( $_POST['fullname'] ) ) {
            $user_info['fullname'] = $_POST['fullname'];
        }

        if ( isset( $_POST['desc'] ) ) {
            $user_info['desc'] = $_POST['desc'];
        }

        if ( isset( $_POST['bdate'] ) ) {
            $user_info['bdate'] = $_POST['bdate'];
        }

        if ( isset( $_POST['email'] ) ) {
            $user_info['email'] = $_POST['email'];
        }

    }

    if ( $_FILES && !empty( $_FILES ) ) {

        include_once( ABSPATH . 'wp-admin/includes/image.php' );
        include_once( ABSPATH . 'wp-admin/includes/file.php' );
        include_once( ABSPATH . 'wp-admin/includes/media.php' );

        $uploadedfile = $_FILES['userPhoto'];
        $attachment_id = media_handle_sideload($uploadedfile, 0);

          if ( !is_wp_error( $attachment_id ) ) {
            $user_info['photo_id'] = $attachment_id;
          }

    }
    
    return $user_info;
  }

  /**
   * create group
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $user_info = $this->prepare_item_for_database( $request );
 
    if ( !empty( $user_info ) ) {

        if ( function_exists( 'mo_update_user' ) ) {
            $result = mo_update_user($user_info);

            if (!empty($result) && $result) {
              	$response = array('message' =>  'تم تحديث البيانات');
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>