<?php
/**
* Get Page
*
* @param $request_data array of user id & page id
* @return string html & nav of page
*/
function mo_get_page($request_data) {
	global $user_id;
	global $page_id;
	$result = array();
	$output_html = '';
	$nav_html = '';

	$page_id = $request_data['page'];
	$user_id = (int)mo_crypt($request_data['u'], 'd');

	ob_start();
	get_template_part('templates/content-page');
	$output_html = ob_get_contents();
	$result['html'] = $output_html;
	ob_end_clean();

	ob_start();
	get_template_part('templates/content-nav');
	$nav_html = ob_get_contents();
	$result['nav'] = $nav_html;
	ob_end_clean();

	return $result;

}

/**
* User Register
*
* @param array $register_info
* @return Int | WP_Error --> user id on success or WP_Error on registeration or sign in fail 
*/
function mo_register_user( $register_info ) {
	$username = $register_info['username'];
	$password = $register_info['password'];
	$bdate = $register_info['bdate'];
	$fullname = sanitize_text_field( $register_info['fullname'] );
	$first_name = explode(' ', $fullname, 2)[0];
	$last_name = explode(' ', $fullname, 2)[1];
	$display_name = $first_name . ' ' . explode(' ', $last_name, 2)[0];
	$nicename = sanitize_title($fullname);
	$registration_date = date('Y-m-d', strtotime('now'));
	$email = $register_info['email'];
	$number = $register_info['number'];


	$user = wp_insert_user( array (
		'user_login'		=>	$username,
		'user_pass'			=>	$password,
		'user_nicename'		=>	$nicename,
		'user_email'		=>	$email,
		'display_name'		=>	$display_name,
		'nickname'			=>	$username,
		'first_name'		=>	$first_name,
		'last_name'			=>	$last_name,
		'user_registered'	=>	$registration_date,
		'role'				=>	'facilitator'
	) );

	if (!is_wp_error($user)) {
		update_user_meta( $user, 'user_bdate', $bdate );
		update_user_meta( $user, 'user_phone', $number );

		$creds = array();
	    $creds['user_login'] = $username;
	    $creds['user_password'] = $password;
	    $creds['remember'] = true;
	    $user_signon = wp_signon( $creds, true );

	    if ( is_wp_error( $user_signon ) ) {
	    	// trigger update user function to overcome wordpress sometimes not generating the correct user url right after registeration
	    	wp_update_user( $user_signon );
	    	
	    	return $user_signon;
	    }
	}

	return $user;

}

/**
* validate username
*
* @param string $username
* @return bool --> true if username does not exists, false if it does
*/
function mo_validate_username( $username ) {
	$valid = username_exists($username);

	// if user does not exist
	if (!$valid) {
		return true;
	}

	return false;

}

/**
* validate email || number
*
* @param string $field email or number
* @return bool --> true if email || number does not exists, false if it does
*/
function mo_validate_email_number( $field ) {

	if ( is_email( $field ) ) {
		$valid = email_exists( $field ) ? false : true;
	} else {
		$get_user = get_users( array(
	        'meta_key'      =>  'user_phone',
	        'meta_value'    =>  $field,
	        'fields'        =>  'ID'
	    ) );

	    $valid = !empty( $get_user ) ? false : true;
	}

	return $valid;

}

/**
* User Login
*
* @param array $login_info
* @return WP_User | WP_Error
*/
function mo_login_user( $login_info ) {
	$user_login;
	$user_pw = $login_info['password'];

	if ( is_email( $login_info['username'] ) ) {
		$get_user = get_user_by( 'email', $login_info['username'] );

		if ( $get_user ) {
			$user_login = $get_user->user_login;
		}
	} elseif ( username_exists( $login_info['username'] ) ) {
		$user_login = $login_info['username'];
	} else {
		$get_user = get_users( array(
	        'meta_key'      =>  'user_phone',
	        'meta_value'    =>  $login_info['username']
	    ) );

	    if ( !empty( $get_user ) ) {
	    	foreach ($get_user as $key => $user) {
	    		$user_login = $user->user_login;
	    	}
	    }
	}

	$creds = array();
    $creds['user_login'] = $user_login;
    $creds['user_password'] =  $user_pw;
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );

	return $user;

}
function mo_new_pw( $email ) {
	$email;
	$new_Pass;

	if ( email_exists( $email ) ) {
		$get_user = get_user_by( 'email', $email );
		$new_Pass = wp_generate_password( 12, true, false );
		$subject  = 'new Password';
		$message  = $new_Pass;
		wp_mail( $email, $subject, $message);
		$new_Pass = true;
	} else {
		$new_Pass = false;
	}
	return $new_Pass;

}

/**
* User Logout
*/
function mo_logout_user() {
	wp_logout();
}

/**
* create post
*
* @param array $login_info
* @return WP_User | WP_Error
*/
function mo_create_post( $post_info ) {
	global $post_id;
	global $user_id;

	$user_id = $post_type = $post_title = $participants = $maxParticipants = $age = $duration = $goals = $output_html = $nav_html = '';

	$post_meta = array();
	$post_tags = array();
	$result = array();

	if ( isset( $post_info['u'] ) ) {
		$user_id = (int)mo_crypt($post_info['u'], 'd');
	}

	if ( isset( $post_info['post'] ) ) {
		$post_type = $post_info['post'];
	}

	if ( isset( $post_info['title'] ) ) {
		$post_title = $post_info['title'];
	}

	if ( isset( $post_info['participants'] ) ) {
		$participants = $post_info['participants'];
		$post_meta['mo_workshop_activity_participants'] = $participants;
	}
	if ( isset( $post_info['maxParticipants'] ) ) {
		$maxParticipants = $post_info['maxParticipants'];
		$post_meta['mo_workshop_activity_max_participants'] = $maxParticipants;
	}

	if ( isset( $post_info['age'] ) ) {
		$age = $post_info['age'];
		$post_meta['mo_workshop_activity_age'] = $age;
	}

	if ( isset( $post_info['durationHrs'] ) && isset( $post_info['durationMin'] ) ) {
		$durationHrs = $post_info['durationHrs'];
		$durationMin = $post_info['durationMin'];
		$post_meta['mo_workshop_activity_duration_hrs'] = $durationHrs;
		$post_meta['mo_workshop_activity_duration'] = $durationMin;
	}

	if ( isset( $post_info['goals'] ) ) {
		$goals = $post_info['goals'];
		$post_meta['mo_workshop_goals'] = $goals;
	}

	if ( isset( $post_info['tags'] ) ) {
		$tags = $post_info['tags'];

		foreach ($tags as $tag_info) {
			// if new term
			if ( $tag_info['new'] ) {
				$insert_term = wp_insert_term( $tag_info['value'], 'post_tag' );

				if ( !is_wp_error( $insert_term ) ) {
					$post_tags[] = (int)$insert_term['term_id'];
				}
			} else {
				$post_tags[] = (int)$tag_info['value'];
			}

		}

	}

	if (isset ($post_info['workshopActivities'])){
		$activities = $post_info['workshopActivities'];
		// print_r($activities);
		$post_meta['activities'] = $activities;

	}

	if ( !empty($user_id) && !empty($post_type) && !empty($post_title) ) {
		 $post_information = array(
	      'post_title' 	=>	$post_title,
	      'post_type'  	=>	$post_type,
	      'post_status' =>	'private',
	      'post_author' =>	$user_id,
	      'meta_input'	=>	$post_meta,
	      'tags_input'	=>	$post_tags
	    );
	}


    $post_id = wp_insert_post($post_information);

    if ( $post_id !== 0 ) {

    	$result['id'] = $post_id;

    	if ( $post_type == 'activities' ) {
    		$result['activity'] = true;
    	} else {
    		$result['activity'] = false;
    	}

    	ob_start();
		get_template_part('navs/nav-post');
		$nav_html = ob_get_contents();
		$result['nav'] = $nav_html;
		ob_end_clean();
    	
    	ob_start();
    	if ( $post_type == 'workshops' || $post_type == 'activities' ) {
	        get_template_part('templates/content-add_workshop');
    	} else {
			get_template_part('templates/content-add_post');
    	}
		$output_html = ob_get_contents();
		$result['html'] = $output_html;
		ob_end_clean();

    }

	return $result;

}

