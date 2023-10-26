<?php
global $user_id;
global $page_id;

// register page
if ($page_id == 10) {

	get_template_part('templates/content-register');

} elseif ($page_id == 8) {  // login page

	get_template_part('templates/content-login');

} elseif ($page_id == 3) {  // policy page

	get_template_part('templates/content-policy');

} 
?>