<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php wp_head();?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script type="text/javascript">var ajax_handler = '<?php echo get_bloginfo('template_directory').'/ajax-handler.php';?>';</script>
</head>
<!-- .fixed-sidebar to fixedside bar -->
<body <?php body_class(); ?> data-u="<?php echo mo_crypt(get_current_user_id(), 'e'); ?>">

	<!-- modal survey -->
	<?php get_template_part('modals/modal-survey')?>
	<!-- modal survey -->
	<div id="nav_wrap" class="<?php if ((!is_page(8)) && (!is_page(10)) && !is_user_logged_in() ) { echo 'relative-header';} ?>  <?php if ( is_user_logged_in() ) { echo 'logged main_nav'; } ?>">
	    <?php 
		    if ( ( is_archive() || is_front_page() || is_404() || is_page(17) || is_page(3) || is_page(6396) ) && !is_user_logged_in() ) {
		    	get_template_part('navs/nav-main');
		    } elseif ( ( ( is_archive() || is_front_page() || is_home () || is_404() || is_page(17) || is_page(6396) || is_page(3) ) && is_user_logged_in() ) || is_author() ) {
		    	get_template_part('navs/nav-logged');
		    }
	    ?>
	    <?php if (is_page(8)) { get_template_part('navs/nav-register'); } ?>
	    <?php if (is_page(10)) { get_template_part('navs/nav-login'); } ?>
	    <?php 
	    if ( is_single() ) {
			$context = isset( $_GET['c'] ) ? $_GET['c'] : '';
	    	if ( is_user_logged_in() ) {
	    		if ( ( mo_is_post_author() || mo_is_post_collaborator() ) && $context === 'edit' && !is_singular('groups') ) { // if its not groups single post type
		    		get_template_part('navs/nav-post');
	    		} else {
			    	get_template_part('navs/nav-logged');	    			
	    		}
	    	} else {
	    		get_template_part('navs/nav-main');
	    	}
	    }
	    ?>
	</div>
	<div class="loading-wrapper d-none">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
	</div>
	<div class="postioning-toast"></div>
    
    <main id="content_wrap" class="flex-shrink-0 bg-mo-gray">
    	