/**
* publish post
*
* @param array $post_info
* @return post id | false
*/
function mo_publish_post( $post_info ) {
	global $post_id;
	$output_html = $nav_html = '';
	$result = array();
	$user_id = (int)mo_crypt($post_info['u'], 'd');
	$post_id = $post_info['post'];
	$post_type = get_post_type( $post_id );
	$post_content = isset( $post_info['content'] ) ? $post_info['content'] : '';
	$post_title = !empty( $post_info['title'] ) ? $post_info['title'] : get_the_title( $post_id );
	$post_headlines = array();
	$post_tags = array();
	$status = isset( $post_info['status'] ) && $post_info['status'] == 1 ? 'private' : 'publish';
	$headlines = $post_info['headlines'];
	$days = $post_info['days'];
	$entries = $post_info['entries'];
	$post_location = isset( $post_info['location'] ) ? $post_info['location'] : '';
	$post_goals = isset( $post_info['goals'] ) ? $post_info['goals'] : '';
	$post_durationHrs = isset( $post_info['durationHrs'] ) ? $post_info['durationHrs'] : '';
	$post_duration = isset( $post_info['durationMin'] ) ? $post_info['durationMin'] : '';
	$post_age = isset( $post_info['age'] ) ? $post_info['age'] : '';
	$post_participants = isset( $post_info['participants'] ) ? $post_info['participants'] : '';
	$post_max_participants = isset( $post_info['maxParticipants'] ) ? $post_info['maxParticipants'] : '';
	$post_collaborators = isset( $post_info['collaborators'] ) ? $post_info['collaborators'] : '';
	$post_sharewith = isset( $post_info['sharewith'] ) ? $post_info['sharewith'] : '';
	$entries_ids = array();
	$days_ids = array();
	$old_entries = array();
	$old_days = get_posts(
		array(
			'post_type' => 'workshops',
			'fields'	=> 'ids',
			'post_parent'	=>	$post_id,
			'posts_per_page'	=> -1
		)
	);

	if ( !empty( $old_days ) ) {

		foreach ( $old_days as $old_day_id ) {
			$old_day_entries = get_posts(
				array(
					'post_type' => 'workshops',
					'fields'	=> 'ids',
					'post_parent'	=>	$old_day_id,
					'posts_per_page'	=> -1
				)
			);

			if ( !empty( $old_day_entries ) ) {
				foreach ( $old_day_entries as $old_day_entry_id ) {
					$old_entries[] = $old_day_entry_id;
				}
			}

		}

	}

	if ( isset( $post_info['tags'] ) ) {
		$tags = $post_info['tags'];

		foreach ($tags as $tag_info) {
			// if new term
			if ( $tag_info['new'] ) {
				$insert_term = wp_insert_term( $tag_info['value'], 'post_tag' );

				if ( !is_wp_error( $insert_term ) ) {
					$post_tags[] = (int)$insert_term['term_id'];
				}
			} else {
				$post_tags[] = (int)$tag_info['value'];
			}

		}

	}

    $post_information = array(
	    'ID' 			=> 	$post_id,
	    'post_content' 	=> 	$post_content,
	    'post_title'	=>	$post_title,
	    'post_status'	=>	$status,
		// 'post_author'	=>	$user_id,
		'tags_input'	=>	$post_tags
	);

	if ( !empty($headlines) ) {
		// reverse the array order to keep the same order as the original post
		$headlines = array_reverse($headlines);
		foreach ($headlines as $headline_target => $headline) {
			$post_headlines[] = array(
				'headline'	=>	$headline,
				'target'	=>	$headline_target
			);
		}
	}
	
	// update post title temp to empty to force record post revision on the top level parent post before updating again with full information
	$post_record_revision = wp_update_post( array(
		'ID' 			=> 	$post_id,
	    'post_title'	=>	'',
	) );

	$post_update = wp_update_post($post_information);

	if ( !is_wp_error( $post_update ) && $post_update !== 0 ) {

		// update scrollspy only for post types that have it
		if ( !empty($post_headlines) ) {
			update_post_meta( $post_update, 'mo_scrollspy_group', $post_headlines );
		}

		// update workshop information if not empty
		if ( !empty($post_location) ) {
			update_post_meta( $post_update, 'mo_workshop_location', $post_location );
		}

		if ( !empty($post_goals) ) {
			update_post_meta( $post_update, 'mo_workshop_goals', $post_goals );
		}

		if ( !empty($post_collaborators) ) {
			// send notification to new collab
			$old_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );
			$new_collaborators = array_diff( $post_collaborators, $old_collaborators );

			if ( !empty( $new_collaborators ) ) {
				foreach ( $new_collaborators as $new_collaborator_id ) {
					mo_send_notification( $new_collaborator_id, $user_id, $post_id, 'تم دعوتك للمشاركة في محتوى' );
				}
			}

		}
		update_post_meta( $post_update, 'mo_workshop_collaborators', $post_collaborators );
		
		if ( !empty($post_sharewith) ) {
			update_post_meta( $post_update, 'mo_workshop_shared_with', $post_sharewith );

			// update group posts cmb if the post was shared with it
			if ( !$post_sharewith !== 'all' ) {
				mo_add_remove_group_post( $post_sharewith, $post_update );
			}
		}
		if ( !empty($post_durationHrs) ) {
			update_post_meta( $post_update, 'mo_workshop_activity_duration_hrs', $post_durationHrs );
		}
		if ( !empty($post_duration) ) {
			update_post_meta( $post_update, 'mo_workshop_activity_duration', $post_duration );
		}
		if ( !empty($post_age) ) {
			update_post_meta( $post_update, 'mo_workshop_activity_age', $post_age );
		}
		if ( !empty($post_participants) ) {
			update_post_meta( $post_update, 'mo_workshop_activity_participants', $post_participants );
		}
		if ( !empty($post_max_participants) ) {
			update_post_meta( $post_update, 'mo_workshop_activity_max_participants', $post_max_participants );
		}


		//update days posts
		if ( !empty( $days ) && $post_type == 'workshops' ) {
			foreach ($days as $day_target => $day_post) {
				$day_slug = sanitize_title($day_post['title']);

				$days_post_update = wp_insert_post( array(
					'ID'			=>	$day_post['post'],
					'post_author'	=>	$user_id,
					'post_title'	=>	$day_post['title'],
					'post_name'		=>	$day_slug,
					'post_status'	=>	'publish',
					'post_type'		=>	$post_type,
					'post_parent'	=>	$post_update,
					'meta_input'	=>	array(
						'mo_day_target'	=>	$day_target
					)
				) );

				if ( !is_wp_error( $days_post_update ) && $days_post_update !== 0 ) {
					$days_ids[] = $days_post_update;
				}
			}

			// remove old days that does not exist in request object
			$deleted_days = array_diff( $old_days,  $days_ids);
			if ( !empty( $deleted_days ) ) {
				foreach ( $deleted_days as $deleted_day_id ) {
					wp_trash_post( $deleted_day_id );
				}
			}

		}

		//update entries posts
		if ( !empty( $entries ) ) {
			foreach ($entries as $entry_target => $entry_post) {
				// if the entry belonged to a workshop set the title as the entry title else (activity) keep the original activity title
				if ( $post_type == 'workshops' ) {

					$post_title = $entry_post['title'];

					// if day and entry published in same time -> find the day post with meta key
					if ( !is_numeric( $entry_post['parent'] ) ) {
						$get_post_parent = get_posts( array(
							'post_type'         =>  $post_type,
					        'posts_per_page'    =>  1,
					        'fields'            =>  'ids',
					        'meta_key'			=>	'mo_day_target',
					        'meta_value'		=>	$entry_post['parent']
						) );

						$post_parent = $get_post_parent[0];
					} else {
						$post_parent = $entry_post['parent'];
					}

				}

				$entry_post_update = wp_insert_post( array(
					'ID'			=>	$entry_post['post'],
					'post_author'	=>	$user_id,
					'post_title'	=>	$post_title,
					'post_status'	=>	'publish',
					'post_type'		=>	$post_type,
					'post_parent'	=>	$post_parent,
					'meta_input'	=>	array(
						'mo_entry_target'	=>	$entry_target,
						'mo_entry_color'	=>	$entry_post['color'],
						'mo_entry_group'	=>	$entry_post['steps'],
						'mo_entry_order'	=>	$entry_post['order']
					)
				) );
				
				if ( !is_wp_error( $entry_post_update ) && $entry_post_update !== 0 ) {
					$entries_ids[] = $entry_post_update;
				}

			}

			// remove old entries that does not exist in request object
			$deleted_entries = array_diff( $old_entries,  $entries_ids);
			if ( !empty( $deleted_entries ) ) {
				foreach ( $deleted_entries as $deleted_entry_id ) {
					wp_trash_post( $deleted_entry_id );
				}
			}

		}

	}

	if ( $post_update && !is_wp_error( $post_update ) ) {
		$result['id'] = $post_update;

		ob_start();
		get_template_part('navs/nav-logged');
		$nav_html = ob_get_contents();
		$result['nav'] = $nav_html;
		ob_end_clean();
    	
    	ob_start();
        get_template_part('templates/content-view_post');
		$output_html = ob_get_contents();
		$result['html'] = $output_html;
		ob_end_clean();
	}

	return $result;

}

