<?php
	//Standard Plan Template
	
	global $post;
	global $pdf_output;
	global $pdf_header;
	global $pdf_footer;

	global $pdf_template_pdfpage;
	global $pdf_template_pdfpage_page;
	global $pdf_template_pdfdoc;

	global $pdf_html_header;
	global $pdf_html_footer;

	//global $mpdf;

	$post_id = $post->ID;
	$post_type = get_post_type( $post_id );
	$post_title = get_the_title( $post_id );
	$post_date = get_the_date( 'Y/m/d', $post_id );
	$post_comments_count = get_comment_count( $post_id );
	$post_tags = get_the_tags( $post_id );
	$post_content = get_post($post_id);
	$content = $post_content->post_content;
	$content = apply_filters('the_content', $content);
	$post_author = (int)get_post_field ('post_author', $post_id);
	$post_reports = get_post_meta( $post_id, 'mo_reports_group', true );
	$post_clones = get_post_meta( $post_id, 'mo_clone_log_group', true );
	$post_is_aclone = get_post_meta( $post_id, 'mo_cloned_check', true );
	$users_reported = array();


	//workshop attr

	$post_participants = get_post_meta( $post_id, 'mo_workshop_activity_participants', true );
	$post_age_range = get_post_meta( $post_id, 'mo_workshop_activity_age', true );
	$post_duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );
	$post_location = get_post_meta( $post_id, 'mo_workshop_location', true );
	$post_goals = get_post_meta( $post_id, 'mo_workshop_goals', true );
	$post_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );
	$post_materials = get_post_meta( $post_id, 'mo_workshop_material_group', true );
	$post_attachments = get_post_meta( $post_id, 'mo_post_attachments', true );


	if ( empty( $post_collaborators ) ) {
	    $post_collaborators = array();
	}

	if ( !empty( $post_reports ) ) {
	    foreach ($post_reports as $post_report) {
	        if ( isset( $post_report['user_id'] ) && !in_array( $post_report['user_id'], $users_reported ) ) {
	            $users_reported[] = $post_report['user_id'];
	        }
	    }
	}

	$days = array();

	if ( $post_type == 'workshops' ) {
	    $days = get_posts( array(
	        'post_type'         =>  $post_type,
	        'post_status'       =>  'publish',
	        'nopaging'          =>  true,
	        'posts_per_page'    =>  -1,
	        'post_parent'       =>  $post_id,
	        'fields'            =>  'ids',
	        'order'             =>  'ASC',
	        'orderby'           =>  'meta_value',
	        'meta_key'          =>  'mo_day_target'
	    ) );
	}

	if ( $post_type == 'workshops' || $post_type == 'activities' ) {
	    $entries_args = array(
	        'post_type'         =>  $post_type,
	        'nopaging'          =>  true,
	        'posts_per_page'    =>  -1,
	        'fields'            =>  'ids',
	        'order'             =>  'ASC',
	        'orderby'           =>  'meta_value_num',
	        'meta_key'          =>  'mo_entry_order'
	    );

	    if ( $post_author == $user_id ) {
	        $entries_args['post_status'] = 'any';
	    }
	}


	$user_bookmarks = get_user_meta( $user_id, 'user_bookmarks', true );
	$user_bookmarks_arr = array();

	if ( !empty($user_bookmarks) ) {
	    $user_bookmarks_arr = explode( ',', $user_bookmarks );
	}
	

	//Set a pdf template. if both are set the pdfdoc is used. (You didn't need a pdf template)
	$pdf_template_pdfpage 		= ''; //The filename off the pdf file (you need this for a page template)
	$pdf_template_pdfpage_page 	= 1;  //The page off this page (you need this for a page template)

	$pdf_template_pdfdoc  		= ''; //The filename off the complete pdf document (you need only this for a document template)
	
	$pdf_html_header 			= false; //If this is ture you can write instead of the array a html string on the var $pdf_header
	$pdf_html_footer 			= false; //If this is ture you can write instead of the array a html string on the var $pdf_footer

	//Set the Footer and the Header
	$pdf_header = array (
  		'odd' => 
  			array (
    			'R' => 
   					array (
						'content' => '{PAGENO}',
						'font-size' => 8,
						'font-style' => 'B',
						'font-family' => 'DejaVuSansCondensed',
    				),
    				'line' => 1,
  				),
  		'even' => 
  			array (
    			'R' => 
    				array (
						'content' => '{PAGENO}',
						'font-size' => 8,
						'font-style' => 'B',
						'font-family' => 'DejaVuSansCondensed',
    				),
    				'line' => 1,
  			),
	);
	$pdf_footer = array (
	  	'odd' => 
	 	 	array (
	    		'R' => 
	    			array (
						'content' => '{DATE d.m.Y}',
					    'font-size' => 8,
					    'font-style' => 'BI',
					    'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'C' => 
	    			array (
	      				'content' => '- {PAGENO} / {nb} -',
	      				'font-size' => 8,
	      				'font-style' => '',
	      				'font-family' => '',
	    			),
	    		'L' => 
	    			array (
	      				'content' => get_bloginfo('name'),
	      				'font-size' => 8,
	      				'font-style' => 'BI',
	      				'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'line' => 1,
	  		),
	  	'even' => 
			array (
	    		'R' => 
	    			array (
						'content' => '{DATE d.m.Y}',
					    'font-size' => 8,
					    'font-style' => 'BI',
					    'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'C' => 
	    			array (
	      				'content' => '- {PAGENO} / {nb} -',
	      				'font-size' => 8,
	      				'font-style' => '',
	      				'font-family' => '',
	    			),
	    		'L' => 
	    			array (
	      				'content' => get_bloginfo('name'),
	      				'font-size' => 8,
	      				'font-style' => 'BI',
	      				'font-family' => 'DejaVuSansCondensed',
	    			),
	    		'line' => 1,
	  		),
	);
		

	$pdf_output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
		<html xml:lang="ar" dir="rtl">
		
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>' . get_bloginfo() . '</title>
		</head>
		<body xml:lang="ar" dir="rtl">
			<bookmark content="'.htmlspecialchars(get_bloginfo('name'), ENT_QUOTES).'" level="0" /><tocentry content="'.htmlspecialchars(get_bloginfo('name'), ENT_QUOTES).'" level="0" />
			<div id="header"><div id="headerimg">
				<h1><a href="' . get_option('home') . '/"><img src="'. get_option('home') .'/wp-content/themes/mowazi/images/logo-new.png"></a></h1>
			</div>
			</div>
			<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:400,700|Tajawal&display=swap&subset=arabic">
			<div id="content" class="widecolumn">';
			if(have_posts()) :
				if(is_search()) $pdf_output .=  '<div class="post"><h2 class="pagetitle">Search Results</h2></div>';
				if(is_archive()) {
					global $wp_query;

					if(is_category()) {
						$pdf_output .= '<div class="post"><h2 class="pagetitle">Archive for the "' . single_cat_title('', false) . '" category</h2></div>';
					} elseif(is_year()) {
						$pdf_output .= '<div class="post"><h2 class="pagetitle">Archive for ' . get_the_time('Y') . '</h2></div>';
					} elseif(is_month()) {
						$pdf_output .= '<div class="post"><h2 class="pagetitle">Archive for ' . get_the_time('F, Y') . '</h2></div>';
					} elseif(is_day()) {
						$pdf_output .= '<div class="post"><h2 class="pagetitle">Archive for ' . get_the_time('F jS, Y') . '</h2></div>';
					} elseif(is_search()) {
						$pdf_output .= '<div class="post"><h2 class="pagetitle">Search Results</h2></div>';
					} elseif (is_author()) {
						$pdf_output .= '<div class="post"><h2 class="pagetitle">Author Archive</h2></div>';
					}
				}
			
				while (have_posts()) : the_post();
					$cat_links = "";
					foreach((get_the_category()) as $cat) {
						$cat_links .= '<a href="' . get_category_link($cat->term_id) . '" title="' . $cat->category_description . '">' . $cat->cat_name . '</a>, ';
					}
					$cat_links = substr($cat_links, 0, -2);

					// Create comments link
					if($post->comment_count == 0) {
						$comment_link = 'No Comments &#187;';
					} elseif($post->comment_count == 1) {
						$comment_link = 'One Comment &#187;';
					} else {
						$comment_link = $post->comment_count . ' Comments &#187;';
					}

					$pdf_output .= '<bookmark content="'.the_title('','', false).'" level="1" /><tocentry content="'.the_title('','', false).'" level="1" />';
					$pdf_output .= '<div class="post">
					<h2>' . the_title('','', false) . '</h2>';


					// no authors and dates on static pages
					if(!is_page()) $pdf_output .=  '<p class="small subtitle">' . get_the_author_meta('display_name') . ' &middot; ' . /*$post_date .*/ '</p>';
					if ( $post_tags && !is_wp_error( $post_tags ) ) { 
						$i=1;
						$tags=count($post_tags);
                        $pdf_output .=  '<div class="tags-wrapper">';
                        foreach ($post_tags as $key => $post_tag) {
                           $pdf_output .=  '<a href="'.get_term_link($post_tag->term_id).'" class="btn tag tag-sm tag-related" style="border:none;">'.$post_tag->name.'</a>';
                           if ($i < $tags) {
                           		$pdf_output .= ", ";
                           		$i++;
                           }
                          
                        } 
                        $pdf_output .=  '</div>';
                    } 
                   $pdf_output .=  '<div class="post-info">';
                    if($post_duration):
                        $pdf_output .=  '<div class="post-duration" style="display:inline-block; width:90px; margin-left:10px; float:right;"><img width="15" src="'. get_option('home') .'/wp-content/wp-mpdf-themes/svg/clock-regular.svg" style="margin-left:5px;"><span>'.$post_duration.'</span></div>';
                    endif;
                    if($post_age_range): 
                        $pdf_output .=  '<div class="post-age-range" style="display:inline-block; width:90px; margin-left:10px; float:right;"><img width="15" src="'. get_option('home') .'/wp-content/wp-mpdf-themes/svg/group-solid.svg" style="margin-left:5px;"><span>'.$post_age_range.'</span></div>';
                    endif;
                    if($post_participants):
                        $pdf_output .=  '<div class="post-participants" style="display:inline-block; width:90px; margin-left:10px; float:right;"><img width="15" src="'. get_option('home') .'/wp-content/wp-mpdf-themes/svg/users-solid.svg" style="margin-left:5px;"><span>'.$post_participants.'</span></div>';
                    endif;
                    $pdf_output .=  '</div>';
                    if($post_location):
                        $pdf_output .=  '<div class="post-info" style="display:inline-block; margin-left:10px; float:right;"><div class="post-location"><img width="15" src="'. get_option('home') .'/wp-content/wp-mpdf-themes/svg/map-marker-alt-solid.svg" style="margin-left:5px;"><span>'.$post_location.'</span></div></div>';
                    endif;
                     $pdf_output .=  '</div>';
                    $pdf_output .=  '<div class="post-details">';
                    if ( $post_date ) { 
                        $pdf_output .=  '<div class="post-time"><img width="15" src="'. get_option('home') .'/wp-content/wp-mpdf-themes/svg/clock-solid.svg" style="margin-left:5px;"><span>'.$post_date.'</span></div>';
                    }
                    if ( $post_comments_count && isset($post_comments_count['approved']) && $post_comments_count['approved'] !== 0 ) {
                            $pdf_output .=  '<div class="post-comments"><i class="icon-comment"></i><span>'.$post_comments_count['approved'].'تعليقات</span></div>';
                    }
                    $pdf_output .=  '</div>';
                    $pdf_output .=  '<div class="view-content__container_body">';
                   // if ( $content ) {  $pdf_output .= $content; }
                   	if ( !empty( $post_goals ) && $post_type == 'workshops' ) { 
                        $pdf_output .=  '<div class="post-goals"><h3>أهداف الورشة</h3><div>'.nl2br( esc_html($post_goals)).'</div></div>';
                    }
                    if ( !empty( $post_materials )) {
                    	//$pdf_output .= '<pagebreak>';
                        $material_count = 0;
                        $pdf_output .=  '<div class="post-materials"><h3>المواد المطلوبة </h3>
                        <table>
                            <tbody>
                            	<tr>
                            	<td></td>
                                <td><strong>البند</strong></td>
                                <td><strong>العدد</strong></td>
                            	</tr>';
                            foreach ($post_materials as $material) {
                                $material_count++;
                                $pdf_output .= "<tr>";
                                $pdf_output .= "<td>".$material_count."</td>";
                                $pdf_output .= "<td>".$material['title']."</td>";
                                $pdf_output .= "<td>".$material['number']."</td>";
                                $pdf_output .= "</tr>";
                            } 
                        $pdf_output .=  '</tbody></table></div>';
                    }
                    if ( !empty( $days ) && $post_type == 'workshops' ) {
                        $days_count = 0;
                   	 	$pdf_output .=  '<div class="accordion" id="daysAccordion">';
						foreach ($days as $day) {
							$days_count++;
							$entries_args['post_parent'] = $day;
							$entries = get_posts( $entries_args );
							if ( !empty( $entries ) ) { 
      							$pdf_output .=  '<div class="card mb-2 shadow-none border" style="margin-top:30px; border-top:1px solid #000;" >
          							<h3>'.get_the_title( $day ).'</h3>
            							<div class="card-body" style="border:1px solid #707070; padding: 15px;">';
              								foreach ($entries as $entry_id) {
                  								$steps = get_post_meta( $entry_id, 'mo_entry_group', true );
              									$pdf_output .=  '<h4 class="workshop-days">'.get_the_title( $entry_id ).'</h4>
              									<table class="tableAccording">
                  									<tbody>
	                  									<tr style="border:1px solid #e1e1e1;">
									                      <td></td>
									                      <td><strong>الوصف</strong></td>
									                      <td><strong>الوقت</strong></td>
									                      <td><strong>ملاحظات</strong></td>
									                    </tr>';
		                      							foreach ( $steps as $step ) {
		                         							$step_title = $step_desc = $step_duration = $step_note = '';
															if ( isset( $step['title'] ) ) {
															 $step_title = $step['title'];
															}
															if ( isset( $step['desc'] ) ) {
															 $step_desc = $step['desc'];
															}
															if ( isset( $step['duration'] ) ) {
															 $step_duration = $step['duration'];
															}
															if ( isset( $step['note'] ) ) {
															 $step_note = $step['note'];
															}
															$pdf_output .=  '<tr>
															  <td>'.$step_title.'</td>
															  <td>'.$step_desc.'</td>
															  <td>'.$step_duration.'</td>
															  <td>'.$step_note.'</td>
															</tr>';
		                      							} 
                  									$pdf_output .=  '</tbody>
              									</table>';
              								}
           	 							$pdf_output .=  '</div>
         							
      							</div>';
  							} 
  						}
					$pdf_output .=  '</div>';
                    } elseif ( $post_type == 'activities' ) {
                        // activity type
                       	$entries_args['p'] = $post_id;
                        $entries = get_posts( $entries_args );
                        foreach ($entries as $entry_id) {
                            $steps = get_post_meta( $entry_id, 'mo_entry_group', true );
                        	$pdf_output .=  '<table class="table table-striped table-bordered">
                            <thead><tr>
                                <th scope="col"></th>
                                <th scope="col" colspan="2">الوصف</th>
                                <th scope="col">الوقت</th>
                                <th scope="col">ملاحظات</th>
                            </tr></thead>
                            <tbody>';
	                            foreach ( $steps as $step ) { 
	                               $step_title = $step_desc = $step_duration = $step_note = '';

	                               if ( isset( $step['title'] ) ) {
	                                   $step_title = $step['title'];
	                               }

	                               if ( isset( $step['desc'] ) ) {
	                                   $step_desc = $step['desc'];
	                               }

	                               if ( isset( $step['duration'] ) ) {
	                                   $step_duration = $step['duration'];
	                               }

	                               if ( isset( $step['note'] ) ) {
	                                   $step_note = $step['note'];
	                               }
                                
                                	$pdf_output .= '<tr>
	                                    <th scope="row"><span class="rotate">'.$step_title.'</span></th>
	                                    <td colspan="2">'.$step_desc.'</td>
	                                    <td>'.$step_duration.'</td>
	                                    <td>'.$step_note.'</td>
	                                </tr>';
                              	} 
                            $pdf_output .= '</tbody></table>';
                        }
                    }
                    if (!empty($post_attachments)){ 
                        $pdf_output .=  '<div class="post-attachments">
                            <h3>قائمة المرفقات </h3>
                            <ul>';
                                foreach ( $post_attachments as $post_attachment_id => $post_attachments_url ) {
                                    $post_attachment_name = $post_attachment_type = $post_attachment_size = '';
                                    $post_attachment_name = get_the_title( $post_attachment_id );
                                    $post_attachment_type = get_post_mime_type($post_attachment_id);
                                    $post_attachment_size = round(filesize( get_attached_file( $post_attachment_id ) ) / 1024);
                                   $pdf_output .=  '<li style="display:inline-block; width:33%; float:right;">
                                       <div class="formate" style="width:70px; text-align:center; padding:10px; height:auto;">'.$post_attachment_type.'</div>
                                       <a href="'.$att.'" target="_blank">'.$post_attachment_name .'<br>
                                            <span>'.$post_attachment_size.' KB</span>       
                                        </a>
                                  </li>';
                                }
                            $pdf_output .=  '</ul>
                        </div>';
                    } 
                    if ( $content ) {  $pdf_output .= '<pagebreak>'.$content; }
                    $pdf_output .=  '</div>';
					//$pdf_output .= '<div class="entry">' .	wpautop($post->post_content, true) . '</div>';
					
					if(!is_page() && !is_single()) $pdf_output .= '<p class="postmetadata">Posted in ' . $cat_links . ' | ' . '<a href="' . get_permalink() . '#comment">' . $comment_link . '</a></p>';

					// the following is the extended metadata for a single page
					if(is_single()) {
						/*$pdf_output .= '<p class="postmetadata alt">
							<span>
								This entry was posted on ' . date('l, F jS, Y', mpdf_mysql2unix($post->post_date)) . ' at ' . date('g:i a', mpdf_mysql2unix($post->post_date)) . ' and is filed under ' . $cat_links;
								
								if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
									// Both Comments and Pings are open
									$pdf_output .= ' You can leave a response, or <a href="' . get_trackback_url() . '" rel="trackback">trackback</a> from your own site.';
								} elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
									// Only Pings are Open
									$pdf_output .= ' Responses are currently closed, but you can <a href="' . get_trackback_url() . '" rel="trackback">trackback</a> from your own site.';
								} elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
									// Comments are open, Pings are not
									$pdf_output .= ' You can skip to the end and leave a response. Pinging is currently not allowed.';
								} elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
									// Neither Comments, nor Pings are open
									$pdf_output .= ' Both comments and pings are currently closed.';
								}
		
							$pdf_output .= '</span>
						</p>';*/
					}
					$pdf_output .= '</div> <!-- post -->';
				endwhile;
			
			else :
				$pdf_output .= '<h2 class="center">Not Found</h2>
					<p class="center">Sorry, but you are looking for something that isn\'t here.</p>';
			endif;

			$pdf_output .= '</div> <!--content-->';

		
	$pdf_output .= '
		</body>
		</html>';
?>
