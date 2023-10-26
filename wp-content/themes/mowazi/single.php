<?php get_header(); ?>

<?php

$user_id = get_current_user_id();
$post_type = $wp_query->get_queried_object()->post_type;
$post_author= $wp_query->get_queried_object()->post_author;
$post_status= $wp_query->get_queried_object()->post_status;
$post_id = $wp_query->get_queried_object()->ID;
$post_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );

if ( empty( $post_collaborators ) ) {
    $post_collaborators = array();
}


$context = isset( $_GET['c'] ) ? $_GET['c'] : '';

if ( $post_type == 'articles' || $post_type == 'games' || $post_type == 'stories' ) {

    if ( $user_id == $post_author || in_array( $user_id, $post_collaborators ) || mo_check_group_post( $post_id, $user_id ) ) {

        if ( $context === 'edit' ) {
            get_template_part('templates/content-add_post');
        } else {
            get_template_part('templates/content-view_post');
        }

    } else {
        if ( $post_status == 'publish' ) {
            get_template_part('templates/content-view_post');
        } else {
            get_template_part('templates/content-empty');
        }
    }

} elseif ( $post_type == 'workshops' || $post_type == 'activities' ) {

    if ( $user_id == $post_author || in_array( $user_id, $post_collaborators ) || mo_check_group_post( $post_id, $user_id ) ) {

        if ( $context === 'edit' ) {
            get_template_part('templates/content-add_workshop');
        } else {
            get_template_part('templates/content-view_post');
        }

    } else {
        if ( $post_status == 'publish' ) {
            get_template_part('templates/content-view_post');
        } else {
            get_template_part('templates/content-empty');
        }
    }
    
} elseif ( $post_type == 'groups' ) {
    get_template_part('templates/content-profile_group');
}

?>

<?php get_footer(); ?>
