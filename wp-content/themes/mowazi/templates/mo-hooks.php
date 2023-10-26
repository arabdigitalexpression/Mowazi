<?php
////////////////////////////////////////////////////////
// add custom rest routes actions
function mo_get_page_rest_init() {
	$get_page_controller = new Get_Page_Controller();
	$get_page_controller->register_routes();
}

function mo_register_rest_init() {
	$register_controller = new Register_Controller();
	$register_controller->register_routes();
}

function mo_validate_username_rest_init() {
	$validate_username_controller = new Validate_Username_Controller();
	$validate_username_controller->register_routes();
}

function mo_validate_email_number_rest_init() {
	$validate_email_number_controller = new Validate_Email_Number_Controller();
	$validate_email_number_controller->register_routes();
}

function mo_login_rest_init() {
	$login_controller = new Login_Controller();
	$login_controller->register_routes();
}
function mo_new_pw_rest_init() {
	$pw_controller = new new_pw_controller();
	$pw_controller->register_routes();
}

function mo_logout_rest_init() {
	$logout_controller = new Logout_Controller();
	$logout_controller->register_routes();
}

function mo_create_post_rest_init() {
	$create_post_controller = new Create_Post();
	$create_post_controller->register_routes();
}

function mo_publish_post_rest_init() {
	$publish_post_controller = new Publish_Post();
	$publish_post_controller->register_routes();
}

function mo_get_post_rest_init() {
	$get_post_controller = new Get_Post();
	$get_post_controller->register_routes();
}

function mo_comment_rest_init() {
	$comment_controller = new Comment();
	$comment_controller->register_routes();
}

function mo_get_profile_rest_init() {
	$get_profile_controller = new Get_Profile_Controller();
	$get_profile_controller->register_routes();
}

function mo_get_archive_rest_init() {
	$get_archive_controller = new Get_Archive_Controller();
	$get_archive_controller->register_routes();
}

function mo_bookmark_rest_init() {
	$bookmark_controller = new Bookmark_Post();
	$bookmark_controller->register_routes();
}

function mo_tags_rest_init() {
	$tags_controller = new Tags_Controller();
	$tags_controller->register_routes();
}

function mo_fetch_activity_rest_init() {
	$fetch_activity_controller = new Fetch_Activity_Controller();
	$fetch_activity_controller->register_routes();
}

function mo_facilitators_rest_init() {
	$facilitators_controller = new Facilitators_Controller();
	$facilitators_controller->register_routes();
}

function mo_create_group_rest_init() {
	$create_group_controller = new Create_Group();
	$create_group_controller->register_routes();
}

function mo_update_group_rest_init() {
	$update_group_controller = new Update_Group();
	$update_group_controller->register_routes();
}

function mo_delete_post_rest_init() {
	$delete_post_controller = new Delete_Post();
	$delete_post_controller->register_routes();
}

function mo_report_post_rest_init() {
	$report_post_controller = new Report_Post();
	$report_post_controller->register_routes();
}

function mo_load_all_rest_init() {
	$load_all_controller = new Load_All_Controller();
	$load_all_controller->register_routes();
}

function mo_get_search_rest_init() {
	$get_search_controller = new Get_Search_Controller();
	$get_search_controller->register_routes();
}

function mo_get_search_side_rest_init() {
	$get_search_side_controller = new Get_Search_Side_Controller();
	$get_search_side_controller->register_routes();
}

function mo_get_tag_rest_init() {
	$get_tag_controller = new Get_Tag_Controller();
	$get_tag_controller->register_routes();
}

function mo_update_user_rest_init() {
	$update_user_controller = new Update_User();
	$update_user_controller->register_routes();
}

function mo_read_notification_rest_init() {
	$read_notification_controller = new Read_Notification();
	$read_notification_controller->register_routes();
}

function mo_upload_post_attachment_rest_init() {
	$upload_post_attachment_controller = new Upload_Post_Attachment();
	$upload_post_attachment_controller->register_routes();
}

function mo_add_post_material_rest_init() {
	$add_post_material_controller = new Add_Post_Material();
	$add_post_material_controller->register_routes();
}
function moـremove_post_material_rest_init() {
	$remove_post_material_controller = new Remove_Post_Material();
	$remove_post_material_controller->register_routes();
}

function mo_clone_rest_init() {
	$clone_controller = new Clone_Post();
	$clone_controller->register_routes();
}

