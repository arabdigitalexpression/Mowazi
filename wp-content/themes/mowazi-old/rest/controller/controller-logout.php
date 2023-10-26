<?php
class Logout_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'logout';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to logout
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> false if user not logged in
   */
  public function create_item_permissions_check( $request ) {
    $request_body = $request->get_json_params();

    if (!empty($request_body) && isset($request_body['u'])) {
        $user_id = (int)mo_crypt($request_body['u'], 'd');

        return $user_id !== 0;
    }

    return false;

  }


   /**
   * Prepare the item for create operation
   *
   * @param WP_REST_Request $request Request object
   * @return int $user_id
   */
  public function prepare_item_for_database( $request ) {
    $request_body = $request->get_json_params();
    $user_id = (int)mo_crypt($request_body['u'], 'd');

    return $user_id;
  }

  /**
   * logout user
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $user_id = $this->prepare_item_for_database( $request );
    $site_url = get_site_url();
 
    if ( $user_id ) {

        if ( function_exists( 'mo_logout_user' ) ) {
            $user_logout = mo_logout_user();

          	$response = array( 'url'  =>  $site_url, 'message'   => 'تم تسجيل الخروج بنجاح');
            return new WP_REST_Response( $response, 200 );
        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>