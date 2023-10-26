<?php
global $post_id;
global $user_id;
global $activity_id;

if ( !$post_id ) {
    $post_id = $wp_query->get_queried_object()->ID;
}

if (!$user_id) {
    $user_id = get_current_user_id();
}

$post_type = get_post_type( $post_id );
$post_title = get_the_title( $post_id );
$post_date = get_the_date( 'Y/m/d', $post_id );
$post_comments_count = get_comment_count( $post_id );
$post_tags = get_the_tags( $post_id );

//sorting tags
if ( $post_tags && ! is_wp_error( $post_tags ) ) {
    usort( $post_tags, function( $a, $b ) {
        return $b->count - $a->count; // Swap $a and $b for ascending order.
    } );
}
$post_content = get_post($post_id);
$content = $post_content->post_content;
$content = apply_filters('the_content', $content);
$post_author = (int)get_post_field ('post_author', $post_id);
$post_author_group = get_post_meta( $post_id, 'mo_workshop_shared_with', true );
$post_reports = get_post_meta( $post_id, 'mo_reports_group', true );
$post_clones = get_post_meta( $post_id, 'mo_clone_log_group', true );
$post_is_aclone = get_post_meta( $post_id, 'mo_cloned_check', true );
$users_reported = array();

$workshop_activities = get_post_meta( $post_id, 'activities', true);
   
// print_r( $post_collaborators);
// echo "hi user is ";
// echo $user_id;

// print_r(mo_check_group_post( $post_id, $user_id ));

//workshop attr

$post_participants = get_post_meta( $post_id, 'mo_workshop_activity_participants', true );
$post_max_participants = get_post_meta( $post_id, 'mo_workshop_activity_max_participants', true );
$post_age_range = get_post_meta( $post_id, 'mo_workshop_activity_age', true );
$post_duration_hrs = get_post_meta( $post_id, 'mo_workshop_activity_duration_hrs', true );
$post_duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );
$post_location = get_post_meta( $post_id, 'mo_workshop_location', true );
$post_goals = get_post_meta( $post_id, 'mo_workshop_goals', true );
$post_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );
$post_materials = get_post_meta( $post_id, 'mo_workshop_material_group', true );
$post_attachments = get_post_meta( $post_id, 'mo_post_attachments', true );

