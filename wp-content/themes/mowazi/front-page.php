<?php get_header(); ?>


<?php
if ( is_user_logged_in() ) {
 	get_template_part('templates/content-homepage-logged');
 } else {
 	get_template_part('templates/content-homepage');
 }
?>


<?php get_footer(); ?>