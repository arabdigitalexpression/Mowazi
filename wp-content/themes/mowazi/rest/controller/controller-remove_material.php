<?php
class Remove_Post_Material extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'remove-material';

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

    if ( $_POST && !empty( $_POST ) && isset( $_POST['p'] ) ) {

        if ( isset( $_POST['u'] ) ) {
            $user_info['user_id'] = (int)mo_crypt($_POST['u'], 'd');
        }

        if ( isset( $_POST['p'] ) ) {
            $user_info['p'] = $_POST['p'];
        }
        if ( isset( $_POST['deleted'] ) ) {
            $user_info['deleted'] = $_POST['deleted'];
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

        if ( function_exists( 'mo_remove_post_material' ) ) {
            $result = mo_remove_post_material($user_info);

            if (!empty($result) && $result) {
              	$response = array('message' =>  'تم مسح الخامات');
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>