if($duration && !$post_duration_hrs){
    update_post_meta($post_id, 'mo_workshop_activity_duration_hrs', '0');
}

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
?>
<section class="view-content">
    <div class="container">
        <div class="row">

        <div class="col-md-3">
                <div class="sidebar-sticky">
                    <?php get_template_part('sidebars/sidebar-view_post_scrollspy'); ?>
                    <!-- <?php pvc_post_views($postid = $post_id, $echo=true); ?> -->
                    <?php
                        $clones_count = 0;
                        if($post_clones){
                            $clones_count = count( $post_clones ) + 1;
                        }
                        $author_first_name = get_user_meta( $post_author, 'first_name', true );
                        $author_last_name = get_user_meta( $post_author, 'last_name', true );
                        $author_fullname = $author_first_name . ' ' . $author_last_name;
                        $author_profile_avatar = wp_get_attachment_image_url( get_user_meta( $post_author, 'user_img_id', 1 ), 'avatar-sm' );
                    ?>
                    <div class="card card-clone">
                        <img src="<?php echo get_template_directory_uri()?>/images/why-mowazi-2.svg" alt="">
                        <p>محتوي موازي كله مفتوح المصدر محتوي موازي كله مفتوح المصدر ويمكنك استخدامه والتعديل عليه.ويمكنك استخدامه والتعديل عليه.</p>
                        <a href="#" class="btn btn-blue2 clone mr-auto ml-4" data-c="<?php echo $post_id; ?>"><i class="icon-clipboard ml-3"></i>استخدم المحتوي</a>
                    </div>
                    <div class="card card-author_history">
                        <div class="card-header">
                            <div class="info">
                                <div>
                                    <span><i class="icon-history"></i></span>
                                    
                                    <h4 class="info-title">تاريخ الإسناد</h4>
                                </div>
                                <p class="info-subtitle"><?php echo $clones_count; ?> عضو استنسخ من هذا النشاط</p>

                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($post_is_aclone != ''){
                                $original_post_id = get_post_meta( $post_id, 'mo_original_cloned_id', true );
                                $original_post_author = (int)get_post_field ('post_author', $original_post_id);
                                $original_author_first_name = get_user_meta( $original_post_author, 'first_name', true );
                                $original_author_last_name = get_user_meta( $original_post_author, 'last_name', true );
                                $original_author_fullname = $original_author_first_name . ' ' . $original_author_last_name;
                                $original_author_profile_avatar = wp_get_attachment_image_url( get_user_meta( $original_post_author, 'user_img_id', 1 ), 'avatar-sm' );
                                $original_post_date = get_the_date( 'Y/m/d', $original_post_id ); ?>
                                <a href="<?php echo get_the_permalink( $original_post_id ); ?>" class="info-preview get-post" data-id="<?php echo $original_post_id; ?>" data-c="view">
                                    <!-- avatar component -->
                                    <div class="avatar avatar-sm" <?php if ($original_author_profile_avatar) { echo 'data-avatar="' . $original_author_profile_avatar . '"'; } ?>><i class="icon-pen-cirlce"></i></div>
                                    <!-- end of avatar component -->
                                    <div  class="info info-sm">
                                        
                                        <h4 class="info-title"><?php echo $original_author_fullname; ?></h4>
                                        <p class="info-subtitle"><?php echo $original_post_date; ?></p>
                                    </div>
                                    <!-- end of user preview component -->
                                </a>
                            <?php }
                            if($post_author_group != 'all'){
                                $author_group_profile_avatar = get_the_post_thumbnail_url( $post_author_group);
                                $author_group_name =  get_the_title($post_author_group); ?>
                                <a href="<?php echo get_the_permalink( $post_author_group ); ?>" class="info-preview">
                                    <!-- avatar component -->
                                    <div class="avatar avatar-sm" <?php if ($author_group_profile_avatar) { echo 'data-avatar="' . $author_group_profile_avatar . '"'; } ?>><i class="icon-pen-cirlce"></i></div>
                                    <!-- end of avatar component -->
                                    <div  class="info info-sm">
                                        
                                        <h4 class="info-title"><?php echo $author_group_name; ?></h4>
                                        <p class="info-subtitle"><?php echo $post_date; ?></p>
                                    </div>
                                    <!-- end of user preview component -->
                                </a>
                            <?php }else{ ?>
                                <a href="<?php echo get_the_permalink( $post_id ); ?>" class="info-preview get-post" data-id="<?php echo $post_id; ?>" data-c="view">
                                    <!-- avatar component -->
                                    <div class="avatar avatar-sm" <?php if ($author_profile_avatar) { echo 'data-avatar="' . $author_profile_avatar . '"'; } ?>><i class="icon-pen-cirlce"></i></div>
                                    <!-- end of avatar component -->
                                    <div  class="info info-sm">
                                        
                                        <h4 class="info-title"><?php echo $author_fullname; ?></h4>
                                        <p class="info-subtitle"><?php echo $post_date; ?></p>
                                    </div>
                                    <!-- end of user preview component -->
                                </a>
                            <?php }
                            if ( !empty( $post_clones ) ) {
                                foreach ( $post_clones as $post_clone ) {
                                    $cloned_post_id = $cloned_post_url = $cloned_post_author_id = $cloned_post_date = '';

                                    if ( isset( $post_clone['user_url'] ) ) {
                                        $cloned_post_url = $post_clone['user_url'];
                                    }

                                    if ( isset( $post_clone['date'] ) ) {
                                        $cloned_post_date = $post_clone['date'];
                                    }

                                    if ( isset( $post_clone['post_id'] ) ) {
                                        $cloned_post_id = $post_clone['post_id'];
                                        $cloned_post_status = get_post_status( $cloned_post_id );
                                    }

                                    if ( isset( $post_clone['user_id'] ) ) {
                                        $cloned_post_author_id = $post_clone['user_id'];
                                        $cloned_author_first_name = get_user_meta( $cloned_post_author_id, 'first_name', true );
                                        $cloned_author_last_name = get_user_meta( $cloned_post_author_id, 'last_name', true );
                                        $cloned_author_fullname = $cloned_author_first_name . ' ' . $cloned_author_last_name;
                                        $cloned_author_profile_avatar = wp_get_attachment_image_url( get_user_meta( $cloned_post_author_id, 'user_img_id', 1 ), 'avatar-sm' );
                                    }

                                    if ( $cloned_post_status && $cloned_post_status == 'publish' ) {
                                ?>
                                    <a href="<?php echo $cloned_post_url; ?>" class="info-preview get-post" data-id="<?php echo $cloned_post_id; ?>" data-c="view">
                                        <!-- avatar component -->
                                        <div class="avatar avatar-sm" <?php if ($cloned_author_profile_avatar) { echo 'data-avatar="' . $cloned_author_profile_avatar . '"'; } ?>></div>
                                        <!-- end of avatar component -->
                                        <div  class="info info-sm">
                                            <h4 class="info-title"><?php echo $cloned_author_fullname; ?></h4>
                                            <p class="info-subtitle"><?php echo $cloned_post_date; ?></p>
                                        </div>
                                        <!-- end of user preview component -->
                                    </a>
                                <?php } }
                            } ?>
                        </div>
                        <!-- <a href="#" class="card-footer">
                            <h6>عرض الكل (23)</h6>
                        </a> -->
                    </div>  

                    <?php $edit_link =  get_site_url() . "/wp-admin/post.php?post=" . $post_id . "&action=edit";?>
                   
                    <?php if(user_can( $user_id, 'manage_options' ) ): ?>
                        <a target="_blank" href="<?php echo $edit_link; ?>"><span class="btn btn-outline-secondary btn-sm">تعديل</span></a>
                    <?php endif;?>

                        <?php // edit_post_link( __( 'تعديل', 'foundationpress' ), '<span class="btn btn-outline-secondary btn-sm">', '</span>' ); ?>
                    
                    
                </div>
            </div>









            <div class="col-md-9">
                 <ul class="breadcrumbs">
                    <li><a href="<?php echo get_site_url(); ?>">الرئسية</a></li>
                    <li>/</li>
                    <li><a href="<?php echo get_post_type_archive_link($post_type); ?>"><?php echo arabicPostType($post_type); ?></a></li>
                    <li>/</li>
                    <li><?php echo $post_title; ?></li>
                </ul>
                <div class="view-content_container">
                    <?php //echo breadcrumbs($post_type); ?>
                    <div class="view-content__container_header <?php if ( in_array( $post_id, $user_bookmarks_arr ) ) { echo 'bookmarked'; } ?>">
                        <h1>
                            <?php if ( $post_title ) { echo $post_title; } ?>
                            <div class="post-controls">

                                <div class="post-views-count">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>'/images/views-icon.png'" alt="">
                                    <?php pvc_post_views($postid = $post_id, $echo=true); ?>
                                </div>
                                <div class="dropdown">
                                    <button class=" share-button dropdown-toggle" type="button" id="dropdownShareButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-fontello-share"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownShareButton" id="shareButtons">
                                        <?php echo do_shortcode("[mashshare shares='false' networks='facebook,twitter' services='2' size='small' text=\"$post_title\" buttons='true' align='left' url=\"$url\"]");?>
                                        <button class="copy-link" title="Copy link to clipboard" onclick="copyLink(null)"><i class="icon-clipboard"></i></button>
                                    </div>
                                </div>

                                <?php if ( $post_author == $user_id ) { // profile owner ?>
                                <a class="edit get-post" href="<?php echo get_the_permalink($post_id); ?>" data-c="edit" data-id="<?php echo $post_id; ?>"><i class="icon-edit"> </i></a>
                                <?php } elseif ( in_array( $user_id, $post_collaborators ) || mo_check_group_post( $post_id, $user_id ) ) {
                                ?>
                                <a class="edit get-post mr-auto ml-3" href="<?php echo get_the_permalink($post_id); ?>" data-c="edit" data-id="<?php echo $post_id; ?>"><i class="icon-edit"> </i></a>
                                <a href="#" class="bookmark" data-b="<?php echo $post_id; ?>"><i class="icon-bookmark"></i></a>
                                <?php
                                } else { ?>
                                <!-- <a href="#" class="btn btn-primary clone mr-auto ml-4" data-c="<?php echo $post_id; ?>"><i class="icon-clipboard ml-3"></i>استنسخ</a> -->
                                <a href="#" class="bookmark" data-b="<?php echo $post_id; ?>"><i class="icon-bookmark"></i></a>
                                <?php } ?>
                            </div>
                        </h1>

                        <?php if ( $post_tags && !is_wp_error( $post_tags ) ) { ?>
                        <!-- <div class="tags-wrapper">
                            <?php foreach ($post_tags as $key => $post_tag) { ?>
                            <a href="<?php echo get_term_link($post_tag->term_id); ?>" class="btn tag tag-sm tag-related" data-t="<?php echo $post_tag->term_id; ?>" title="<?php echo $post_tag->name; ?>"><?php echo $post_tag->name; ?></a>
                            <?php } ?>
                        </div> -->
                        <?php } ?>
                        <!-- <div class="post-info">
                            <?php if($post_duration!='' && $post_duration_hrs!=''): ?>
                                <div class="post-duration">
                                    <i class="icon-icon-clock"></i>
                                     <span><?php echo $post_duration_hrs. ' ساعة'; ?></span>
                                     <span><?php echo $post_duration. ' دقيقة'; ?></span>
                                </div>
                            <?php endif;
                            if($post_age_range): ?>
                                <div class="post-age-range">
                                    <i class="icon-icon-group"></i>
                                     <span><?php echo $post_age_range; ?></span>
                                </div>
                            <?php endif;
                            if($post_participants && $post_max_participants): ?>
                               <div class="post-participants">
                                    <i class="icon-icon-users"></i>
                                     <span><?php echo $post_participants.'-'.$post_max_participants; ?></span>
                                </div>
                            <?php endif; ?>
                        </div> -->
                        <?php if($post_location): ?>
                            <!-- <div class="post-info">
                                <div class="post-location">
                                    <i class="icon-fontello-location-outline"></i>
                                     <span><?php echo $post_location; ?></span>
                                </div>
                                
                            </div> -->
                        <?php endif; ?>
                        <div class="post-details">
                            <?php if ( $post_date ) { ?>
                            <div class="post-time">
                                <i class="icon-clock-fill"></i>
                                <span><?php echo $post_date; ?></span>
                            </div>
                            <?php } ?>
                            <?php if ( $post_comments_count && isset($post_comments_count['approved']) && $post_comments_count['approved'] !== 0 ) { ?>
                            <div class="post-comments">
                                <i class="icon-comment"></i>
                                <span><?php echo $post_comments_count['approved'] ?> تعليقات</span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="view-content__container_body">
                                <?php //echo $workshop_activities; ?>
                        <!-- <?php //if ( $workshop_activities  && $post_type == 'workshops') :?>
                            <div class="activities-attached">
                            <?php //foreach ($workshop_activities as $post_id):?>
                               	<?php //get_template_part( 'templates/content-card_new' );?>
                            <?php //endforeach;?>
                            </div>
                       <?php //endif;?> -->

                        <?php if ( $content ) { echo $content; } 
                        if ( !empty( $post_goals ) && $post_type == 'workshops' ) { ?>
                            <div class="post-goals">
                                <h3>أهداف الورشة</h3>
                                <div><?php echo nl2br( esc_html($post_goals)); ?></div>
                            </div>
                        <?php }
                       if ( !empty( $post_materials )) {
                            $material_count = 0; ?>
                            <div class="post-materials">
                                <h3>المواد المطلوبة </h3>
                                <table>
                                    <thead>
                                        <th></th>
                                        <th>البند</th>
                                        <th>العدد</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($post_materials as $material) {
                                            $material_count++;
                                            echo "<tr>";
                                            echo "<td>".$material_count."</td>";
                                            echo "<td>".$material['title']."</td>";
                                            echo "<td>".$material['number']."</td>";
                                            echo "</tr>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php }
                        if ( !empty( $days ) && $post_type == 'workshops' ) {
                            $days_count = 0;
                        ?>
                        <div class="accordion" id="daysAccordion">
                            <?php
                            foreach ($days as $day) {
                                $days_count++;
                                $entries_args['post_parent'] = $day;
                                $entries = get_posts( $entries_args );

                                if ( !empty( $entries ) ) {
                                
                            ?>
                                <div class="card mb-2 shadow-none border" >
                                    <button class="btn btn-link <?php if ( $days_count !== 1 ) { echo 'collapsed'; } ?>" type="button" data-toggle="collapse" data-target="#collapse_<?php echo $day; ?>" aria-expanded="<?php if ( $days_count == 1 ) { echo 'true'; } else { echo 'false'; } ?>" aria-controls="collapse_<?php echo $day; ?>">
                                          <?php echo get_the_title( $day ); ?>
                                    </button>

                                    <div id="collapse_<?php echo $day; ?>" class="collapse <?php if ( $days_count == 1 ) { echo 'show'; } ?>" data-parent="#daysAccordion">
                                      <div class="card-body">
                                        <?php
                                        

                                        foreach ($entries as $entry_id) {
                                            $steps = get_post_meta( $entry_id, 'mo_entry_group', true );
                                        ?>
                                        <h3 class="workshop-days"><?php echo get_the_title( $entry_id ); ?></h3>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                <th scope="col"></th>
                                                <th scope="col">الوقت</th>
                                                <th scope="col" colspan="2">الوصف</th>
                                                <th scope="col">ملاحظات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
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
                                                ?>
                                                <tr>
                                                    <th scope="row"><span class="rotate"><?php echo $step_title; ?></span>
                                                        
                                                    </th>
                                                    <td><?php echo $step_duration; ?></td>
                                                    <td colspan="2"><?php echo $step_desc; ?></td>
                                                    <td><?php echo $step_note; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        }
                                        ?>
                                      </div>
                                    </div>
                                </div>
                            <?php } } ?>
                        </div>
                        <?php
                        } elseif ( $post_type == 'activities' ) {
                             // activity type
                            $entries_args['p'] = $post_id;
                            $entries = get_posts( $entries_args );
                            foreach ($entries as $entry_id) {
                                $steps = get_post_meta( $entry_id, 'mo_entry_group', true );
                        ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                <th scope="col"></th>
                                <th scope="col" colspan="2">الوصف</th>
                                <th scope="col">الوقت</th>
                                <th scope="col">ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                ?>
                                <tr>
                                    <th scope="row"><span class="rotate"><?php echo $step_title; ?></span>
                                        
                                    </th>
                                    <td colspan="2"><?php echo $step_desc; ?></td>
                                    <td><?php echo $step_duration; ?></td>
                                    <td><?php echo $step_note; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php
                            }
                        }
                        ////////////////////////////////
                        if (!empty($post_attachments)){ ?>
                            <div class="post-attachments">
                                <h3>قائمة المرفقات </h3>
                                <ul>
                                    <?php 
                                    foreach ( $post_attachments as $post_attachment_id => $post_attachments_url ) {
                                        $post_attachment_name = $post_attachment_type = $post_attachment_size = '';
                                        $post_attachment_name = get_the_title( $post_attachment_id );
                                        $post_attachment_type = get_post_mime_type($post_attachment_id);
                                        $post_attachment_size = round(filesize( get_attached_file( $post_attachment_id ) ) / 1024); ?>
                                       <li>
                                           <div class="formate"><?php echo $post_attachment_type; ?></div>
                                           <a href="<?php echo $post_attachments_url; ?>" target="_blank">
                                                <?php echo $post_attachment_name .'<br>'; ?>
                                                <span><?php echo  $post_attachment_size;?> KB</span>       
                                            </a>
                                      </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="view-content__container_footer">
                        <div class="report-us">
                            <!-- <span class="mo-icon-circle"> -->
                                <i class="icon-danger">
                                </i>
                            <!-- </span> -->
                            <span>ساعدنا بالتبليغ عن المحتوي الغير مناسب</span>
                            </span>
                        </div>

                        <?php if ( ( $user_id !== $post_author ) && !in_array( $user_id, $users_reported ) ) { ?>
                        <a href="#" data-toggle="modal" data-target="#reportPost" class="btn btn-outline-dark report-btn" data-id="<?php echo $post_id; ?>"> <i class="icon-flag"></i>
                        <span> أبلغ عن المحتوي </span>
                        </a>
                        <?php get_template_part('modals/modal-report_post'); ?>     
                        <?php }
                        elseif (in_array( $user_id, $users_reported )) { ?>
                             <span style="font-size: 12px;"> قمتم بالتبليغ عن هذا المحتوى سابقا </span>
                         <?php } ?>

                    </div>
                </div>

                <?php get_template_part('templates/content-comments'); ?>

                <div class="post-tags">
                    <h4># الوسوم</h4>
                    <div class="tags-wrapper">
                        <?php foreach ($post_tags as $key => $post_tag) { ?>
                        <a href="<?php echo get_term_link($post_tag->term_id); ?>" class="btn tag tag-sm tag-related" data-t="<?php echo $post_tag->term_id; ?>" title="<?php echo $post_tag->name; ?>"><?php echo $post_tag->name; ?> (<?php echo $post_tag->count; ?>)</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="suggestion">
                    <?php get_template_part('templates/content-suggestions-1')?>
                </div>

                <?php
                $related_post_tags = array();

                if ( $post_tags && !is_wp_error( $post_tags ) ) {
                    foreach ($post_tags as $key => $post_tag) {
                        if ( !in_array( $post_tag->term_id, $related_post_tags ) ) {
                            $related_post_tags[] = $post_tag->term_id;
                        }
                    }
                }

                $related_posts = get_posts( array(
                    'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                    'post_status'       =>  'publish',
                    'posts_per_page'    =>  4,
                    'post_parent'       =>  0,
                    'post__not_in'      =>  array( $post_id ),
                    'fields'            =>  'ids',
                    'tag__in'           => $related_post_tags,
                    'author__not_in'    =>  array( $user_id )
                ) );

                $related_posts_by_type = get_posts( array(
                    'post_type'         =>  $post_type,
                    'post_status'       =>  'publish',
                    'orderby'           => 'date',
                    'order'             => 'DESC',
                    'posts_per_page'    =>  4,
                    'post_parent'       =>  0,
                    'post__not_in'      =>  array( $post_id ),
                    'fields'            =>  'ids',
                    // 'tag__in'           => $related_post_tags,
                    'author__not_in'    =>  array( $user_id )
                ) );


                $tags_ids_for_related = array ();
                $tags_for_related = array_slice($post_tags, 0 ,4);
                if ( $tags_for_related && !is_wp_error( $tags_for_related ) ) {
                    foreach ($tags_for_related as $key => $post_tag) {
                        if ( !in_array( $post_tag->term_id, $tags_ids_for_related) ) {
                            $tags_ids_for_related[] = $post_tag->term_id;
                        }
                    }
                }
                $available_tags = count($tags_ids_for_related);
                $related_posts_tags_0 = array();
                $related_posts_tags_1 = array();
                $related_posts_tags_2 = array();
                
                switch($available_tags){
                    case 1:
                        $related_posts_tags_0 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  4,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related,
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        break;
                    case 2:
                        $related_posts_tags_0 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  2,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[0],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        $related_posts_tags_1 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  2,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id, $related_posts_tags_0[0], $related_posts_tags_0[1] ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[1],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        break;
                    case 3:
                        $related_posts_tags_0 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  2,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[0],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        $related_posts_tags_1 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  1,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id, $related_posts_tags_0[0], $related_posts_tags_0[1] ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[1],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        $related_posts_tags_2 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  1,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id, $related_posts_tags_0[0], $related_posts_tags_0[1], $related_posts_tags_1[0] ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[2],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        break;
                    case 4:
                        $related_posts_tags_0 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  1,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[0],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        $related_posts_tags_1 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  1,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id, $related_posts_tags_0[0], $related_posts_tags_1[0] ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[1],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        $related_posts_tags_2 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  1,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id, $related_posts_tags_0[0], $related_posts_tags_1[0] ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[2],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        $related_posts_tags_3 = get_posts( array(
                            'post_type'         =>  array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                            'post_status'       =>  'publish',
                            'posts_per_page'    =>  1,
                            'post_parent'       =>  0,
                            'post__not_in'      =>  array( $post_id, $related_posts_tags_0[0], $related_posts_tags_1[0], $related_posts_tags_2[0] ),
                            'fields'            =>  'ids',
                            'tag__in'           => $tags_ids_for_related[3],
                            // 'author__not_in'    =>  array( $user_id )
                        ) );
                        break;
                };

                if($post_author_group == 'all'){
                $related_posts_by_author = get_posts( array(
                    'post_type'         =>   array( 'workshops', 'activities', 'articles', 'stories', 'games' ),
                    'post_status'       =>  'publish',
                    'orderby'           => 'date',
                    'order'             => 'DESC',
                    'posts_per_page'    =>  4,
                    'post_parent'       =>  0,
                    'post__not_in'      =>  array( $post_id ),
                    'fields'            =>  'ids',
                    // 'tag__in'           => $related_post_tags,
                    // 'author__not_in'    =>  array( $user_id )
                    'author'            => $post_author
                    ) );
                }
                if($post_author_group != 'all'){
                    $related_posts_by_group =  get_post_meta( $post_author_group, 'mo_group_posts', true );
                    $related_posts_by_group = array_slice($related_posts_by_group, -4);
                }
                
                if ( !empty( $related_posts ) || !empty($related_posts_by_type) || !empty($related_posts_by_author) || !empty($related_posts_by_group) ) {
                    global $related_post_id;
                ?>
                <div class="related-posts">
                    <!-- <p class="related-header"> مواضيع ذات صلة </p> -->
                    <p class="related-header">المزيد</p>
                    <nav>
                        <div class="nav nav-tabs" id="related-tabs" role="tablist">
                            <a class="nav-item nav-link active" id="nav-same-type-tab" data-toggle="tab" href="#nav-same-type" role="tab" aria-controls="nav-same-type" aria-selected="true">نفس الفئة</a>
                            <a class="nav-item nav-link" id="nav-same-topic-tab" data-toggle="tab" href="#nav-same-topic" role="tab" aria-controls="nav-same-topic" aria-selected="false">نفس الموضوع</a>
                            <a class="nav-item nav-link" id="nav-same-author-tab" data-toggle="tab" href="#nav-same-author" role="tab" aria-controls="nav-same-author" aria-selected="false">نفس الشخص</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="related-tabsContent">

                        <!-- related posts by type -->
                        <div class="tab-pane fade show active" id="nav-same-type" role="tabpanel" aria-labelledby="nav-same-type-tab">
                            <div class="row">
                                <?php // foreach ($related_posts as $related_post_id) { ?>
                                <?php foreach ($related_posts_by_type as $post_id) { ?>
                                <div class="col-md-6 mz-mb-35">
                                    <?php //get_template_part('templates/content-card_related'); ?>
                                    <?php get_template_part('templates/content-card_new'); ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- related posts by tag -->
                        <div class="tab-pane fade" id="nav-same-topic" role="tabpanel" aria-labelledby="nav-same-topic-tab">
                            <div class="row">
                                <?php if(!empty($related_posts_tags_0)):?>
                                    <?php // foreach ($related_posts as $related_post_id) { ?>
                                    <?php foreach ($related_posts_tags_0 as $post_id) { ?>
                                    <div class="col-md-6 mz-mb-35">
                                        <?php //get_template_part('templates/content-card_related'); ?>
                                        <?php get_template_part('templates/content-card_new'); ?>
                                    </div>
                                    <?php } ?>
                                <?php endif;?>
                                <?php if(!empty($related_posts_tags_1)):?>
                                    <?php // foreach ($related_posts as $related_post_id) { ?>
                                    <?php foreach ($related_posts_tags_1 as $post_id) { ?>
                                    <div class="col-md-6 mz-mb-35">
                                        <?php //get_template_part('templates/content-card_related'); ?>
                                        <?php get_template_part('templates/content-card_new'); ?>
                                    </div>
                                    <?php } ?>
                                <?php endif;?>

                                <?php if(!empty($related_posts_tags_2)):?>
                                    <?php // foreach ($related_posts as $related_post_id) { ?>
                                    <?php foreach ($related_posts_tags_2 as $post_id) { ?>
                                    <div class="col-md-6 mz-mb-35">
                                        <?php //get_template_part('templates/content-card_related'); ?>
                                        <?php get_template_part('templates/content-card_new'); ?>
                                    </div>
                                    <?php } ?>
                                <?php endif;?>
                                <?php if(!empty($related_posts_tags_3)):?>
                                    <?php // foreach ($related_posts as $related_post_id) { ?>
                                    <?php foreach ($related_posts_tags_3 as $post_id) { ?>
                                    <div class="col-md-6 mz-mb-35">
                                        <?php //get_template_part('templates/content-card_related'); ?>
                                        <?php get_template_part('templates/content-card_new'); ?>
                                    </div>
                                    <?php } ?>
                                <?php endif;?>

                                <?php if(empty($related_posts_tags_0) && 
                                        empty($related_posts_tags_1) && 
                                        empty($related_posts_tags_2) && 
                                        empty($related_posts_tags_3)
                                 ):?>
                                 <h6 class="no-related-content">لا يوجد محتوى متاح من الوسوم المستخدمة الآن</h6>
                                 <?php endif;?>

                            </div>

                        </div>

                        <!-- related posts by author or group -->
                        <div class="tab-pane fade" id="nav-same-author" role="tabpanel" aria-labelledby="nav-same-author-tab">

                            <div class="row">
                                <?php if($related_posts_by_author):?>
                                    <?php // foreach ($related_posts as $related_post_id) { ?>
                                    <?php foreach ($related_posts_by_author as $post_id) { ?>
                                        <div class="col-md-6 mz-mb-35">
                                            <?php //get_template_part('templates/content-card_related'); ?>
                                            <?php get_template_part('templates/content-card_new'); ?>
                                        </div>
                                    <?php } ?>
                                <?php endif;?>

                                <?php if($related_posts_by_group):?>
                                    <?php foreach ($related_posts_by_group as $group_post) { 
                                            $post_id = $group_post['post_id'];
                                        ?>
                                    <div class="col-md-6 mz-mb-35">
                                        <?php //get_template_part('templates/content-card_related'); ?>
                                        <?php get_template_part('templates/content-card_new'); ?>
                                    </div>
                                    <?php } ?>
                                <?php endif;?>
                                <?php if(empty($related_posts_by_author) && empty($related_posts_by_group)):?>
                                    <h6 class="no-related-content">لا يوجد محتوى متاح من هذا المؤلف الآن</h6>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

                <div class="suggestion">
                    <?php get_template_part('templates/content-suggestions-3')?>
                </div>

            </div>
        </div>
    </div>
</section>