/**
* delete post
*
* @param array $post_info
* @return post data | false
*/
function mo_delete_post( $post_info ) {
	$user_id = (int)mo_crypt($post_info['u'], 'd');
	$post_id = $post_info['post'];
	$reason = $post_info['reasons'];
	$notes = $post_info['notes'];
    $post_group = get_post_meta( $post_id, 'mo_workshop_shared_with', true );
    $user_url = get_author_posts_url( $user_id );

    update_post_meta( $post_id, 'mo_delete_reason', $reason );
    update_post_meta( $post_id, 'mo_delete_notes', $notes );
    update_post_meta( $post_id, 'mo_delete_user', $user_url );

    $delete_post = wp_trash_post( $post_id );

    // if post was in group remove from group metabox
    if ( $delete_post ) {
	    if ( !empty( $post_group ) && $post_group !== 'all' ) {
	    	mo_add_remove_group_post( $post_group, $post_id, true );
	    }
    }

	return $delete_post;

}

/**
* report post
*
* @param array $post_info
* @return true | false
*/
function mo_report_post( $post_info ) {
	$user_id = (int)mo_crypt($post_info['u'], 'd');
	$post_id = $post_info['post'];
	$reason = $post_info['reasons'];
	$notes = $post_info['notes'];
    $user_url = get_author_posts_url( $user_id );
    $post_reports = get_post_meta( $post_id, 'mo_reports_group', true );

    if ( !is_array( $post_reports ) ) {
    	$post_reports = array();
    }

    $post_reports[] = array(
    	'reason'	=>	$reason,
    	'notes'		=>	$notes,
    	'user'		=>	$user_url,
    	'user_id'	=>	$user_id
    );

    $post_reported = update_post_meta( $post_id, 'mo_reports_group', $post_reports );

	return $post_reported;

}

/**
* get post
*
* @param array post_id & context(view/edit)
* @return WP_User | WP_Error
*/
function mo_get_post( $post_info ) {
	global $post_id;
	global $user_id;

	$output_html = $nav_html = '';
	$result = array();
	$post_id = $post_info['post_id'];
	$user_id = $post_info['user_id'];
	$post_type = get_post_type( $post_id );

	// post type exist
	if ( $post_type ) {

		$result['id'] = $post_id;

		if ( $post_info['context'] == 'edit' ) { // post author

			ob_start();
			get_template_part('navs/nav-post');
			$nav_html = ob_get_contents();
			$result['nav'] = $nav_html;
			ob_end_clean();
			
			ob_start();
			if ( $post_type == 'workshops' || $post_type == 'activities' ) {
				get_template_part('templates/content-add_workshop');
			} else {
				get_template_part('templates/content-add_post');
			}
			$output_html = ob_get_contents();
			$result['html'] = $output_html;
			ob_end_clean();

		} elseif ( $post_info['context'] == 'view' ) { // visitor
			
			ob_start();
			get_template_part('templates/content-view_post');
			$output_html = ob_get_contents();
			$result['html'] = $output_html;
			ob_end_clean();

			$result['nav'] = false;

		}

	}


	return $result;

}

