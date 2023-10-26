<?php
class Read_Notification extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'read-notification';

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
    $request_body = $request->get_json_params();
    $user_id = (int)mo_crypt($request_body['u'], 'd');
    
    return $user_id;
  }

  /**
   * create group
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $user_id = $this->prepare_item_for_database( $request );
    if ( !empty( $user_id ) && $user_id !== 0 ) {

        if ( function_exists( 'mo_read_notification' ) ) {
            $result = mo_read_notification($user_id);

            if ($result) {
              	$response = array('read' =>  true);
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>