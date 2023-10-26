<?php get_header(); ?>


<?php

if (is_page(8)) { // login page

	get_template_part('templates/content-login');

} elseif (is_page(10)) { // register page

	get_template_part('templates/content-register');

} elseif (is_page(17)) { // search result

	global $types;
	global $keyword;
	global $participants;
	global $age;
	global $duration;

	if ( isset( $_GET['t'] ) ) {
		$types = explode( $_GET['t'] );
	}

	if ( isset( $_GET['p'] ) ) {
		$participants = $_GET['p'];
	}

	if ( isset( $_GET['a'] ) ) {
		$age = $_GET['a'];
	}

	if ( isset( $_GET['d'] ) ) {
		$duration = $_GET['d'];
	}

	if ( isset( $_GET['k'] ) ) {
		$keyword = $_GET['k'];
	}

	get_template_part('templates/content-search_result');

} elseif ( is_page(3) ) { // policy
	get_template_part('templates/content-policy');
}
?>
<?php get_footer(); ?>