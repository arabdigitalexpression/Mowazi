<?php
class Update_Group extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'update-group';

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

    if ( $_POST && !empty( $_POST ) && isset( $_POST['u'] ) ) {
        $cur_user = (int)mo_crypt($_POST['u'], 'd');

        // user not logged in
        if ($cur_user == 0) {
            return new WP_Error( 'unauthorized', 'يرجى تسجيل الدخول لتتمكن من تحديث المجموعة', array( 'status' => 401 ) );
        }

        if ( !isset( $_POST['g'] ) ) {
            return new WP_Error( 'not-found', 'المجموعة التي تحاول تحديثها غير موجودة', array( 'status' => 404 ) );
        }

        $group_id = $_POST['g'];
        $group_author = get_post_field( 'post_author', $group_id );


        if ( $cur_user == $group_author ) {
            return true;
        }

        $group_admins = get_post_meta( $group_id, 'mo_group_admins', true );

        if ( empty( $group_admins ) ) {
            return new WP_Error( 'unauthorized', 'أنت لست المنشئ أو المسؤول في هذه المجموعة ، لا يمكنك تحديث إعدادات المجموعة', array( 'status' => 401 ) );
        }

        foreach ($group_admins as $admin) {
            if ( isset( $admin['user_id'] ) && $admin['user_id'] == $cur_user ) {
                return true;
            }
        }

        return new WP_Error( 'unauthorized', 'أنت لست المنشئ أو المسؤول في هذه المجموعة ، لا يمكنك تحديث إعدادات المجموعة', array( 'status' => 401 ) );

    } else {
        return false;
    }

    return true;
  }


   /**
   * Prepare the item for create operation
   *
   * @param WP_REST_Request $request Request object
   * @return array of new group information
   */
  public function prepare_item_for_database( $request ) {
    $group_info = array();

    if ( $_POST && !empty( $_POST ) ) {

        if ( isset( $_POST['g'] ) ) {
            $group_info['id'] = $_POST['g'];
        }

        if ( isset( $_POST['title'] ) ) {
            $group_info['title'] = $_POST['title'];
        }

        if ( isset( $_POST['desc'] ) ) {
            $group_info['desc'] = $_POST['desc'];
        }

        if ( isset( $_POST['members'] ) ) {
            $group_info['members'] = $_POST['members'];
        }

        if ( isset( $_POST['admins'] ) ) {
            $group_info['admins'] = $_POST['admins'];
        }

        if ( isset( $_POST['u'] ) ) {
            $group_info['user_id'] = (int)mo_crypt($_POST['u'], 'd');
        }

    }

    if ( $_FILES && !empty( $_FILES ) ) {

        include_once( ABSPATH . 'wp-admin/includes/image.php' );
        include_once( ABSPATH . 'wp-admin/includes/file.php' );
        include_once( ABSPATH . 'wp-admin/includes/media.php' );

        $uploadedfile = $_FILES['groupPhoto'];
        $attachment_id = media_handle_sideload($uploadedfile, 0);

          if ( !is_wp_error( $attachment_id ) ) {
            $group_info['photo_id'] = $attachment_id;
          }

    }
    
    return $group_info;
  }

  /**
   * create group
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $group_info = $this->prepare_item_for_database( $request );
 
    if ( !empty( $group_info ) ) {

        if ( function_exists( 'mo_update_group' ) ) {
            $result = mo_update_group($group_info);

            $title = get_the_title($result['id']);
            $perma = get_permalink($result['id']);

            if (!empty($result)) {
              	$response = array('message' =>  'تم تحديث المجموعة');
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>