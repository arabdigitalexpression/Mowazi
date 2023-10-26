<?php
class new_pw_controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
      $path = 'forget-pw';
      

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
    // email_exists( $request_body ) 
    return $request_body;
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
    $user_data = $this->prepare_item_for_database( $request );

    $redirect_url = get_site_url();

    if ( !empty( $user_data ) && is_array( $user_data ) ) {
        if ( function_exists( 'mo_new_pw' ) ) {
            $email = mo_new_pw($user_data['email']);
            if ($email) {
                $user_message = 'تم ارسال الايميل بنجاح من فضلك اذهب اللي حسابك';
            } else {
                $error_msg = 'هذا الحساب غير مسجل';
                return new WP_Error( 'invalid-info', $error_msg, array( 'status' => 403 ) );
            }
        $response = array( 'url'  =>  $redirect_url, 'message' =>  $user_message);
        return new WP_REST_Response( $response, 200 );
        }
    }
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
    }
}
?>