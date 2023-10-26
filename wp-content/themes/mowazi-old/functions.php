<?php
////////////////////////////////////////////////////////////////////////
// Theme styles and scripts
function add_theme_scripts() {
  // wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css', array(), null);
  wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Cairo:400,700|Tajawal&display=swap&subset=arabic', array(), null);
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), null);
  wp_enqueue_style( 'bootstrap-validator', get_template_directory_uri() . '/css/bootstrapValidator.min.css', array(), null);
  wp_enqueue_style( 'dragula-css', get_template_directory_uri() . '/css/dragula.min.css', array(), null);
  wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.11/css/select2.min.css', array(), null); //select2 library
  wp_enqueue_style( 'uppy', 'https://transloadit.edgly.net/releases/uppy/v1.8.0/uppy.min.css', array(), null); 
  // dev style, remove on production
  wp_enqueue_style( 'style-dev', get_template_directory_uri() . '/assets/css/style.css', array(), '19');
  // production min style, use on production
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  
  wp_enqueue_script('jquery');
  wp_enqueue_script( 'domready', get_template_directory_uri() . '/js/ready.min.js', array (), null, true);
  wp_enqueue_script( 'promise', get_template_directory_uri() . '/js/polyfill.min.js', array (), null, true);
  wp_enqueue_script( 'fetch',  get_template_directory_uri() . '/js/fetch.umd.js', array (), null, true);
  wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array ( 'jquery' ), null, true);
  wp_enqueue_script( 'dragula', get_template_directory_uri() . '/js/dragula.min.js', array (), null, true);
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array ( 'jquery', 'popper' ), null, true);
  wp_enqueue_script( 'bootstrap-validator', get_template_directory_uri() . '/js/bootstrapValidator.min.js', array ( 'jquery' ), null, true);
  wp_enqueue_script( 'select2', get_template_directory_uri() . '/js/select2.min.js', array ( 'jquery'), null, true); //select2 library
  wp_enqueue_script( 'tinymce', get_template_directory_uri() . '/tinymce/tinymce.min.js', array ( 'jquery'), null, true); 
  wp_enqueue_script( 'jquery-tinymce', get_template_directory_uri() . '/tinymce/jquery.tinymce.min.js', array ( 'jquery' , 'tinymce'), null, true); 
  wp_enqueue_script( 'uppy', 'https://transloadit.edgly.net/releases/uppy/v1.8.0/uppy.min.js', array () ,  null, true); 
  // dev scripts, remove on production
  wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/js/app.js', array ( 'jquery' ), '19', true);
  wp_enqueue_script( 'mo-fetch', get_template_directory_uri() . '/assets/js/mo-fetch.js', array ( 'domready' ), '19', true);
  wp_localize_script( 'mo-fetch', 'wpApiSettings', array(
    'sitename'  =>  ' - ' . get_bloginfo('name'),
    'siteurl'  => get_bloginfo('url'),
    'root' => esc_url_raw( rest_url() . 'mowazi/v1/' ),
    'nonce' => wp_create_nonce( 'wp_rest' )
  ) );
  //production min js, use on production
  // wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', array ( 'jquery' ), '1', true);
  // wp_enqueue_script( 'mo-fetch', get_template_directory_uri() . '/js/mo-fetch.js', array ( 'domready' ), '1', true);
 
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
//remove admin bar
add_filter('show_admin_bar', '__return_false');
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
//Change wp_mail From name
add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name ) {
    return "Mowazi";
}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// Add Featured Image to Posts
add_theme_support( 'post-thumbnails' );
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
// custom cropping sizes
add_image_size( 'avatar-xxs', 22, 22, true ); // avatar extra extra small
add_image_size( 'avatar-xs', 30, 30, true ); // avatar extra small
add_image_size( 'avatar-sm', 35, 35, true ); // avatar small
add_image_size( 'avatar-default', 40, 40, true ); // avatar default
add_image_size( 'avatar-md', 45, 45, true ); // avatar medium
add_image_size( 'avatar-lg', 52, 52, true ); // avatar large
add_image_size( 'avatar-xl', 130, 130, true ); // avatar extra large
add_image_size( 'card-img', 400, 100, true ); // card image top


// Register the sizes for use in Add Media modal
add_filter( 'image_size_names_choose', 'wpshout_custom_sizes' );
function wpshout_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'avatar-xxs' => __( 'Avatar Extra Extra Small' ),
        'avatar-xs' => __( 'Avatar Extra Small' ),
        'avatar-sm' => __( 'Avatar Small' ),
        'avatar-default' => __( 'Avatar Default' ),
        'avatar-md' => __( 'Avatar Medium' ),
        'avatar-lg' => __( 'Avatar Large' ),
        'avatar-xl' => __( 'Avatar Extra Large' ),
        'card-img' => __( 'Post card image' ),
    ) );
}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// let wordpress manage title tag
function theme_title_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_title_setup' );
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// remove meta generator
remove_action('wp_head', 'wp_generator');
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
//add custom rest controllers functions
require_once get_template_directory() . ('/rest/mo-functions.php');
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
//add custom rest controllers
require_once get_template_directory() . ('/rest/controllers.php');
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// Register Custom action action
require_once get_template_directory() . '/templates/mo-hooks.php';
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
/**
* Encrypt and decrypt
* 
* @author Nazmul Ahsan <n.mukto@gmail.com>
* @link http://nazmulahsan.me/simple-two-way-function-encrypt-decrypt-string/
*
* @param string $string string to be encrypted/decrypted
* @param string $action what to do with this? e for encrypt, d for decrypt
*/
function mo_crypt( $string, $action = 'e' ) {
// you may change these values to your own
$secret_key = 'mo_secret_key';
$secret_iv = 'mo_secret_iv';
$output = false;
$encrypt_method = "AES-256-CBC";
$key = hash( 'sha256', $secret_key );
$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
if( $action == 'e' ) {
$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
}
else if( $action == 'd' ){
$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
}
return $output;
}
////////////////////////////////////////////////////////////////////////

