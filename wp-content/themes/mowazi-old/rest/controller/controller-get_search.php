<?php
class Get_Search_Controller extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'search';

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
    if ( function_exists( 'mo_get_search' ) ) {

      $output_html = mo_get_search($prepared_data);
      $page_title = 'نتائج البحث';
      $page_perma = get_permalink( 17 );
      $types_q;
      $participants_q;
      $age_q;
      $duration_q;
      $keyword_q;

        if ( isset( $prepared_data['types'] ) && !empty( $prepared_data['types'] ) ) {
            $types = $prepared_data['types'];

            $types_q = implode( ',', $types );

        }

        if ( isset( $prepared_data['participants'] ) && !empty( $prepared_data['participants'] ) ) {
            $participants_q = $prepared_data['participants'];
        }

        if ( isset( $prepared_data['age'] ) && !empty( $prepared_data['age'] ) ) {
            $age_q = $prepared_data['age'];
        }

        if ( isset( $prepared_data['duration'] ) && !empty( $prepared_data['duration'] ) ) {
            $duration_q = $prepared_data['duration'];
        }

        if ( isset( $prepared_data['keyword'] ) && !empty( $prepared_data['keyword'] ) ) {
            $keyword_q = $prepared_data['keyword'];
        }

      $page_perma = esc_url_raw( add_query_arg( array(
        't' =>  $types_q,
        'p' =>  $participants_q,
        'a' =>  $age_q,
        'd' =>  $duration_q,
        'k' =>  $keyword_q
      ), $page_perma ) );

      if ( !empty($output_html) ) {
      	$data = array( 'html'	=>	$output_html, 'title'  =>  $page_title, 'perma'  =>  $page_perma );
        return new WP_REST_Response( $data, 200 );
      }

    }
 
    return new WP_Error( 'not-found', 'not found', array( 'status' => 404 ) );
  }
 
  
}
?>