// add the action 
add_action( 'rest_api_init', 'mo_get_page_rest_init' );
add_action( 'rest_api_init', 'mo_register_rest_init' );
add_action( 'rest_api_init', 'mo_validate_username_rest_init' );
add_action( 'rest_api_init', 'mo_validate_email_number_rest_init' );
add_action( 'rest_api_init', 'mo_login_rest_init' );
add_action( 'rest_api_init', 'mo_new_pw_rest_init' );
add_action( 'rest_api_init', 'mo_logout_rest_init' );
add_action( 'rest_api_init', 'mo_create_post_rest_init' );
add_action( 'rest_api_init', 'mo_publish_post_rest_init' );
add_action( 'rest_api_init', 'mo_get_post_rest_init' );
add_action( 'rest_api_init', 'mo_comment_rest_init' );
add_action( 'rest_api_init', 'mo_get_profile_rest_init' );
add_action( 'rest_api_init', 'mo_get_archive_rest_init' );
add_action( 'rest_api_init', 'mo_bookmark_rest_init' );
add_action( 'rest_api_init', 'mo_tags_rest_init' );
add_action( 'rest_api_init', 'mo_fetch_activity_rest_init' );
add_action( 'rest_api_init', 'mo_facilitators_rest_init' );
add_action( 'rest_api_init', 'mo_create_group_rest_init' );
add_action( 'rest_api_init', 'mo_update_group_rest_init' );
add_action( 'rest_api_init', 'mo_delete_post_rest_init' );
add_action( 'rest_api_init', 'mo_report_post_rest_init' );
add_action( 'rest_api_init', 'mo_load_all_rest_init' );
add_action( 'rest_api_init', 'mo_get_search_rest_init' );
add_action( 'rest_api_init', 'mo_get_search_side_rest_init' );
add_action( 'rest_api_init', 'mo_get_tag_rest_init' );
add_action( 'rest_api_init', 'mo_update_user_rest_init' );
add_action( 'rest_api_init', 'mo_read_notification_rest_init' );
add_action( 'rest_api_init', 'mo_upload_post_attachment_rest_init' );
add_action( 'rest_api_init', 'mo_add_post_material_rest_init' );
add_action( 'rest_api_init', 'moـremove_post_material_rest_init' );
add_action( 'rest_api_init', 'mo_clone_rest_init' );
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// filter excerpt length
function mo_change_excerpt_length( $length ) {
	// Don't change anything inside /wp-admin/
	if ( is_admin() ) {
		return $length;
	}
	// Set excerpt length to 32 words
	return 32;
}
// "999" priority makes this run last of all the functions hooked to this filter, meaning it overrides them
add_filter( 'excerpt_length', 'mo_change_excerpt_length', 999 );
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// filter excerpt more link to dots only
function mo_change_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	return ' ...';
 }
 add_filter( 'excerpt_more', 'mo_change_excerpt_more', 999 );
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// remove the default wordpress avatar from user profile page admin
add_filter( 'option_show_avatars', '__return_false' );
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// custom body classes
add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
	$classes = array();
	$classes[] = 'd-flex';
	$classes[] = 'flex-column';
	$classes[] = 'h-100';
	$context = isset( $_GET['c'] ) ? $_GET['c'] : '';

	if ( is_author() || ( is_single() && mo_is_post_author() && $context === 'edit' ) || is_singular('groups') ) {
		$classes[] = 'fixed-sidebar';
	}

	if (is_post_type_archive()) {
		$classes[] = 'bg-' . get_queried_object()->name;
	}

    return $classes;
}
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// load more link filter
// $value -> a tag to filter and return
// $posts -> string or array of posts to return link for | accept mix of post types array or string of 'bookmarks' to use with user bookmarks or string 'all' to get all posts
// $excluded_posts ->	array of post ids to exclude from the count logic | false to ignore
// $terms -> array of terms to exclude/include | false to ignore
// $include -> bool | true for include the terms or false to exclude
// $user_id -> int | or 0 if not logged in
// $number -> int | number of posts to test returning the link against (ex: if post count > 2 show the link)
function return_load_more_link( $value, $posts, $excluded_posts, $terms, $include, $user_id, $number ) {
	$load_more_link = '';
	$tax_query = array();

	if ( $terms && is_array( $terms ) ) {
		if ( $include ) {
			$operator = 'IN';
		} else {
			$operator = 'NOT IN';
		}

		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
            'terms'    => $terms,
            'operator'  =>  $operator
		);
	}

	if ( !is_array( $excluded_posts ) || empty( $excluded_posts ) ) {
		$excluded_posts = array();
	}

	// if is user bookmarks
	if ( !is_array( $posts ) && $posts == 'bookmarks' ) {
		
		$user_bookmarks = get_user_meta( $user_id, 'user_bookmarks', true );
        $user_bookmarks_arr = array();

        if ( !empty($user_bookmarks) ) {
		    $user_bookmarks_arr = explode( ',', $user_bookmarks );
		    $bookmarks_count = count($user_bookmarks_arr);

		    if ( $bookmarks_count > $number ) {
		    	$value = str_ireplace( array('data-load'), array('data-load="bookmarks"'), $value);
		    	$load_more_link = $value;
			    return $load_more_link;
		    }
		}


	} elseif ( !is_array( $posts ) && $posts == 'all' ) { // all posts
		$posts = array( 'articles', 'activities', 'stories', 'games', 'workshops' );
	}

	// count posts
	$posts_query = get_posts( array(
	    'post_type'         =>  $posts,
	    'post_status'       =>  'publish',
	    'posts_per_page'    =>  -1,
	    'fields'            =>  'ids',
	    'post__not_in'      =>  $excluded_posts,
	    'tax_query'         => $tax_query,
	    'post_parent'		=>	0
	) );

	if ( count($posts_query) > $number ) {
		$data_load = 'data-load=\'' . json_encode( $posts ) . '\'';

		// if terms were included add them to th data attr to use later with the fetch call
		if ( $include && !empty( $terms ) ) {
			$data_load .= '  ' . 'data-cat=\'' . json_encode( $terms ) . '\'';
		}

		$value = str_ireplace( array('data-load'), array($data_load), $value);
    	$load_more_link = $value;
	}
    
    return $load_more_link;
}
add_filter( 'load_more_link', 'return_load_more_link', 10, 7 );
?>