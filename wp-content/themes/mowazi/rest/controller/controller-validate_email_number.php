<?php
class Validate_Email_Number_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'validate-emailnumber';

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
   * @return string $field
   */
  public function prepare_item_for_database( $request ) {
    $request_body = $request->get_body_params();
    $field = '';

    if ( $request_body && !empty($request_body) && isset($request_body['emailnumber']) ) {
        $field = $request_body['emailnumber'];
    }

    return $field;
  }

  /**
   * get page
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $prepared_data = $this->prepare_item_for_database( $request );

    if ( !empty($prepared_data) && function_exists( 'mo_validate_email_number' ) ) {

          $result = mo_validate_email_number($prepared_data);

      	  $data = array( 'valid'  =>  $result );
          return new WP_REST_Response( $data, 200 );

    }
 
    return new WP_Error( 'not-found', 'not found', array( 'status' => 404 ) );
  }
 
  
}
?>