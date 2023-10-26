<?php
class Validate_Username_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'validate-username';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to get items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> always return true to allow validating email
   */
  public function create_item_permissions_check( $request ) {
    return true;
  }


   /**
   * Prepare the item for response operation
   *
   * @param WP_REST_Request $request Request object
   * @return array $username
   */
  public function prepare_item_for_database( $request ) {
    $request_body = $request->get_body_params();
    $username = '';

    if ( $request_body && !empty($request_body) && isset($request_body['username']) ) {
        $username = $request_body['username'];
    }

    return $username;
  }

  /**
   * get page
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $prepared_data = $this->prepare_item_for_database( $request );

    if ( !empty($prepared_data) && function_exists( 'mo_validate_username' ) ) {

          $result = mo_validate_username($prepared_data);

      	  $data = array( 'valid'  =>  $result );
          return new WP_REST_Response( $data, 200 );

    }
 
    return new WP_Error( 'not-found', 'not found', array( 'status' => 404 ) );
  }
 
  
}
?>