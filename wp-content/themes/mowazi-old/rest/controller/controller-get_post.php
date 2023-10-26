<?php
class Get_Post extends WP_REST_Controller {

  public function register_routes() {
  	$namespace = 'mowazi/v1';
  	$path = 'post';

  	register_rest_route( $namespace, '/' . $path, array(
  		array(
  			'methods'             => WP_REST_Server::CREATABLE,
  			'callback'            => array( $this, 'create_item' ),
  			'permission_callback' => array( $this, 'create_item_permissions_check' )
  		),
  	));  
  }


  /**
   * Check if a given request has access to create a post
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool --> return true if post is public | wp_error if post is private and the visitor not the post author
   */
  public function create_item_permissions_check( $request ) {
    $request_body = $request->get_json_params();

    if (!empty($request_body) && isset($request_body['u']) && isset($request_body['p'])) {
        $cur_user = (int)mo_crypt($request_body['u'], 'd');
        $post_author = get_post_field( 'post_author', $request_body['p'] );
        $post_status = get_post_status( $request_body['p'] );

        if ( $post_status && !empty( $post_author ) ) {
            
            if ( $post_status == 'private' && (int)$post_author !== $cur_user ) {
               return new WP_Error( 'unauthorized', 'this post still in draft, you will be able to view it after the author publish it', array( 'status' => 401 ) );
            }

        }

    }

    return true;
  }


   /**
   * Prepare the item for create operation
   *
   * @param WP_REST_Request $request Request object
   * @return array of context (view/edit) / post_id and user_id
   */
  public function prepare_item_for_database( $request ) {
    $prepare_data = array();
    $request_body = $request->get_json_params();

    if (!empty($request_body) && isset($request_body['u']) && isset($request_body['p'])) {
        $prepare_data['post_id'] = $request_body['p'];
        $prepare_data['user_id'] = (int)mo_crypt($request_body['u'], 'd');
        $prepare_data['context'] = $request_body['c'];

        // $cur_user = (int)mo_crypt($request_body['u'], 'd');
        // $post_author = get_post_field( 'post_author', $request_body['p'] );

        // if ( (int)$post_author == $cur_user ) {
        //     $prepare_data['context'] = 'edit';
        // } else {
        //     $prepare_data['context'] = 'view';
        // }
    }

    return $prepare_data;
  }

  /**
   * login user
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Request
   */
  public function create_item( $request ) {
    $post_data = $this->prepare_item_for_database( $request );
 
    if ( !empty( $post_data ) && is_array( $post_data ) ) {

        if ( function_exists( 'mo_get_post' ) ) {
            $result = mo_get_post($post_data);

            $title = get_the_title($result['id']);
            $title = str_replace( 'Private: ', '', $title );
            $title = str_replace( 'خاص: ', '', $title );
            $perma = get_permalink($result['id']);

            if ( $post_data['context'] === 'edit' ) {
                $perma = esc_url( add_query_arg( 'c', 'edit', $perma ) );
            }

            if (!empty($result)) {
              	$response = array( 'html'  =>  $result["html"], 'nav'  =>  $result["nav"], 'perma'  =>  $perma, 'title'  =>  $title);
                return new WP_REST_Response( $response, 200 );
            }

        }

    }
 
    return new WP_Error( 'something-wrong', 'server error', array( 'status' => 500 ) );
  }
 
  
}
?>