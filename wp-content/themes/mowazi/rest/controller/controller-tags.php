<?php
class Tags_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'tags';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::READABLE,
  			'callback'            => array( $this, 'get_items' ),
  			'permission_callback' => array( $this, 'get_items_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to get tags
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> return true to allow everyone to fetch tags
   */
  public function get_items_permissions_check( $request ) {
      return true;
  }


   /**
   * Prepare the item for the REST response
   *
   * @param mixed $item array of found tags
   * @param WP_REST_Request $request Request object
   * @return array --> array of tags info array (name => $tag_name, id => $tag_id)
   */
  public function prepare_item_for_response( $item, $request ) {
    $data = array();

    foreach ($item as $tag_id => $tag_name) {
        $data[] = array(
            'name'  =>  $tag_name,
            'id'    =>  $tag_id
        );
    }

    return $data;
  }

  /**
   * fetch tags
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function get_items( $request ) {
    $query_params = $request->get_query_params();

    if ( !empty( $query_params ) && isset( $query_params['q'] ) ) {
        
        if ( function_exists( 'mo_get_tags' ) ) {
            $tags = mo_get_tags($query_params['q']);

            if ( empty($tags) ) {
                return new WP_REST_Response( $tags, 200 );
            } 

            $response = $this->prepare_item_for_response( $tags, $request );
            return new WP_REST_Response( $response, 200 );                

        }

    }


    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>