<?php
class Get_Archive_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'archive';

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
   * @return WP_Error|bool --> always return true to all anyone to view archives
   */
  public function create_item_permissions_check( $request ) {
    return true;
  }


   /**
   * Prepare the item for response operation
   *
   * @param WP_REST_Request $request Request object
   * @return array $post_type
   */
  public function prepare_item_for_database( $request ) {
    $request_body = $request->get_json_params();

    return $request_body;
  }

  /**
   * get archive
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $prepared_data = $this->prepare_item_for_database( $request );
    if ( function_exists( 'mo_get_archive' ) ) {

      $output_html = mo_get_archive($prepared_data);
      $page_title = $prepared_data['archive'];
      $page_perma = get_post_type_archive_link( $prepared_data['archive'] );
      $body_class = $request['archive'];

      if ( !empty($output_html) ) {
      	$data = array( 'html'	=>	$output_html["html"], 'title'  =>  $page_title, 'perma'  =>  $page_perma, 'class' => $body_class );
        return new WP_REST_Response( $data, 200 );
      }

    }
 
    return new WP_Error( 'not-found', 'not found', array( 'status' => 404 ) );
  }
 
  
}
?>