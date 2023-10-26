<?php
class Login_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'login';

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
    $user_data = $this->prepare_item_for_database( $request );

    $redirect_url = get_site_url();
 
    if ( !empty( $user_data ) && is_array( $user_data ) ) {

        if ( function_exists( 'mo_login_user' ) ) {
            $user_login = mo_login_user($user_data);

            if (  is_wp_error($user_login) ) {

              $error_code = $user_login->get_error_code();

              if ($error_code == 'incorrect_password') {

                $error_msg = 'كلمة مرور خاطئة';

              } elseif($error_code == 'invalid_email') {

                $error_msg = 'اسم المستخدم خطأ';

              } else {
                
                $error_msg = $user_login->get_error_message();

              }

              return new WP_Error( 'invalid-info', $error_msg, array( 'status' => 403 ) );
            }

          	$response = array( 'url'  =>  $redirect_url, 'message' =>  'تم تسجيل الدخول بنجاح، إعادة التوجيه ...');
            return new WP_REST_Response( $response, 200 );
        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>