/**
* Comment
*
* @param array comment data
* @return int | WP_Error
*/
function mo_add_comment( $comment_info ) {
	global $post_id;
	global $user_id;
	$output_html = '';

	$user_id = (int)mo_crypt($comment_info['u'], 'd');
	$comment_author = get_user_by( 'id', $user_id );
	$comment_author_name = $comment_author->first_name . ' ' . $comment_author->last_name;
	$post_id = $comment_info['post'];
	$content = $comment_info['content'];
	$parent = $comment_info['parent'];
	$side = $comment_info['side'];
	$user_agent = isset($comment_info['user_agent']) ? $comment_info['user_agent'] : '';

    $comment_information = array(
	    'comment_author' 	=> $comment_author_name,
	    'comment_content' 	=> $content,
	    'comment_parent' 	=> $parent,
	    'comment_post_ID' 	=> $post_id,
	    'comment_agent' 	=> $user_agent,
	    'comment_approved'	=>	1,
	    'user_id' 			=> $user_id
	  );
    
  	$add_comment = wp_insert_comment($comment_information);

  	if ( $add_comment ) {
  		// send notification to post author
		$notification_user_id = get_post_field ('post_author', $post_id);
		$notification_desc = $comment_author_name . ' قام بالتعيق على ' . get_the_title( $post_id );
		$notification_url = get_permalink( $post_id );
  		mo_send_notification( $notification_user_id, $user_id, $post_id, $notification_desc, $notification_url );

		ob_start();
		if ( $side ) {
			get_template_part('sidebars/sidebar-add_post_left');
		} else {
			get_template_part('templates/content-comments');
		}
		$output_html = ob_get_contents();
		$result['html'] = $output_html;
		ob_end_clean();
  	}
  	$post_author = (int)get_post_field ('post_author', $post_id);
  	$user_info = get_userdata($post_author);
  	$to = $user_info->user_email;
  	$subj = 'تعليق جديد '.get_the_title($post_id);
  	$msg = '<div style="direction: rtl; text-align: right;">لقد تم اضافت تعليق جديد: <br>'. $content.'</div>';
  	wp_mail( $to , $subj, $msg );
	return $output_html;

}

/**
* Get Profile
*
* @param $request_data array of user id & profile id
* @return string html & nav of page
*/
function mo_get_profile($request_data) {
	global $user_id;
	global $profile_id;
	global $group_id;
	$result = array();
	$output_html = '';
	$nav_html = '';
	$page_title = '';
	$page_perma = '';

	$profile_id = (int)mo_crypt($request_data['p'], 'd');
	$user_id = (int)mo_crypt($request_data['u'], 'd');

	if ( get_post_type( $profile_id ) && get_post_type( $profile_id ) == 'groups' ) {
		$page_title = get_the_title( $profile_id );
		$page_perma = get_permalink( $profile_id );
	} else {
		$first_name = get_user_meta( $profile_id, 'first_name', true );
		$last_name = get_user_meta( $profile_id, 'last_name', true );
		$page_title = $first_name . ' ' . explode(' ', $last_name, 2)[0];
		$page_perma = get_author_posts_url( $profile_id );
	}

	ob_start();
	if ( get_post_type( $profile_id ) && get_post_type( $profile_id ) == 'groups' ) {
		$group_id = $profile_id;
		get_template_part('templates/content-profile_group');
	} else {
		get_template_part('templates/content-profile_user');
	}
	$output_html = ob_get_contents();
	$result['html'] = $output_html;
	ob_end_clean();

	ob_start();
	if ( $user_id !== 0 ) {
		get_template_part('navs/nav-logged');
	} else {
		get_template_part('navs/nav-main');
	}
	$nav_html = ob_get_contents();
	$result['nav'] = $nav_html;
	ob_end_clean();


	$result['title'] = $page_title;
	$result['perma'] = $page_perma;

	return $result;

}

/**
* Get Archive
*
* @param $request_data array of post_type
* @return string html of page
*/
function mo_get_archive($request_data) {
	global $post_type;
	global $user_id;
	
	$result = array();
	$output_html = '';

	$post_type = $request_data['archive'];
	$user_id = (int)mo_crypt($request_data['u'], 'd');

	ob_start();
	get_template_part('templates/content-archive');
	$output_html = ob_get_contents();
	$result['html'] = $output_html;
	ob_end_clean();

	return $result;

}

/**
* Bookmark Post
*
* @param $request_data array of user_id, post_id, action
* @return string message (bookmarked, removed from bookmark)
*/
function mo_bookmark_post($request_data) {
	$message = '';
	$user_id = $request_data['user_id'];
	$post_id = $request_data['post_id'];
	$action = $request_data['action'];
	$user_bookmarks = explode( ',', get_user_meta( $user_id, 'user_bookmarks', true ) );
	$bookmarks_log = get_post_meta($post_id, 'mo_bookmarks_log_group', true);
	$bookmarks_updated;
	$logs_updated;

	// bookmark post
	if ($action) {
		// save in user profile
		// extra if condition to double check if the post was not bookmarked before (action parameter should make sure of that from the first place)
		if ( !in_array( $post_id, $user_bookmarks ) ) {
			$user_bookmarks[] = $post_id;
			$user_bookmarks = implode( ',', $user_bookmarks );

			$bookmarks_updated = update_user_meta( $user_id, 'user_bookmarks', $user_bookmarks );

		}
		// end save in user profile

		// save in post log
		// only update post logs if post was bookmarked in user profile successfully to ensure correct logging
		if ( $bookmarks_updated ) {

			if ( !is_array($bookmarks_log) ) {
				$bookmarks_log = array();
			}

			$profile_url = get_author_posts_url( $user_id );
			$bookmark_date = current_time('Y/m/d');

			$bookmarks_log[] = array(
				'user_url'	=>	$profile_url,
				'date'		=>	$bookmark_date,
				'user_id'	=>	$user_id
			);

			$logs_updated = update_post_meta( $post_id, 'mo_bookmarks_log_group', $bookmarks_log );
		}
		// end save in post log

		if ( $bookmarks_updated && $logs_updated ) {
			$message = 'تمت الإضافة إلى المحفظة بنجاح';
		}

	// remove from bookmark
	} else {

		// remove from user profile
		$post_key = array_search( $post_id, $user_bookmarks );

		// extra if condition to double check if the post was bookmarked before (action parameter should make sure of that from the first place)
		if ( $post_key !== false ) {
			unset($user_bookmarks[$post_key]);
			$user_bookmarks = implode( ',', $user_bookmarks );

			$bookmarks_updated = update_user_meta( $user_id, 'user_bookmarks', $user_bookmarks );
		}
		// end remove from user profile

		// remove from post log
		// only update post logs if post was removed from bookmarks in user profile successfully to ensure correct logging
		if ($bookmarks_updated) {

			if ( is_array($bookmarks_log) ) {

				foreach ($bookmarks_log as $key => $log) {

					if ( isset($log['user_id']) && $log['user_id'] == $user_id ) {
						unset($bookmarks_log[$key]);
						$bookmarks_log = array_values($bookmarks_log);
						$logs_updated = update_post_meta( $post_id, 'mo_bookmarks_log_group', $bookmarks_log );
						break;
					}
					
				}

			}

		}
		// end remove from post log

		if ( $bookmarks_updated && $logs_updated ) {
			$message = 'تمت إزالته من المحفظة بنجاح';
		}

	}


	return $message;

}


