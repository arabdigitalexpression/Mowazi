<!-- <h1>code is poetry</h1> -->

<?php
// var_dump(get_query_var());
// $post_type = $wp_query->get_queried_object();

// var_dump($post_type);

?>

<?php get_header(); ?>


<?php
if ( is_user_logged_in() ) {
 	get_template_part('templates/content-homepage-logged');
 } else {
 	get_template_part('templates/content-homepage');
 }
?>


<?php get_footer(); ?>