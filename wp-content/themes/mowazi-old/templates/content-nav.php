<?php
global $user_id;
global $page_id;

if ( !$user_id ) {
	$user_id = get_current_user_id();
}

// register page
if ($page_id == 10) {

	get_template_part('navs/nav-login');

} elseif ($page_id == 8) {  // login page

	get_template_part('navs/nav-register');
	
} elseif ($page_id == 3) {  // policy page

	if ( $user_id == 0 ) {
		get_template_part('navs/nav-main');
	} else {
		get_template_part('navs/nav-logged');
	}

}
?>