// facilitator user role
// remove_role( 'facilitator' );
$role = add_role( 'facilitator', 'Facilitator', array(
    'edit_published_posts' => true,
    'upload_files' => true,
    'publish_posts' => true,
    'delete_published_posts' => true,
    'edit_posts' => true,
    'delete_posts' => true,
    'read' => true,
) );
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
// post types
// Register Articles Post Type
function articles_post_type() {

  $labels = array(
    'name'                  => _x( 'Articles', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Article', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Articles', 'text_domain' ),
    'name_admin_bar'        => __( 'Article', 'text_domain' ),
    'archives'              => __( 'Item Archives', 'text_domain' ),
    'attributes'            => __( 'Item Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
    'all_items'             => __( 'All Items', 'text_domain' ),
    'add_new_item'          => __( 'Add New Item', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Item', 'text_domain' ),
    'edit_item'             => __( 'Edit Item', 'text_domain' ),
    'update_item'           => __( 'Update Item', 'text_domain' ),
    'view_item'             => __( 'View Item', 'text_domain' ),
    'view_items'            => __( 'View Items', 'text_domain' ),
    'search_items'          => __( 'Search Item', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
    'items_list'            => __( 'Items list', 'text_domain' ),
    'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Article', 'text_domain' ),
    'description'           => __( 'Site articles.', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'articles', $args );

}
add_action( 'init', 'articles_post_type', 0 );

// Register Activities Post Type
function activities_post_type() {

  $labels = array(
    'name'                  => _x( 'Activities', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Activity', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Activities', 'text_domain' ),
    'name_admin_bar'        => __( 'Activity', 'text_domain' ),
    'archives'              => __( 'Activity Archives', 'text_domain' ),
    'attributes'            => __( 'Activity Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Activity:', 'text_domain' ),
    'all_items'             => __( 'All Items', 'text_domain' ),
    'add_new_item'          => __( 'Add New Activity', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Activity', 'text_domain' ),
    'edit_item'             => __( 'Edit Activity', 'text_domain' ),
    'update_item'           => __( 'Update Activity', 'text_domain' ),
    'view_item'             => __( 'View Activity', 'text_domain' ),
    'view_items'            => __( 'View Items', 'text_domain' ),
    'search_items'          => __( 'Search Activity', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into Activity', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Activity', 'text_domain' ),
    'items_list'            => __( 'Activities list', 'text_domain' ),
    'items_list_navigation' => __( 'Activities list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter Activities list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Activity', 'text_domain' ),
    'description'           => __( 'Site activities.', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'activities', $args );

}
add_action( 'init', 'activities_post_type', 0 );

// Register Stories Post Type
function stories_post_type() {

  $labels = array(
    'name'                  => _x( 'Stories', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Story', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Stories', 'text_domain' ),
    'name_admin_bar'        => __( 'Story', 'text_domain' ),
    'archives'              => __( 'Story Archives', 'text_domain' ),
    'attributes'            => __( 'Story Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Story:', 'text_domain' ),
    'all_items'             => __( 'All Stories', 'text_domain' ),
    'add_new_item'          => __( 'Add New Story', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Story', 'text_domain' ),
    'edit_item'             => __( 'Edit Story', 'text_domain' ),
    'update_item'           => __( 'Update Story', 'text_domain' ),
    'view_item'             => __( 'View Story', 'text_domain' ),
    'view_items'            => __( 'View Stories', 'text_domain' ),
    'search_items'          => __( 'Search Story', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into Story', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Story', 'text_domain' ),
    'items_list'            => __( 'Stories list', 'text_domain' ),
    'items_list_navigation' => __( 'Stories list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter Stories list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Story', 'text_domain' ),
    'description'           => __( 'Site stories.', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'stories', $args );

}
add_action( 'init', 'stories_post_type', 0 );

// Register Games Post Type
function games_post_type() {

  $labels = array(
    'name'                  => _x( 'Games', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Game', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Games', 'text_domain' ),
    'name_admin_bar'        => __( 'Game', 'text_domain' ),
    'archives'              => __( 'Game Archives', 'text_domain' ),
    'attributes'            => __( 'Game Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Game:', 'text_domain' ),
    'all_items'             => __( 'All Games', 'text_domain' ),
    'add_new_item'          => __( 'Add New Game', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Game', 'text_domain' ),
    'edit_item'             => __( 'Edit Game', 'text_domain' ),
    'update_item'           => __( 'Update Game', 'text_domain' ),
    'view_item'             => __( 'View Game', 'text_domain' ),
    'view_items'            => __( 'View Games', 'text_domain' ),
    'search_items'          => __( 'Search Game', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into Game', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Game', 'text_domain' ),
    'items_list'            => __( 'Games list', 'text_domain' ),
    'items_list_navigation' => __( 'Games list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter Games list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Game', 'text_domain' ),
    'description'           => __( 'Site games.', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'games', $args );

}
add_action( 'init', 'games_post_type', 0 );

// Register Workshops Post Type
function workshops_post_type() {

  $labels = array(
    'name'                  => _x( 'Workshops', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Workshop', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Workshops', 'text_domain' ),
    'name_admin_bar'        => __( 'Workshop', 'text_domain' ),
    'archives'              => __( 'Workshop Archives', 'text_domain' ),
    'attributes'            => __( 'Workshop Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Workshop:', 'text_domain' ),
    'all_items'             => __( 'All Workshops', 'text_domain' ),
    'add_new_item'          => __( 'Add New Workshop', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Workshop', 'text_domain' ),
    'edit_item'             => __( 'Edit Workshop', 'text_domain' ),
    'update_item'           => __( 'Update Workshop', 'text_domain' ),
    'view_item'             => __( 'View Workshop', 'text_domain' ),
    'view_items'            => __( 'View Workshops', 'text_domain' ),
    'search_items'          => __( 'Search Workshop', 'text_domain' ),
    'not_found'             => __( 'Not found', 'text_domain' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
    'featured_image'        => __( 'Featured Image', 'text_domain' ),
    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
    'insert_into_item'      => __( 'Insert into Workshop', 'text_domain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Workshop', 'text_domain' ),
    'items_list'            => __( 'Workshops list', 'text_domain' ),
    'items_list_navigation' => __( 'Workshops list navigation', 'text_domain' ),
    'filter_items_list'     => __( 'Filter Workshops list', 'text_domain' ),
  );
  $args = array(
    'label'                 => __( 'Workshop', 'text_domain' ),
    'description'           => __( 'Site workshops', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions', 'page-attributes' ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
  );
  register_post_type( 'workshops', $args );

}
add_action( 'init', 'workshops_post_type', 0 );

// Register Groups Post Type
function groups_post_type() {

    $labels = array(
        'name'                  => _x( 'Groups', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Group', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Groups', 'text_domain' ),
        'name_admin_bar'        => __( 'Groups', 'text_domain' ),
        'archives'              => __( 'Group Archives', 'text_domain' ),
        'attributes'            => __( 'Group Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Group:', 'text_domain' ),
        'all_items'             => __( 'All Groups', 'text_domain' ),
        'add_new_item'          => __( 'Add New Group', 'text_domain' ),
        'add_new'               => __( 'Add New', 'text_domain' ),
        'new_item'              => __( 'New Group', 'text_domain' ),
        'edit_item'             => __( 'Edit Group', 'text_domain' ),
        'update_item'           => __( 'Update Group', 'text_domain' ),
        'view_item'             => __( 'View Group', 'text_domain' ),
        'view_items'            => __( 'View Groups', 'text_domain' ),
        'search_items'          => __( 'Search Group', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Group', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Group', 'text_domain' ),
        'items_list'            => __( 'Groups list', 'text_domain' ),
        'items_list_navigation' => __( 'Groups list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Groups list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Group', 'text_domain' ),
        'description'           => __( 'Mowazi groups post type', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'groups', $args );

}
add_action( 'init', 'groups_post_type', 0 );
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// CMB helpper functions
// generate participants range
function mo_generate_participants_range() {
    $range = range(1, 30);

    $result = array();

    foreach ($range as $key => $value) {
        $result[$value] = $value . ' فرد';
    }
    $result['na'] = 'لا ينطبق';
    return $result;
}

// generate participants range
function mo_generate_age_range() {
    $range = array(
        '4-7'      =>  '4-7 سنة',
        '8-12'      =>  '8-12 سنة',
        '13-16'     =>  '13-16 سنة',
        '17-20'     =>  '17-20 سنة',
        '21+'     =>  '21+ سنة',
        'na'        => 'لا ينطبق'
    );

    return $range;
}

// generate duration range
function mo_generate_duration_range() {
    $range = range(5, 55, 5);
    //$result = ;

    foreach ($range as $key => $value) {
        $result[$value] = $value . ' دقيقة';
    }

    $result['na'] = 'لا ينطبق';
    return $result;
}
function mo_generate_duration_range_hrs() {
    $range = range(0, 10, 1);
    //$result = ;

    foreach ($range as $key => $value) {
        $result[$value] = $value . ' ساعة';
    }

    $result['na'] = 'لا ينطبق';
    return $result;
}

// generate useres
function mo_generate_users() {
    $result = array();
    $users = get_users( array(
        'role'  =>  'facilitator'
    ) );

    if ( !empty( $users ) ) {
        foreach ($users as $user) {
            $result[$user->ID] = $user->display_name;
        }
    }

    return $result;
}

// generate groups
function mo_generate_groups( $field ) {
    $post_type = get_post_type( $field->object_id );
    $result = array();

    // field is rendered in workshops --> show "all" option
    // if ( $post_type == 'workshops' || $post_type == 'articles' ) {
    // }
    $result['all'] = 'الجميع';

    $groups = get_posts( array(
        'post_type'         =>  'groups',
        'nopaging'          =>  true,
        'posts_per_page'    =>  -1,
        'fields'            =>  'ids'
    ) );

    if ( !empty( $groups ) ) {
        foreach ($groups as $group) {
            $result[$group] = get_the_title( $group );
        }
    }

    return $result;
}

// generate delete reasons
function mo_generate_delete_reasons() {
    $reasons = array(
        '0'      =>  'محتوى غير متصل بالتعليم',
        '1'      =>  'محتوى غير قانوني أو ينتهك الخصوصيات وحقوق الملكية الفكرية',
        '2'      =>  'محتوى لا يشير إلى المصادر الأصلية',
        '3'      =>  'اخرى'
    );

    return $reasons;
}

// show metabox only on parent
function mo_show_only_on_parent_post( $cmb ) {
    if ( wp_get_post_parent_id( $cmb->object_id() ) && wp_get_post_parent_id( $cmb->object_id() ) !== 0 ) {
        return false;
    } else {
        return true;
    }

}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function mo_show_if_front_page( $cmb ) {
    // Don't show this metabox if it's not the front page template.
    if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
        return false;
    }
    return true;
}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// CMB init
/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/CMB2/init.php';
}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// user cmb
add_action( 'cmb2_admin_init', 'mo_register_user_profile_metabox' );
/**
 * Hook in and add a metabox to add fields to the user profile pages
 */
function mo_register_user_profile_metabox() {

  /**
   * Metabox for the user profile screen
   */
  $cmb_user = new_cmb2_box( array(
    'id'               => 'mo_user_extra_cmb',
    'title'            => esc_html__( 'User Profile Metabox', 'cmb2' ), // Doesn't output for user boxes
    'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
    'show_names'       => true,
    'new_user_section' => 'add-existing-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
  ) );

  $cmb_user->add_field( array(
    'name' => esc_html__( 'User Extra Information', 'cmb2' ),
    'id'   => 'user_extra_info_title',
    'type' => 'title',
  ) );

  $cmb_user->add_field( array(
    'name' => esc_html__( 'Mobile Number', 'cmb2' ),
    'id'   => 'user_phone',
    'type' => 'text_medium',
  ) );

  $cmb_user->add_field( array(
    'name' => esc_html__( 'Birthdater', 'cmb2' ),
    'id'   => 'user_bdate',
    'type' => 'text_medium',
  ) );

  $cmb_user->add_field( array(
    'name' => esc_html__( 'Profile Image', 'cmb2' ),
    'id'   => 'user_img',
    'type' => 'file',
    'options' => array(
      'url' => false, // Hide the text input for the url
    ),
    'text'    => array(
        'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
    ),
    'preview_size'  =>  'thumbnail'
  ) );

  $cmb_log = new_cmb2_box( array(
    'id'               => 'mo_user_log_cmb',
    'title'            => esc_html__( 'User Logs Metabox', 'cmb2' ), // Doesn't output for user boxes
    'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
    'show_names'       => true,
    'new_user_section' => 'add-existing-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
  ) );

  $cmb_log->add_field( array(
    'name' => esc_html__( 'User follows', 'cmb2' ),
    'id'   => 'user_log_title',
    'type' => 'title',
  ) );

  $cmb_log->add_field( array(
    'name' => esc_html__( 'Bookmarked Posts', 'cmb2' ),
    'id'   => 'user_bookmarks',
    'type' => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_log->add_field( array(
    'name' => esc_html__( 'Groups', 'cmb2' ),
    'id'   => 'user_groups',
    'type'              => 'multicheck',
    'options_cb'        => 'mo_generate_groups',
    'select_all_button' =>  false,
    'attributes'        => array(
        'disabled' => 'disabled',
    ),
  ) );

  $notification_group = $cmb_log->add_field( array(
    'id'          => 'mo_notification_group',
    'type'        => 'group',
    'description' => esc_html__( 'Notification', 'cmb2' ),
    'options'     => array(
        'group_title'    => esc_html__( 'Notification {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Notification', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Notification', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_log->add_group_field( $notification_group, array(
    'name'       => esc_html__( 'Read', 'cmb2' ),
    'id'         => 'read',
    'type'       => 'checkbox',
  ) );

  $cmb_log->add_group_field( $notification_group, array(
    'name'       => esc_html__( 'Url', 'cmb2' ),
    'id'         => 'url',
    'type'       => 'text_url',
  ) );

  $cmb_log->add_group_field( $notification_group, array(
    'name'       => esc_html__( 'Description', 'cmb2' ),
    'id'         => 'desc',
    'type'       => 'textarea_small'
  ) );

  $cmb_log->add_group_field( $notification_group, array(
    'name'       => esc_html__( 'From', 'cmb2' ),
    'id'         => 'from_id',
    'type'       => 'text_small',
  ) );

  $cmb_log->add_group_field( $notification_group, array(
    'name'       => esc_html__( 'Post', 'cmb2' ),
    'id'         => 'post_id',
    'type'       => 'text_small',
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// workshop/activity information cmb
add_action( 'cmb2_admin_init', 'mo_register_workshop_activity_information_metabox' );
/**
 * Hook in and add a metabox to add fields to workshops and activities
 */
function mo_register_workshop_activity_information_metabox() {

  $cmb_information = new_cmb2_box( array(
    'id'               => 'mo_workshop_activity_information_cmb',
    'title'            => esc_html__( 'Information', 'cmb2' ),
    'object_types'     => array( 'workshops', 'activities' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Minimum Number of participants', 'cmb2' ),
    'id'               => 'mo_workshop_activity_participants',
    'type'             => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_participants_range',
  ) );
  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Maximum Number of participants', 'cmb2' ),
    'id'               => 'mo_workshop_activity_max_participants',
    'type'             => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_participants_range',
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Age Range', 'cmb2' ),
    'id'               => 'mo_workshop_activity_age',
    'type'             => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_age_range',
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Duration Hours', 'cmb2' ),
    'id'               => 'mo_workshop_activity_duration_hrs',
    'type'             => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_duration_range_hrs',
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Duration Minutes', 'cmb2' ),
    'id'               => 'mo_workshop_activity_duration',
    'type'             => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_duration_range',
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// workshop information cmb
add_action( 'cmb2_admin_init', 'mo_register_workshop_information_metabox' );
/**
 * Hook in and add a metabox to add fields to workshops
 */
function mo_register_workshop_information_metabox() {

  $cmb_information = new_cmb2_box( array(
    'id'               => 'mo_workshop_information_cmb',
    'title'            => esc_html__( 'Information', 'cmb2' ),
    'object_types'     => array( 'workshops', 'articles', 'stories', 'games', 'activities' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Location', 'cmb2' ),
    'id'               => 'mo_workshop_location',
    'type'             => 'text'
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Goals', 'cmb2' ),
    'id'               => 'mo_workshop_goals',
    'type'             => 'textarea'
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Collaborators', 'cmb2' ),
    'id'               => 'mo_workshop_collaborators',
    'type'             => 'multicheck',
    'options_cb'       => 'mo_generate_users',
  ) );

  $cmb_information->add_field( array(
    'name'             => esc_html__( 'Shared With', 'cmb2' ),
    'id'               => 'mo_workshop_shared_with',
    'type'             => 'radio',
    'options_cb'       => 'mo_generate_groups',
  ) );

  $cmb_attachments = new_cmb2_box( array(
    'id'               => 'mo_workshop_attachments_cmb',
    'title'            => esc_html__( 'Attachments', 'cmb2' ),
    'object_types'     => array( 'workshops', 'articles', 'stories', 'games', 'activities' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $cmb_attachments->add_field( array(
		'name'         => esc_html__( 'Attachments', 'cmb2' ),
		'desc'         => esc_html__( 'Upload or add multiple images/attachments.', 'cmb2' ),
		'id'           => 'mo_post_attachments',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
  ) );
 /* $attachments_group = $cmb_attachments->add_field( array(
    'id'          => 'mo_post_attachment_group',
    'type'        => 'group',
    'options'     => array(
      'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
      'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
      'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
      'sortable'       => true,
      'closed'      => true, // true to have the groups closed by default
    ),
  ) );
  $cmb_attachments->add_group_field( $attachments_group, array(
    'name'       => esc_html__( 'Link', 'cmb2' ),
    'id'         => 'link',
    'type'       => 'text',
  ) );

  $cmb_attachments->add_field( array(
    'name'         => esc_html__( 'Attachment Links', 'cmb2' ),
    'desc'         => esc_html__( 'Attachment Links.', 'cmb2' ),
    'id'           => 'mo_post_attachment_Links',
    'type'         => 'text'
  ) );*/
  
  $cmb_material = new_cmb2_box( array(
    'id'               => 'mo_workshop_material_cmb',
    'title'            => esc_html__( 'Material', 'cmb2' ),
    'object_types'     => array( 'workshops', 'articles', 'stories', 'games', 'activities' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $material_group = $cmb_material->add_field( array(
		'id'          => 'mo_workshop_material_group',
		'type'        => 'group',
		'options'     => array(
			'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
			'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
			'sortable'       => true,
			'closed'      => true, // true to have the groups closed by default
		),
  ) );
  
  $cmb_material->add_group_field( $material_group, array(
		'name'       => esc_html__( 'Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
  ) );
  
  $cmb_material->add_group_field( $material_group, array(
		'name'       => esc_html__( 'Number', 'cmb2' ),
		'id'         => 'number',
		'type'       => 'text',
	) );



  $cmb_faciComments = new_cmb2_box( array(
    'id'               => 'mo_workshop_faciComments_cmb',
    'title'            => esc_html__( 'Facilitator Comments', 'cmb2' ),
    'object_types'     => array( 'workshops', 'articles', 'stories', 'games', 'activities' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $faciComments_group = $cmb_faciComments->add_field( array(
    'id'          => 'mo_workshop_faciComments_group',
    'type'        => 'group',
    'options'     => array(
      'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
      'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
      'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
      'sortable'       => true,
      'closed'      => true, // true to have the groups closed by default
    ),
  ) );
  
  
  $cmb_faciComments->add_group_field( $faciComments_group, array(
    'name'       => esc_html__( 'Commented by', 'cmb2' ),
    'id'         => 'user',
    'type'       => 'text_url',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );
  $cmb_faciComments->add_group_field( $faciComments_group, array(
    'name'       => esc_html__( 'Comment', 'cmb2' ),
    'id'         => 'comment',
    'type'       => 'textarea',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// workshop days cmb
add_action( 'cmb2_admin_init', 'mo_register_workshop_days_entries_metabox' );
/**
 * Hook in and add a metabox to add fields to workshop days
 */
function mo_register_workshop_days_entries_metabox() {

  $cmb_day = new_cmb2_box( array(
    'id'               => 'mo_day_cmb',
    'title'            => esc_html__( 'Day Information', 'cmb2' ),
    'object_types'     => array( 'workshops' ),
    // 'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $cmb_day->add_field( array(
    'name'             => esc_html__( 'ID', 'cmb2' ),
    'id'               => 'mo_day_target',
    'type'             => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry = new_cmb2_box( array(
    'id'               => 'mo_entry_cmb',
    'title'            => esc_html__( 'Entry Information', 'cmb2' ),
    'object_types'     => array( 'workshops', 'activities' ),
    // 'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $entries_group = $cmb_entry->add_field( array(
    'id'          => 'mo_entry_group',
    'type'        => 'group',
    'description' => esc_html__( 'Entry Steps', 'cmb2' ),
    'options'     => array(
        'group_title'    => esc_html__( 'Step {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Step', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Step', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_entry->add_group_field( $entries_group, array(
    'name'       => esc_html__( 'Title', 'cmb2' ),
    'id'         => 'title',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry->add_group_field( $entries_group, array(
    'name'       => esc_html__( 'Description', 'cmb2' ),
    'id'         => 'desc',
    'type'       => 'textarea',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry->add_group_field( $entries_group, array(
    'name'       => esc_html__( 'Note', 'cmb2' ),
    'id'         => 'note',
    'type'       => 'textarea',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry->add_group_field( $entries_group, array(
    'name'       => esc_html__( 'Duration', 'cmb2' ),
    'id'         => 'duration',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry->add_field( array(
    'name'             => esc_html__( 'ID', 'cmb2' ),
    'id'               => 'mo_entry_target',
    'type'             => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry->add_field( array(
    'name'             => esc_html__( 'Color', 'cmb2' ),
    'id'               => 'mo_entry_color',
    'type'             => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_entry->add_field( array(
    'name'             => esc_html__( 'Order', 'cmb2' ),
    'id'               => 'mo_entry_order',
    'type'             => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// posts bookmark log cmb
add_action( 'cmb2_admin_init', 'mo_register_bookmarks_log_metabox' );
/**
 * Hook in and add a metabox to add fields to workshops and activities
 */
function mo_register_bookmarks_log_metabox() {

  $cmb_log = new_cmb2_box( array(
    'id'               => 'mo_bookmarks_log_cmb',
    'title'            => esc_html__( 'Bookmark Logs', 'cmb2' ),
    'object_types'     => array( 'workshops', 'activities', 'games', 'articles', 'stories' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $bookmarks_group = $cmb_log->add_field( array(
    'id'          => 'mo_bookmarks_log_group',
    'type'        => 'group',
    'description' => esc_html__( 'logs the bookmark history for this post', 'cmb2' ),
    'options'     => array(
        'group_title'    => esc_html__( 'Log {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Log', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Log', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_log->add_group_field( $bookmarks_group, array(
    'name'       => esc_html__( 'Profile Url', 'cmb2' ),
    'id'         => 'user_url',
    'type'       => 'text_url',
  ) );

  $cmb_log->add_group_field( $bookmarks_group, array(
    'name'       => esc_html__( 'Bookmark Date', 'cmb2' ),
    'id'         => 'date',
    'type'       => 'text_medium',
  ) );

  $cmb_log->add_group_field( $bookmarks_group, array(
    'name'       => esc_html__( 'User ID', 'cmb2' ),
    'id'         => 'user_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// posts clone log cmb
add_action( 'cmb2_admin_init', 'mo_register_clone_log_metabox' );
/**
 * Hook in and add a metabox to add fields to workshops and activities
 */
function mo_register_clone_log_metabox() {

  $cmb_log = new_cmb2_box( array(
    'id'               => 'mo_clone_log_cmb',
    'title'            => esc_html__( 'Clone Logs', 'cmb2' ),
    'object_types'     => array( 'workshops', 'activities', 'games', 'articles', 'stories' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $clone_group = $cmb_log->add_field( array(
    'id'          => 'mo_clone_log_group',
    'type'        => 'group',
    'description' => esc_html__( 'logs the clone history for this post', 'cmb2' ),
    'options'     => array(
        'group_title'    => esc_html__( 'Log {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Log', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Log', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_log->add_group_field( $clone_group, array(
    'name'       => esc_html__( 'Cloned Post Url', 'cmb2' ),
    'id'         => 'user_url',
    'type'       => 'text_url',
  ) );

  $cmb_log->add_group_field( $clone_group, array(
    'name'       => esc_html__( 'Clone Date', 'cmb2' ),
    'id'         => 'date',
    'type'       => 'text_medium',
  ) );

  $cmb_log->add_group_field( $clone_group, array(
    'name'       => esc_html__( 'User ID', 'cmb2' ),
    'id'         => 'user_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_log->add_group_field( $clone_group, array(
    'name'       => esc_html__( 'Post ID', 'cmb2' ),
    'id'         => 'post_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// cloned post cmb
add_action( 'cmb2_admin_init', 'mo_register_cloned_check_metabox' );
/**
 * Hook in and add a metabox to add fields to workshops and activities
 */
function mo_register_cloned_check_metabox() {

  $cmb_log = new_cmb2_box( array(
    'id'               => 'mo_cloned_check_cmb',
    'title'            => esc_html__( 'Cloned', 'cmb2' ),
    'object_types'     => array( 'workshops', 'activities', 'games', 'articles', 'stories' ),
    'show_on_cb'       => 'mo_show_only_on_parent_post',
    'show_names'       => true,
  ) );

  $cmb_log->add_field( array(
		'name' => esc_html__( 'Post Cloned', 'cmb2' ),
		'desc' => esc_html__( 'this post was cloned, check to prevent changing the title', 'cmb2' ),
		'id'   => 'mo_cloned_check',
		'type' => 'checkbox',
	) );
  $cmb_log->add_field( array(
    'name' => esc_html__( 'Original Post', 'cmb2' ),
    'desc' => esc_html__( 'the original post ID that has been cloned', 'cmb2' ),
    'id'   => 'mo_original_cloned_id',
    'type' => 'text',
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// posts scrollspy
add_action( 'cmb2_admin_init', 'mo_register_scrollspy_metabox' );
/**
 * Hook in and add a metabox to add fields to games, articles, stories
 */
function mo_register_scrollspy_metabox() {

  $cmb_scrollspy = new_cmb2_box( array(
    'id'               => 'mo_scrollspy_cmb',
    'title'            => esc_html__( 'Scrollspy', 'cmb2' ),
    'object_types'     => array( 'games', 'articles', 'stories' ),
    'show_names'       => true,
    'priority'         => 'low',
    'closed'           => true,
  ) );

  $scrollspy_group = $cmb_scrollspy->add_field( array(
    'id'          => 'mo_scrollspy_group',
    'type'        => 'group',
    'description' => esc_html__( 'post headlines', 'cmb2' ),
    'options'     => array(
        'group_title'    => esc_html__( 'Headline {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Headline', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Headline', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_scrollspy->add_group_field( $scrollspy_group, array(
    'name'       => esc_html__( 'Headline', 'cmb2' ),
    'id'         => 'headline',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_scrollspy->add_group_field( $scrollspy_group, array(
    'name'       => esc_html__( 'Target', 'cmb2' ),
    'id'         => 'target',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// posts delete cmb
add_action( 'cmb2_admin_init', 'mo_register_delete_metabox' );
/**
 * Hook in and add a metabox to add fields to all post types
 */
function mo_register_delete_metabox() {

  $cmb_delete = new_cmb2_box( array(
    'id'               => 'mo_delete_cmb',
    'title'            => esc_html__( 'Delete Information', 'cmb2' ),
    'object_types'     => array( 'games', 'articles', 'stories', 'workshops', 'activities' ),
    'show_names'       => true,
    'priority'         => 'low',
    'closed'           => true,
  ) );

  $cmb_delete->add_field( array(
    'name'             => esc_html__( 'Reason', 'cmb2' ),
    'id'               => 'mo_delete_reason',
    'type'             => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_delete_reasons',
  ) );

  $cmb_delete->add_field( array(
    'name'             => esc_html__( 'Notes', 'cmb2' ),
    'id'               => 'mo_delete_notes',
    'type'             => 'textarea',
  ) );

  $cmb_delete->add_field( array(
    'name'             => esc_html__( 'Deleted by', 'cmb2' ),
    'id'               => 'mo_delete_user',
    'type'             => 'text_url',
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// posts report cmb
add_action( 'cmb2_admin_init', 'mo_register_report_metabox' );
/**
 * Hook in and add a metabox to add fields to all post types
 */
function mo_register_report_metabox() {

  $cmb_report = new_cmb2_box( array(
    'id'               => 'mo_report_cmb',
    'title'            => esc_html__( 'Report Information', 'cmb2' ),
    'object_types'     => array( 'games', 'articles', 'stories', 'workshops', 'activities' ),
    'show_names'       => true,
    'priority'         => 'low',
    'closed'           => true,
  ) );

  $reports_group = $cmb_report->add_field( array(
    'id'          => 'mo_reports_group',
    'description' => esc_html__( 'Reports', 'cmb2' ),
    'type'        => 'group',
    'options'     => array(
        'group_title'    => esc_html__( 'Report {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Report', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Report', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_report->add_group_field( $reports_group, array(
    'name'       => esc_html__( 'Reason', 'cmb2' ),
    'id'         => 'reason',
    'type'       => 'select',
    'show_option_none' => false,
    'options_cb'          => 'mo_generate_delete_reasons',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_report->add_group_field( $reports_group, array(
    'name'       => esc_html__( 'Notes', 'cmb2' ),
    'id'         => 'notes',
    'type'       => 'textarea',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_report->add_group_field( $reports_group, array(
    'name'       => esc_html__( 'Reported by', 'cmb2' ),
    'id'         => 'user',
    'type'       => 'text_url',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_report->add_group_field( $reports_group, array(
    'name'       => esc_html__( 'User ID', 'cmb2' ),
    'id'         => 'user_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// groups cmb
add_action( 'cmb2_admin_init', 'mo_register_groups_metabox' );
/**
 * Hook in and add a metabox to add fields to workshops and activities
 */
function mo_register_groups_metabox() {

  $cmb_admins_members = new_cmb2_box( array(
    'id'               => 'mo_group_admins_members_cmb',
    'title'            => esc_html__( 'Admins & Members', 'cmb2' ),
    'object_types'     => array( 'groups' ),
    'show_names'       => true,
  ) );

  $admins_group = $cmb_admins_members->add_field( array(
    'id'          => 'mo_group_admins',
    'description' => esc_html__( 'Admins', 'cmb2' ),
    'type'        => 'group',
    'options'     => array(
        'group_title'    => esc_html__( 'Admin {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Admin', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Admin', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_admins_members->add_group_field( $admins_group, array(
    'name'       => esc_html__( 'Name', 'cmb2' ),
    'id'         => 'name',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_admins_members->add_group_field( $admins_group, array(
    'name'       => esc_html__( 'Profile Url', 'cmb2' ),
    'id'         => 'profile_url',
    'type'       => 'text_url',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_admins_members->add_group_field( $admins_group, array(
    'name'       => esc_html__( 'User ID', 'cmb2' ),
    'id'         => 'user_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $members_group = $cmb_admins_members->add_field( array(
    'id'          => 'mo_group_members',
    'description' => esc_html__( 'Members', 'cmb2' ),
    'type'        => 'group',
    'options'     => array(
        'group_title'    => esc_html__( 'Member {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Member', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Member', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_admins_members->add_group_field( $members_group, array(
    'name'       => esc_html__( 'Name', 'cmb2' ),
    'id'         => 'name',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_admins_members->add_group_field( $members_group, array(
    'name'       => esc_html__( 'Profile Url', 'cmb2' ),
    'id'         => 'profile_url',
    'type'       => 'text_url',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_admins_members->add_group_field( $members_group, array(
    'name'       => esc_html__( 'User ID', 'cmb2' ),
    'id'         => 'user_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_posts = new_cmb2_box( array(
    'id'               => 'mo_group_posts_cmb',
    'title'            => esc_html__( 'Posts', 'cmb2' ),
    'object_types'     => array( 'groups' ),
    'show_names'       => true,
  ) );

  $posts_group = $cmb_posts->add_field( array(
    'id'          => 'mo_group_posts',
    'type'        => 'group',
    'options'     => array(
        'group_title'    => esc_html__( 'Post {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Post', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Post', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_posts->add_group_field( $posts_group, array(
    'name'       => esc_html__( 'Title', 'cmb2' ),
    'id'         => 'title',
    'type'       => 'text',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_posts->add_group_field( $posts_group, array(
    'name'       => esc_html__( 'Post Url', 'cmb2' ),
    'id'         => 'post_url',
    'type'       => 'text_url',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );

  $cmb_posts->add_group_field( $posts_group, array(
    'name'       => esc_html__( 'Post ID', 'cmb2' ),
    'id'         => 'post_id',
    'type'       => 'text_small',
    'attributes' => array(
        'readonly' => 'readonly',
    ),
  ) );


}
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// homepage cmb
add_action( 'cmb2_admin_init', 'mo_register_homepage_metabox' );
/**
 * Hook in and add a metabox to add fields to all post types
 */
function mo_register_homepage_metabox() {

  $cmb_testimonial = new_cmb2_box( array(
    'id'               => 'mo_testimonial_cmb',
    'title'            => esc_html__( 'Testimonial', 'cmb2' ),
    'object_types'     => array( 'page' ),
    'show_on_cb'       => 'mo_show_if_front_page',
    'show_names'       => true,
    'priority'         => 'low',
    'closed'           => true,
  ) );

  $testimonial_group = $cmb_testimonial->add_field( array(
    'id'          => 'mo_testimonial_group',
    'type'        => 'group',
    'options'     => array(
        'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
        'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
        'sortable'       => false,
        'closed'      => true, // true to have the groups closed by default
        // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
    ),
  ) );

  $cmb_testimonial->add_group_field( $testimonial_group, array(
    'name'       => esc_html__( 'Description', 'cmb2' ),
    'id'         => 'desc',
    'type'       => 'textarea',
  ) );

  $cmb_testimonial->add_group_field( $testimonial_group, array(
    'name'       => esc_html__( 'Name', 'cmb2' ),
    'id'         => 'name',
    'type'       => 'text',
  ) );

  $cmb_testimonial->add_group_field( $testimonial_group, array(
    'name'       => esc_html__( 'Photo', 'cmb2' ),
    'id'         => 'photo',
    'type'       => 'file',
  ) );

  $cmb_sponsors = new_cmb2_box( array(
    'id'               => 'mo_sponsors_cmb',
    'title'            => esc_html__( 'Sponsors', 'cmb2' ),
    'object_types'     => array( 'page' ),
    'show_on_cb'       => 'mo_show_if_front_page',
    'show_names'       => true,
    'priority'         => 'low',
    'closed'           => true,
  ) );

  $cmb_sponsors->add_field( array(
    'name' => 'Sponsors Logos',
    'id'   => 'mo_sponsors',
    'type' => 'file_list',
    'preview_size' => array( 50, 50 ), // Default: array( 50, 50 )
  ) );

  $cmb_contact = new_cmb2_box( array(
    'id'               => 'mo_contact_cmb',
    'title'            => esc_html__( 'Contact', 'cmb2' ),
    'object_types'     => array( 'page' ),
    'show_on_cb'       => 'mo_show_if_front_page',
    'show_names'       => true,
    'priority'         => 'low',
    'closed'           => true,
  ) );

  $cmb_contact->add_field( array(
    'name' => 'Phone Number',
    'id'   => 'mo_contact_number',
    'type' => 'text',
  ) );

  $cmb_contact->add_field( array(
    'name' => 'Email',
    'id'   => 'mo_contact_email',
    'type' => 'text',
  ) );

  $cmb_contact->add_field( array(
    'name' => 'Facebook',
    'id'   => 'mo_contact_fb',
    'type' => 'text_url',
  ) );

  $cmb_contact->add_field( array(
    'name' => 'Twitter',
    'id'   => 'mo_contact_tw',
    'type' => 'text_url',
  ) );

  $cmb_contact->add_field( array(
    'name' => 'Linkedin',
    'id'   => 'mo_contact_in',
    'type' => 'text_url',
  ) );
  $cmb_contact->add_field( array(
    'name' => 'Instagram',
    'id'   => 'mo_contact_insta',
    'type' => 'text_url',
  ) );


}
////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
// helper functions
// check if current user is post author
function mo_is_post_author() {
    global $wp_query;

    $post_author = $wp_query->get_queried_object()->post_author;
    $user_id = get_current_user_id();

    return $user_id == $post_author;
   
}

// check if current user is post collaborator
function mo_is_post_collaborator() {
  global $wp_query;

  $post_id = $wp_query->get_queried_object()->ID;
  $user_id = get_current_user_id();
  $post_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );

  return in_array( $user_id, $post_collaborators );
 
}

// reorder posts result to put private post in the beginning
function mo_reorder_posts_private_first($posts_ids_array) {
    $reordered = array();

    if (!empty($posts_ids_array)) {
        foreach ($posts_ids_array as $key => $post_id) {
            if (get_post_status($post_id) && get_post_status($post_id) == 'private') {
                array_unshift($reordered, $post_id);
            } else {
                $reordered[] = $post_id;
            }
        }
    }

    return $reordered;

}

// add/remove group id to user cmb & remove user id from the group cmb
//@param $group_id --> int group ID
//@param $user_id --> int user ID
//@param $type --> string member or admin default empty
//@param $remove --> bool remove default false
function mo_add_remove_group_member( $group_id, $user_id, $remove = false ) {
    $user_groups = get_user_meta( $user_id, 'user_groups', true );

    // if user is added, only update group cmb in user profile with the new group id
    if ( !$remove ) {
        if ( !empty( $user_groups ) && is_array( $user_groups ) ) {
            if ( !in_array( $group_id, $user_groups ) ) {
                $user_groups[] = $group_id;
                update_user_meta( $user_id, 'user_groups', $user_groups );
            }
        } else { // user had no groups
            update_user_meta( $user_id, 'user_groups', array( $group_id ) );
        }
    } else { // remove group from user CMB
        if ( !empty( $user_groups ) && is_array( $user_groups ) ) {
            if ( in_array( $group_id, $user_groups ) ) {
                $key = array_search( $group_id, $user_groups );
                unset($user_groups[$key]);
                $user_groups = array_values($user_groups);
                update_user_meta( $user_id, 'user_groups', $user_groups );
            }
        }
    }

}

// add/remove post to/from a group
//@param $group_id --> int group ID
//@param $post_id --> int post ID
//@param $remove --> bool remove default false
function mo_add_remove_group_post( $group_id, $post_id, $remove = false ) {
    $group_posts = get_post_meta( $group_id, 'mo_group_posts', true );
    $post_exist = false;
    $post_info = array();

    // add post to the group or update info if it already existed
    if ( !$remove ) {
        // make sure field value is array if it was empty
        if ( !is_array( $group_posts ) ) {
            $group_posts = array();
        }

        // if the group posts had values check if the post already existed
        if ( !empty( $group_posts ) ) {
           foreach ($group_posts as $key => $group_post) {
               // if post existed get the post index in the group
               if ( $group_post['post_id'] == $post_id ) {
                   $post_exist = $key;
               }
           }
        }


        
       if ( !$post_exist && $post_exist !== 0 ) { // if post does not exist prepare the new post info
            $post_info['post_id'] = $post_id;
            $post_info['title'] = get_the_title( $post_id );
            $post_info['post_url'] = get_permalink( $post_id );

            $group_posts[] = $post_info;
           
       } else { // if post exist update the group array using the post index
            $group_posts[$post_exist]['title'] = get_the_title( $post_id );
            $group_posts[$post_exist]['post_url'] = get_permalink( $post_id );
       }

       // update group posts
       update_post_meta( $group_id, 'mo_group_posts', $group_posts );

    } else { // remove post from group
        foreach ($group_posts as $key => $group_post) {
           // if post existed remove it and reorder the array
           if ( $group_post['post_id'] == $post_id ) {
               unset($group_posts[$key]);
               $group_posts = array_values($group_posts);
           }
       }
        // update group posts
       update_post_meta( $group_id, 'mo_group_posts', $group_posts );
    }

}

function mo_send_notification( $user_id, $from_id, $post_id, $desc, $url = false ) {

    if ( $user_id ) {
        $notifications = get_user_meta( $user_id, 'mo_notification_group', true );

        if ( !is_array( $notifications ) ) {
            $notifications = array();
        }

        $notification_entry = array(
            'read'      =>  '',
            'post_id'   =>  '',
            'url'       =>  '',
            'from_id'   =>  $from_id,
            'desc'      =>  $desc
        );

        if ( $post_id ) {
            $notification_entry['post_id'] = $post_id;
        }

        if ( $url ) {
            $notification_entry['url'] = $url;
        } elseif ( !$url && $post_id ) {
            $url = get_permalink($post_id);
            $notification_entry['url'] = $url;
        }

        $notifications[] = $notification_entry;

       update_user_meta( $user_id, 'mo_notification_group', $notifications );

    }

}

//change author/username base to users/userID
function change_author_permalinks() {
  global $wp_rewrite;
   // Change the value of the author permalink base to whatever you want here
   $wp_rewrite->author_base = 'users';
   $wp_rewrite->flush_rules();
}

add_action('init','change_author_permalinks');

add_filter('query_vars', 'users_query_vars');
function users_query_vars($vars) {
    // add lid to the valid list of variables
    $new_vars = array('users');
    $vars = $new_vars + $vars;
    return $vars;
}

function user_rewrite_rules( $wp_rewrite ) {
  $newrules = array();
  $new_rules['users/(\d*)$'] = 'index.php?author=$matches[1]';
  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules','user_rewrite_rules');

//change users/userID base to users/nickname
add_filter( 'request', 'wpse5742_request' );
function wpse5742_request( $query_vars ) {
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='nickname' AND meta_value = %s", $query_vars['author_name'] ) );
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );    
        }
    }
    return $query_vars;
}

add_filter( 'author_link', 'wpse5742_author_link', 10, 3 );
function wpse5742_author_link( $link, $author_id, $author_nicename ) {
    $author_nickname = get_user_meta( $author_id, 'nickname', true );
    if ( $author_nickname ) {
        $link = str_replace( $author_nicename, $author_nickname, $link );
    }
    return $link;
}

add_action( 'user_profile_update_errors', 'wpse5742_set_user_nicename_to_nickname', 10, 3 );
function wpse5742_set_user_nicename_to_nickname( &$errors, $update, &$user ) {
    if ( ! empty( $user->nickname ) ) {
        $user->user_nicename = sanitize_title( $user->nickname, $user->display_name );
    }
}


// get time ago
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'سنة',
        'm' => 'شهر',
        'w' => 'اسبوع',
        'd' => 'يوم',
        'h' => 'ساعة',
        'i' => 'دقيقة',
        's' => 'ثانية',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    
    if ($string) {
      $result = 'منذ ' . implode(', ', $string);
    } else {
      $result = 'الان';
    }

    $result = str_replace( 's', '', $result );
    
    return $result;
}


// show/hide post if is under group and current user is a member or not
function mo_check_group_post( $post_id, $user_id ) {
  $shared_with = get_post_meta( $post_id, 'mo_workshop_shared_with', true );

  // show if shared with all
  if ( empty( $shared_with ) || $shared_with == 'all' ) {
    return true;
  }

  $group_admins = get_post_meta( $shared_with, 'mo_group_admins', true );
  $group_members = get_post_meta( $shared_with, 'mo_group_members', true );

  if ( is_array( $group_admins ) || is_object( $group_admins ) ) {
    foreach ($group_admins as $admin) {
        if ( isset( $admin['user_id'] ) && $admin['user_id'] == $user_id ) {
          return true;
        }
    }
  }

  if ( is_array( $group_members ) || is_object( $group_members ) ) {
    foreach ($group_members as $member) {
        if ( isset( $member['user_id'] ) && $member['user_id'] == $user_id ) {
          return true;
        }
    }
  }

  return false;
}

function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

add_filter("wp_mail", "get_custom_mail"); 
function get_custom_mail($atts){ 
  $subj = $atts["subject"]; 
  $user = get_user_by( 'email',  $atts["to"]);
  if ($subj=='new Password') {
    $atts["subject"] = 'تم تغيير كلمة المرور بنجاح';
    $newPassword = $atts["message"];
    $atts["message"] .= '<div style="text-align: right;direction: rtl; padding:50px 0;"><strong> اهلا </strong>'.$user->display_name.'، <br><br><strong> انقر هنا لإنشاء كلمة مرور جديدة : </strong>'.wp_lostpassword_url().'</div>';
  }
  elseif($subj=='Login Details'){
    
  }
  return $atts; 
}
add_filter( 'retrieve_password_message', 'my_retrieve_password_message', 10, 4 );
function my_retrieve_password_message( $message, $key, $user_login, $user_data ) {

    // Start with the default content.
    $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    $message = '<div style="text-align: right;direction: rtl; padding-top:10px;"><strong> اهلا </strong>'.$user_login.'</div><div style="text-align: right;direction: rtl; padding:5px 0;">';
    $message .= __( 'طلب شخص ما إعادة تعيين كلمة المرور للحساب التالي' ) . "\r\n\r\n";
    $message .= '</div><div style="text-align: right;direction: rtl;">';
    /* translators: %s: site name */
    //$message .= sprintf( __( 'Site Name: %s' ), $site_name ) . "\r\n\r\n";
    /* translators: %s: user login */
    //$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
    $message .= __( 'إذا كان هذا خطأ ، فقط تجاهل هذا البريد الإلكتروني ولن يحدث شيء.' ) . "\r\n\r\n";
    $message .= '</div><div style="text-align: right;direction: rtl;">';
    //$message .= __( 'لإعادة تعيين كلمة المرور الخاصة بك ، قم بزيارة العنوان التالي:' ) . "\r\n\r\n";
    //$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";
    $message .= 'لإعادة تعيين كلمة المرور الخاصة بك <a href="https://mowazi.org/wp-login.php?action=rp&key=' . $key . '&login=' . $user_login.'">انقر هنا</a>';
    //https://mowazi.org/wp-login.php?action=rp&key=VAdUNpY20pbzGvbJbgG1&login=ranaTest 
    $message .= '</div>';

    /*
     * If the problem persists with this filter, remove
     * the last line above and use the line below by
     * removing "//" (which comments it out) and hard
     * coding the domain to your site, thus avoiding
     * the network_site_url() function.
     */
    // $message .= '<http://yoursite.com/wp-login.php?action=rp&key=' . $key . '&login=' . rawurlencode( $user_login ) . ">\r\n";

    // Return the filtered message.
    return $message;

}

function post_notification( $meta_id, $post_id, $meta_key, $meta_value ) {
  $post = get_the_title($post_id);
  $postUrl = get_permalink($post_id);
 //wp_mail('rana.nasser66@gmail.com', $subj, $meta_key); 
  switch ( $meta_key ) {
    case 'mo_reports_group':
      if(count($meta_value) != 0){
        $reasons = array(
            '0'      =>  'محتوى غير متصل بالتعليم',
            '1'      =>  'محتوى غير قانوني أو ينتهك الخصوصيات وحقوق الملكية الفكرية',
            '2'      =>  'محتوى لا يشير إلى المصادر الأصلية',
            '3'      =>  'اخرى'
        );
        
        $no_of_reports = count($meta_value)-1;
        $lastReport = $meta_value[$no_of_reports];
        $reason = $reasons[$lastReport['reason']];
        $notes = $lastReport['notes'];
        $reportedBy = $lastReport['user'];
        $msg = '<div style="direction: rtl; text-align: right;"><strong>سبب التقرير؟</strong>: '.$reason."<br><strong>ملاحظات:</strong> ".$notes.'<br><strong> الذي قام بالبلاغ: </strong>'.$reportedBy.'<br> <br>'.$postUrl.'</div>';
        $subj = 'Report for "'.$post."'";
        $to= 'mowazi@makouk.com';
        wp_mail($to, $subj, $msg); 
      }
      break;
    case 'mo_bookmarks_log_group':
      if(count($meta_value) != 0){
        $post_author = (int)get_post_field ('post_author', $post_id);
        $user_info = get_userdata($post_author);
        $to = $user_info->user_email;
        $no_of_marks = count($meta_value);
        $msg = '<div style="direction: rtl; text-align: right;">لقد تم حفظ جديد للمحتوى "'.$post.'" الخاص بك <br> الإجمالي الان '.$no_of_marks.'</div>';
        wp_mail($to, $subj, $msg); 
      }
      break;
  }
   
 
    /*switch ( $meta_key ) {
        case 'mobile_number':
        case 'address':

            $user = new \WP_User($user_id);

            // user
            wp_mail($user->user_email, 'Profile updated', 'Profile updated.');

            // admin
            wp_mail(get_bloginfo('admin_email'), 'Profile updated', "Profile updated for user {$user->display_name}.");
            break;
    } */
}
add_action('updated_post_meta', 'post_notification',10,4);

function if_change_recipient_comment_notification( $emails, $comment_ID ){
  //$admin_email = get_bloginfo('admin_email');
  $comment = get_comment( $comment_ID );
  $post = get_post( $comment->comment_post_ID );
  $post_author = (int)get_post_field ('post_author', $post->ID);
  $user_info = get_userdata($post_author);
  $to = $user_info->user_email;
  $subj = 'تعليق جديد '.$post->post_title;
  $msg = 'لقد تم اضافت تعليق جديد: <br>'. $comment->comment_content;
  //wp_mail( $to , $subj, $msg );
  wp_mail( 'mowazi@makouk.com' , $subj, $msg );
  //return array( $admin_email );

}
add_filter( 'comment_notification_recipients', 'if_change_recipient_comment_notification', 10, 2 );



function my_login_logo() { ?>
    <style type="text/css">
      body.login{
        background-color: #000033;
      }
      #login h1 a, .login h1 a {
        background-image: url(<?php echo get_template_directory_uri();?>/images/logo.svg);
        height:65px;
        width:320px;
        background-size: 320px 65px;
        background-repeat: no-repeat;
        padding-bottom: 30px;
      }
      .login #login_error, .login .message, .login .success{
        background-color:transparent !important;
        color: #fff;
        border-right-color: #FFC055 !important;
      }
      .login #login form#loginform, .login #login form#lostpasswordform, .login #login form#resetpassform{
        background:transparent;
        border-color:transparent;
        padding: 25px 0;
      }
      .login #login form#loginform label, .login #login form#lostpasswordform label, .login #login form#resetpassform label{
        color:#fff;
      }
      .login #login form#loginform .input, .login #login form#lostpasswordform .input, .login #login form#resetpassform .input{
        border-color:#fff;
        background-color: transparent;
        color:#fff;
      }
      .login #login form#loginform p, .login #login form#lostpasswordform p, .login #login form#resetpassform p, .login #login a{
        color:#fff;
      }
      .login #login form#loginform .button.wp-hide-pw .dashicons, .login #login form#resetpassform .button.wp-hide-pw .dashicons{
        color:#fff;
      }
      .login #login form#loginform p .button, .login #login form#lostpasswordform p .button, .login #login form#resetpassform p .button{
        background-color: #FFC055;
        border-color: #FFC055;
        color: #000;
      }
      .login #login #backtoblog a, .login #login #nav a {
          color: #fff;
      }
      .login #login .privacy-policy-link{
        color:#fff;
      }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function arabicPostType($postType){
  $arabic_postType ='';
  switch ($postType) {
    case 'articles':
      $arabic_postType ='مدونات';
      break;
    case 'workshops':
      $arabic_postType ='ورش';
      break;
    case 'games':
       $arabic_postType ='ألعاب';
      break;
    case 'activities':
       $arabic_postType ='انشطة';
      break;
    case 'stories':
       $arabic_postType ='حكايات';
      break;
    default:
      break;
  }
  return $arabic_postType;
}
/*function breadcrumbs($postType){

  $arabic_postType ='';
  switch ($postType) {
  case 'articles':
    $arabic_postType ='مدونات';
    break;
  case 'workshops':
    $arabic_postType ='ورش';
    break;
  case 'games':
     $arabic_postType ='ألعاب';
    break;
  case 'activities':
     $arabic_postType ='انشطة';
    break;
  case 'stories':
     $arabic_postType ='حكايات';
    break;
  default:
    break;
  }
  $breadcrumbs = '<ul class="breadcrumbs">
                    <li><a href="'.get_site_url().'">الرئسية</a></li>
                    <li>/</li>';
  if ( is_archive() ){
    $breadcrumbs .= '<li>'.$arabic_postType.'</li>';
  }else if (is_single()){
    global $post;
    $postID = $post->ID;
    $postName = get_the_title( $postID );
    $breadcrumbs .= '<li><a href="'.get_post_type_archive_link($postType).'">'.$arabic_postType.'</a></li>
                    <li>/</li>
                    <li>'.$postName.'</li>';

  }
  $breadcrumbs .= '</ul>';
  // var_dump($breadcrumbs);
  return $breadcrumbs;
}*/

?>