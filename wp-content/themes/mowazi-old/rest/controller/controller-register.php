<?php
class Register_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'register';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to register
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> return true to allow everyone to register
   */
  public function create_item_permissions_check( $request ) {
      return true;
  }


   /**
   * Prepare the item for create operation
   *
   * @param WP_REST_Request $request Request object
   * @return array --> array of new user data
   */
  public function prepare_item_for_database( $request ) {
    $request_body = $request->get_json_params();
    return $request_body;
  }

  /**
   * register user
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $user_info = $this->prepare_item_for_database( $request );
    // var_dump($user_info);
    
    if ( is_array( $user_info ) && !empty( $user_info ) && !is_wp_error( $user_info ) ) {

        if ( function_exists( 'mo_register_user' ) ) {
            $user_register = mo_register_user($user_info);

            if ( !is_wp_error($user_register) ) {
                // hard redirect to homepage to force regenerating wp rest nonce and refresh cookies from visitor to logged in user
                $redirect_url = get_site_url();

              	$response = array( 'url'  =>  $redirect_url, 'message' =>  'تم تسجيل الدخول بنجاح، إعادة التوجيه ...');
                return new WP_REST_Response( $response, 200 );
                
            } else {
                return $user_register;
            }

        }

    }

    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>