/**
* Get Tags
*
* @param $search_keyword
* @return array of found tags names keyed by tag id 
*/
function mo_get_tags($search_keyword) {
	
	$tags = get_terms( array(
		'taxonomy'		=>	'post_tag',
		'hide_empty'	=>	false,
		'fields'		=>	'id=>name',
		'search'		=>	$search_keyword
	) );

	return $tags;

}

/**
* Get Activity Steps
*
* @param $$activity_id
* @return array of activity steps
*/
function mo_fetch_activiy($activity_id) {
	$steps = get_post_meta( $activity_id, 'mo_entry_group', true );

	return $steps;

}

/**
* Get Facilitators
*
* @param $search_keyword
* @return array of found users ids
*/
function mo_get_facilitators($search_keyword) {
	
	$facilitators = get_users( array(
		'role'		=>	'facilitator',
		'hide_empty'	=>	false,
		'fields'		=>	'ID',
		'search'		=>	"*{$search_keyword}*",
		'search_columns'	=>	array( 'user_login', 'user_email', 'user_nicename', 'display_name' )
	) );

	return $facilitators;

}

/**
* create group
*
* @param array $group_info
* @return group html & id | WP_Error
*/
function mo_create_group( $group_info ) {
	global $group_id;
	global $user_id;

	$user_id = $group_title = $group_desc = $output_html = '';

	$group_meta = array();
	$group_members = array();
	$group_admins = array();
	$result = array();
	//$currentUserID =  get_current_user_id();

	if ( isset( $group_info['user_id'] ) ) {
		$user_id = $group_info['user_id'];
	}

	if ( isset( $group_info['title'] ) ) {
		$group_title = $group_info['title'];
	}

	if ( isset( $group_info['desc'] ) ) {
		$group_desc = $group_info['desc'];
	}

	if (!empty($user_id)) {
		$currentUser_first_name = get_user_meta($user_id,'first_name',true);
		$currentUser_last_name = get_user_meta($user_id,'last_name',true);
		$currentUser_fullname = $currentUser_first_name . ' ' . $currentUser_last_name;
		$acurrentUsere_url = get_author_posts_url( $user_id );
		$group_members[] = array(
        	'name'			=>	$currentUser_fullname,
        	'profile_url'	=>	$currentUser_profile_url,
        	'user_id'		=>	$user_id
        );
        $group_admins[] = array(
        	'name'			=>	$currentUser_fullname,
        	'profile_url'	=>	$currentUser_profile_url,
        	'user_id'		=>	$user_id
        );
	}
	if ( isset( $group_info['members'] ) && is_array( $group_info['members'] ) ) {

		foreach ($group_info['members'] as $member_id) {
			$member_first_name = get_user_meta( $member_id, 'first_name', true );
	        $member_last_name = get_user_meta( $member_id, 'last_name', true );
	        $member_fullname = $member_first_name . ' ' . $member_last_name;
	        $member_profile_url = get_author_posts_url( $member_id );

	        $group_members[] = array(
	        	'name'			=>	$member_fullname,
	        	'profile_url'	=>	$member_profile_url,
	        	'user_id'		=>	$member_id
	        );
		}
	}
	$group_meta['mo_group_members'] = $group_members;
	if ( isset( $group_info['admins'] ) && is_array( $group_info['admins'] ) ) {

		foreach ($group_info['admins'] as $admin_id) {
			$admin_first_name = get_user_meta( $admin_id, 'first_name', true );
	        $admin_last_name = get_user_meta( $admin_id, 'last_name', true );
	        $admin_fullname = $admin_first_name . ' ' . $admin_last_name;
	        $admin_profile_url = get_author_posts_url( $admin_id );

	        $group_admins[] = array(
	        	'name'			=>	$admin_fullname,
	        	'profile_url'	=>	$admin_profile_url,
	        	'user_id'		=>	$admin_id
	        );
		}
	}
	$group_meta['mo_group_admins'] = $group_admins;

	if ( !empty($user_id) ) {
		 $group_information = array(
	      'post_title' 		=>	$group_title,
		  'post_content'	=> 	$group_desc,
	      'post_type'  		=>	'groups',
	      'post_status' 	=>	'publish',
	      'post_author' 	=>	$user_id,
	      'meta_input'		=>	$group_meta
	    );
	}

    $group_id = wp_insert_post( $group_information );

    if ( $group_id !== 0 ) {

    	if ( isset( $group_info['photo_id'] ) ) {
			set_post_thumbnail( $group_id, $group_info['photo_id'] );
		}

		////////////////////////////////////////////////////////////////////////
		// update members and admins group CMB after group has been successfully created
		if ( isset( $group_info['admins'] ) && is_array( $group_info['admins'] ) ) {
			foreach ($group_info['admins'] as $admin_id) {
				mo_add_remove_group_member( $group_id, $admin_id );
			}
		}

		if ( isset( $group_info['members'] ) && is_array( $group_info['members'] ) ) {
			foreach ($group_info['members'] as $member_id) {
				mo_add_remove_group_member( $group_id, $member_id );
			}
		}
		////////////////////////////////////////////////////////////////////////
		
    	$result['id'] = $group_id;
    	
    	ob_start();
        get_template_part('templates/content-profile_group');
		$output_html = ob_get_contents();
		$result['html'] = $output_html;
		ob_end_clean();

    }

	return $result;

}

