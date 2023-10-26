<?php
class Facilitators_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'facilitators';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::READABLE,
  			'callback'            => array( $this, 'get_items' ),
  			'permission_callback' => array( $this, 'get_items_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to get facilitators
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> return true to allow everyone to fetch facilitators list
   */
  public function get_items_permissions_check( $request ) {
      return true;
  }


   /**
   * Prepare the item for the REST response
   *
   * @param mixed $item array of found useres ids
   * @param WP_REST_Request $request Request object
   * @return array --> array of users info array (name => $fullname, id => $user_id, url => $avatar_url)
   */
  public function prepare_item_for_response( $item, $request ) {
    $data = array();

    foreach ($item as $user_id) {
        $first_name = get_user_meta( $user_id, 'first_name', true );
        $last_name = get_user_meta( $user_id, 'last_name', true );
        $fullname = $first_name . ' ' . $last_name;
        $profile_avatar = wp_get_attachment_image_url( get_user_meta( $user_id, 'user_img_id', 1 ), 'avatar-xxs' );

        if ( !$profile_avatar ) {
            $profile_avatar = '';
        }

        $data[] = array(
            'name'  =>  $fullname,
            'id'    =>  $user_id,
            'url'   =>  $profile_avatar
        );
    }

    return $data;
  }

  /**
   * fetch facilitators
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function get_items( $request ) {
    $query_params = $request->get_query_params();

    if ( !empty( $query_params ) && isset( $query_params['q'] ) ) {
        
        if ( function_exists( 'mo_get_facilitators' ) ) {
            $facilitators = mo_get_facilitators($query_params['q']);

            if ( empty($facilitators) ) {
                return new WP_REST_Response( $facilitators, 200 );
            } 

            $response = $this->prepare_item_for_response( $facilitators, $request );
            return new WP_REST_Response( $response, 200 );                

        }

    }


    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>