/**
* create group
*
* @param array $group_info
* @return group html & id | WP_Error
*/
function mo_update_group( $group_info ) {

	$group_id = $user_id = $group_title = $group_desc = '';

	$group_meta = array();
	$group_members = array();
	$group_admins = array();
	$result = array();


	if ( isset( $group_info['id'] ) ) {
		$group_id = $group_info['id'];
	}

	$prev_group_admins = get_post_meta( $group_id, 'mo_group_admins', true );
	$prev_group_members = get_post_meta( $group_id, 'mo_group_members', true );

	if ( isset( $group_info['user_id'] ) ) {
		$user_id = $group_info['user_id'];
	}

	if ( isset( $group_info['title'] ) ) {
		$group_title = $group_info['title'];
	}

	if ( isset( $group_info['desc'] ) ) {
		$group_desc = $group_info['desc'];
	}

	if ( isset( $group_info['members'] ) && is_array( $group_info['members'] ) ) {

		foreach ($group_info['members'] as $member_id) {
			$member_first_name = get_user_meta( $member_id, 'first_name', true );
	        $member_last_name = get_user_meta( $member_id, 'last_name', true );
	        $member_fullname = $member_first_name . ' ' . $member_last_name;
	        $member_profile_url = get_author_posts_url( $member_id );

	        $group_members[] = array(
	        	'name'			=>	$member_fullname,
	        	'profile_url'	=>	$member_profile_url,
	        	'user_id'		=>	$member_id
	        );
		}

		$group_meta['mo_group_members'] = $group_members;
	}

	if ( isset( $group_info['admins'] ) && is_array( $group_info['admins'] ) ) {

		foreach ($group_info['admins'] as $admin_id) {
			$admin_first_name = get_user_meta( $admin_id, 'first_name', true );
	        $admin_last_name = get_user_meta( $admin_id, 'last_name', true );
	        $admin_fullname = $admin_first_name . ' ' . $admin_last_name;
	        $admin_profile_url = get_author_posts_url( $admin_id );

	        $group_admins[] = array(
	        	'name'			=>	$admin_fullname,
	        	'profile_url'	=>	$admin_profile_url,
	        	'user_id'		=>	$admin_id
	        );
		}

		$group_meta['mo_group_admins'] = $group_admins;
	}

	if ( !empty( $user_id ) && !empty( $group_id ) ) {
		 $group_information = array(
		  'ID'				=>	$group_id,
	      'post_title' 		=>	$group_title,
		  'post_content'	=> 	$group_desc,
	      'post_type'  		=>	'groups',
	      'post_status' 	=>	'publish',
	      'post_author' 	=>	$user_id,
	      'meta_input'		=>	$group_meta
	    );
	}

    $group_id = wp_insert_post( $group_information );

    if ( $group_id !== 0 ) {

		////////////////////////////////////////////////////////////////////////
    	// reset old admins & members group CMB
    	foreach ($prev_group_members as $prev_group_member) {
    	 	$prev_group_member_id = $prev_group_member['user_id'];
			mo_add_remove_group_member( $group_id, $prev_group_member_id, true );
    	 }

    	 foreach ($prev_group_admins as $prev_group_admin) {
    	 	$prev_group_admin_id = $prev_group_admin['user_id'];
			mo_add_remove_group_member( $group_id, $prev_group_admin_id, true );
    	 }
		////////////////////////////////////////////////////////////////////////


		////////////////////////////////////////////////////////////////////////
    	 // update the new admin & members group cmb with group id
    	if ( isset( $group_info['admins'] ) && is_array( $group_info['admins'] ) ) {
			foreach ($group_info['admins'] as $admin_id) {
				mo_add_remove_group_member( $group_id, $admin_id );
			}
		}

		if ( isset( $group_info['members'] ) && is_array( $group_info['members'] ) ) {
			foreach ($group_info['members'] as $member_id) {
				mo_add_remove_group_member( $group_id, $member_id );
			}
		}
		////////////////////////////////////////////////////////////////////////


    	if ( isset( $group_info['photo_id'] ) ) {
			set_post_thumbnail( $group_id, $group_info['photo_id'] );
		}

		
		
    	$result['id'] = $group_id;

    }

	return $result;

}

/**
* load all
*
* @param array $post_type, cats
* @return result html
*/

function mo_load_all( $request_info ) {
	global $post_id;
	global $user_id;

	$user_id = $type = $cats = $output_html = '';

	$tax_query = array();


	if ( isset( $request_info['u'] ) ) {
		$user_id = (int)mo_crypt($request_info['u'], 'd');
	}

	if ( isset( $request_info['type'] ) ) {
		$type = $request_info['type'];
	}

	if ( isset( $request_info['cat'] ) && $request_info['cat'] ) {
		$cats = $request_info['cat'];
		$tax_query[] = array(
			'taxonomy' => 'category',
	        'field'    => 'term_id',
	        'terms'    => $cats,
		);
	}


	if ( $type == 'bookmarks' && $user_id !== 0 ) {
		$posts = get_user_meta( $user_id, 'user_bookmarks', true );

		if ( !empty($posts) ) {
            $posts_arr = explode( ',', $posts );

            if ( !empty( $posts_arr ) ) {
            	foreach ($posts_arr as $post_id) {
            		if ( !empty($post_id) ) {
	            		ob_start();
	            		$output_html .= '<div class="col-md-6 col-xl-4 mz-mb-35">';
						get_template_part('templates/content-card_new');
						$output_html .= ob_get_contents();
						$output_html .= '</div>';
						ob_end_clean();
            		}
            	}
            }
        }

	} else {

		$posts = get_posts( array(
			'post_type'         =>  $type,
		    'post_status'       =>  'publish',
		    'posts_per_page'    =>  -1,
		    'post_parent'       =>  0,
		    'fields'            =>  'ids',
		    'tax_query'			=> $tax_query
		) );



		if ( !empty( $posts ) ) {
	// var_dump($posts);

			// foreach ($posts as $post_id) {
        	// 	ob_start();
        	// 	$output_html .= '<div class="col-md-6 col-xl-4 mz-mb-35">';
			// 	get_template_part('templates/content-card_new');
			// 	$output_html .= ob_get_contents();
			// 	$output_html .= '</div>';
			// 	ob_end_clean();
        	// }
			foreach ($posts as $key => $post_id) {
        		ob_start();
				
        		$output_html .= '<div class="col-md-6 col-xl-4 mz-mb-35">';
				get_template_part('templates/content-card_new');
				$output_html .= ob_get_contents();
				$output_html .= '</div>';
				ob_end_clean();
				ob_start();
				if(($key > 0) && ($key % 4 == 0)){
					$output_html .= '<div class="col-md-6 col-xl-4 mz-mb-35">';
					$suggestion =  rand(1,3); 
					switch($suggestion){
						case 1: 
							get_template_part('templates/content-suggestions-1');
							break;
						case 2:
							get_template_part('templates/content-suggestions-2');
							break;
						case 3: 
							get_template_part('templates/content-suggestions-3');
							break;
					}  
					$output_html .= ob_get_contents();
					$output_html .= '</div>';
				}
				ob_end_clean();
        	}
		}


	}

	return $output_html;

}

/**
* Search
*
* @param array $post_type, cats
* @return result html
*/

function mo_get_search( $request_info ) {
	global $types;
	global $keyword;
	global $participants;
	global $age;
	global $duration;
	global $user_id;

	if ( isset( $request_info['u'] ) ) {
		$user_id = (int)mo_crypt($request_info['u'], 'd');
	}

	if ( isset( $request_info['types'] ) ) {
		$types = $request_info['types'];
	}

	if ( isset( $request_info['participants'] ) ) {
		$participants = $request_info['participants'];
	}

	if ( isset( $request_info['age'] ) ) {
		$age = $request_info['age'];
	}

	if ( isset( $request_info['duration'] ) ) {
		$duration = $request_info['duration'];
	}

	if ( isset( $request_info['keyword'] ) ) {
		$keyword = $request_info['keyword'];
	}

	ob_start();
	get_template_part('templates/content-search_result');
	$output_html = ob_get_contents();
	ob_end_clean();

	return $output_html;

}

/**
* Search Side
*
* @param array $post_type, cats
* @return result html
*/

function mo_get_search_side( $request_info ) {
	global $sidebar_search_id;
	$result_posts;
	$output_html = '';

	$result_posts_args = array(
		'post_type'         =>  array( 'activities', 'workshops' ),
		'post_status'       =>  'publish',
		'posts_per_page'    =>  -1,
		//'post_parent'       =>  0,
		'fields'            =>  'ids',
		'include_children'  =>  true,
	);

	if ( isset( $request_info['u'] ) ) {
		$user_id = (int)mo_crypt($request_info['u'], 'd');
	}

	if ( isset( $request_info['keyword'] ) ) {
		$keyword = $request_info['keyword'];
		$result_posts_args['s'] = $keyword;

		$result_posts = get_posts( $result_posts_args );

	}

	if ( !empty($result_posts) ) {
		foreach ($result_posts as $key => $sidebar_search_id) {
			$result_post_type = get_post_type( $sidebar_search_id );
			ob_start();
			print_r($result_post_type);
			// if ( ($result_post_type != 'activities') || ($result_post_type != 'workshops') ) {
			if($result_post_type == 'workshops'){
				$output_html .= '<div class="mz-mb-35 nodrag">';
			} else {
				$output_html .= '<div class="mz-mb-35">';
			}
			get_template_part('templates/content-card');
			$output_html .= ob_get_contents();
			$output_html .= '</div>';
			ob_end_clean();
		}
	}



	return $output_html;

}

/**
* Get tag archive
*
* @param $request_data array of user id & page id
* @return string html & nav of page
*/
function mo_get_tag($request_data) {
	global $tag_id;
	global $tag_name;
	$output_html = '';
	$result = array();

	$tag_id = $request_data['tag'];

	if ( $tag_id ) {
		$tag = get_tag($tag_id);

		if ($tag && !is_wp_error($tag)) {
			$tag_name = $tag->name;
		}

		$result['name'] = $tag_name;

		ob_start();
		get_template_part('templates/content-tag');
		$output_html = ob_get_contents();
		$result['html'] = $output_html;
		ob_end_clean();
	}
	

	return $result;

}

/**
* Update user
*
* @param array $register_info
* @return bool
*/
function mo_update_user( $user_info ) {
	$bdate = $user_info['bdate'];
	$fullname = sanitize_text_field( $user_info['fullname'] );
	$first_name = explode(' ', $fullname, 2)[0];
	$last_name = explode(' ', $fullname, 2)[1];
	$display_name = $first_name . ' ' . explode(' ', $last_name, 2)[0];
	$nicename = sanitize_title($fullname);
	$email = $user_info['email'];
	$desc = $user_info['desc'];
	$user_id = $user_info['user_id'];
	$user_groups = get_user_meta( $user_id, 'user_groups', true );
	if ( isset( $user_info['photo_id'] ) ) {
		$photo_id = $user_info['photo_id'];
		$photo = wp_get_attachment_image_url($photo_id, 'full');
	}


	if ( $user_id ) {
		
		$user = wp_update_user( array (
			'ID'				=> $user_id,
			'user_nicename'		=>	$nicename,
			'user_email'		=>	$email,
			'display_name'		=>	$display_name,
			// 'nickname'			=>	$display_name,
			'first_name'		=>	$first_name,
			'last_name'			=>	$last_name
		) );

		if (!is_wp_error($user)) {
			update_user_meta( $user, 'user_bdate', $bdate );
			update_user_meta( $user, 'description', $desc );
			update_user_meta( $user, 'user_groups', $user_groups );

			if ( isset( $user_info['photo_id'] ) ) {
				update_user_meta( $user, 'user_img', $photo );
				update_user_meta( $user, 'user_img_id', $photo_id );
			}

			wp_update_user( $user );

			return true;
		}

	}

	return false;

}

/**
* Upload Post Attachments
*
* @param array $register_info
* @return bool
*/
function mo_upload_post_attach( $user_info ) {
	$user_id = $user_info['user_id'];
	$post_id = $user_info['p'];
	$post_attachments = get_post_meta($post_id, 'mo_post_attachments', true);
	$result = array();

	if ( !is_array( $post_attachments ) ) {
		$post_attachments = array();
	}

	if ( isset( $user_info['attach_id'] ) ) {
		$photo_id = $user_info['attach_id'];
		$photo = wp_get_attachment_url($photo_id);
	}


	if ( $post_id ) {
		$post_attachments[$photo_id] = $photo;
		update_post_meta( $post_id, 'mo_post_attachments', $post_attachments );

		$result['type'] = get_post_mime_type($photo_id);
		$result['name'] = get_the_title($photo_id);
		$result['size'] = filesize( get_attached_file( $photo_id ) );
		return $result;
	}

	return false;

}

/**
* read notification
*
* @param int $user_id
* @return bool
*/
function mo_read_notification( $user_id ) {
	$notifications = get_user_meta( $user_id, 'mo_notification_group', true );
	$result = array();

	if ( !empty($notifications) ) {
		foreach ($notifications as $notification) {
			$notification['read'] = 'on';
			$result[] = $notification;
		}
		update_user_meta( $user_id, 'mo_notification_group', $result );
	}



	return true;

}

/**
* add Post Material
*
* @param array $register_info
* @return bool
*/
function mo_add_post_material( $user_info ) {
	$user_id = $user_info['user_id'];
	$post_id = $user_info['p'];
	$title = $user_info['title'];
	$number = $user_info['number'];
	$post_material = get_post_meta($post_id, 'mo_workshop_material_group', true);
	$material = array();
	$result = array();

	if ( !is_array( $post_material ) ) {
		$post_material = array();
	}

	if ( isset( $user_info['title'] ) ) {
		$material['title'] = $title;
	}

	if ( isset( $user_info['number'] ) ) {
		$material['number'] = $number;
	}


	if ( $post_id ) {
		$post_material[] = $material;
		update_post_meta( $post_id, 'mo_workshop_material_group', $post_material );
		$result['title'] = $title;
		$result['number'] = $number;
		return $result;
	}

	return false;

	
}
// function my_remove_array_item( $array, $item ) {
// 	$index = array_search($item, $array);
// 	if ( $index !== false ) {
// 		unset( $array[$index] );
// 	}

// 	return $array;
// }
function mo_remove_post_material( $user_info ) {
	$user_id = $user_info['user_id'];
	$post_id = $user_info['p'];
	$post_material = get_post_meta($post_id, 'mo_workshop_material_group', true);
	$deleted_Items = $user_info['deleted'];
	$material = array();
	$result = array();

	if ( !is_array( $post_material ) ) {
		$post_material = array();
	}
	if ( $post_id ) {
		$post_material[] = $material;
		unset($post_material[$deleted_Items]);
		array_splice($post_material, $deleted_Items, 1);
		// $post_material = my_remove_array_item( $items, $deleted_Items ); // remove item called 'second'
		update_post_meta( $post_id, 'mo_workshop_material_group', $post_material );
		$result['message'] = 'deleted';
		return $result;
	}
	return false;

}


/**
* Clone Post
*
* @param $request_data array of user_id, post_id
* @return string message (cloned)
*/
function mo_clone_post($request_data) {
	global $wpdb;
	$message = '';
	$result_url = '';
	$result = array();
	$user_id = $request_data['user_id'];
	$post_id = $request_data['post_id'];
	$clone_log = get_post_meta($post_id, 'mo_clone_log_group', true);
	$logs_updated;
	$new_post_id = false;

	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			'post_author'    => $user_id,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_status'    => 'private',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				if( $meta_key == '_wp_old_slug' ) continue;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}

		// update cloned checkbox meta to prevent title changing in the future
		update_post_meta( $new_post_id, 'mo_cloned_check', true );
		update_post_meta( $new_post_id, 'mo_original_cloned_id',$post_id );
 
	} else {
		return false;
	}


	if ( $new_post_id ) {

		// workshop handle
		if ( $post->post_type == 'workshops' ) {
			$days = get_posts( array(
				'post_type'         =>  $post->post_type,
				'post_status'       =>  'publish',
				'nopaging'          =>  true,
				'posts_per_page'    =>  -1,
				'post_parent'       =>  $post_id,
				'fields'            =>  'ids',
				'order'             =>  'ASC',
				'orderby'           =>  'meta_value',
				'meta_key'          =>  'mo_day_target'
			) );

			if ( !empty( $days ) ) {

				foreach ($days as $day) {
					$day_post = get_post( $day );
					$day_args = array(
						'post_author'    => $user_id,
						'post_content'   => $day_post->post_content,
						'post_excerpt'   => $day_post->post_excerpt,
						'post_name'      => $day_post->post_name,
						'post_parent'    => $new_post_id,
						'post_status'    => 'publish',
						'post_title'     => $day_post->post_title,
						'post_type'      => $day_post->post_type,
					);
					$new_day_id = wp_insert_post( $day_args );
					/*
					* duplicate all day meta just in two SQL queries
					*/
					$day_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$day");
					if (count($day_meta_infos)!=0) {
						$day_sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
						foreach ($day_meta_infos as $day_meta_info) {
							$day_meta_key = $day_meta_info->meta_key;
							if( $day_meta_key == '_wp_old_slug' ) continue;
							$day_meta_value = addslashes($day_meta_info->meta_value);
							$day_sql_query_sel[]= "SELECT $new_day_id, '$day_meta_key', '$day_meta_value'";
						}
						$day_sql_query.= implode(" UNION ALL ", $day_sql_query_sel);
						$wpdb->query($day_sql_query);
					}

					// get entries under day
					$entries = get_posts( array(
						'post_type'         =>  $day_post->post_type,
						'post_parent'		=>	$day,
						'nopaging'          =>  true,
						'posts_per_page'    =>  -1,
						'fields'            =>  'ids',
						'order'             =>  'ASC',
						'orderby'           =>  'meta_value_num',
						'meta_key'          =>  'mo_entry_order'
					) );

					if ( !empty( $entries ) ) {
						foreach ( $entries as $entry ) {
							$entry_post = get_post( $entry );
							$entry_args = array(
								'post_author'    => $user_id,
								'post_content'   => $entry_post->post_content,
								'post_excerpt'   => $entry_post->post_excerpt,
								'post_name'      => $entry_post->post_name,
								'post_parent'    => $new_day_id,
								'post_status'    => 'publish',
								'post_title'     => $entry_post->post_title,
								'post_type'      => $entry_post->post_type,
							);
							$new_entry_id = wp_insert_post( $entry_args );

							/*
							* duplicate all day meta just in two SQL queries
							*/
							$entry_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$entry");
							if (count($entry_meta_infos)!=0) {
								$entry_sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
								foreach ($entry_meta_infos as $entry_meta_info) {
									$entry_meta_key = $entry_meta_info->meta_key;
									if( $entry_meta_key == '_wp_old_slug' ) continue;
									$entry_meta_value = addslashes($entry_meta_info->meta_value);
									$entry_sql_query_sel[]= "SELECT $new_entry_id, '$entry_meta_key', '$entry_meta_value'";
								}
								$entry_sql_query.= implode(" UNION ALL ", $entry_sql_query_sel);
								$wpdb->query($entry_sql_query);
							}

						}
					}

				}

			}
		}
		// workshop handle


		// save in post log
		if ( !is_array($clone_log) ) {
			$clone_log = array();
		}
	
		$cloned_post_url = get_the_permalink( $new_post_id );
		$bookmark_date = current_time('Y/m/d');
	
		$clone_log[] = array(
			'user_url'	=>	$cloned_post_url,
			'date'		=>	$bookmark_date,
			'user_id'	=>	$user_id,
			'post_id'	=>	$new_post_id
		);
	
		$logs_updated = update_post_meta( $post_id, 'mo_clone_log_group', $clone_log );
		// end save in post log
	}

	if ( $logs_updated ) {
		$message = 'تم النسخ بنجاح';

		$result['url'] = $cloned_post_url;
		$result['message'] = $message;
	}



	return $result;

}



?>