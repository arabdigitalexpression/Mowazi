<?php
global $post_id;
global $user_id;
global $sidebar_bookmarks_post_id;
global $sidebar_search_id;
global $activity_id;
global $icebreaker;
global $child_title;

// if template was called from left side bar bookmark
if ( $sidebar_bookmarks_post_id ) {
    $post_id = $sidebar_bookmarks_post_id;
}

// if template was called from left side bar search
if ( $sidebar_search_id ) {
    $post_id = $sidebar_search_id;
}
// if($activity_id){
//     // echo $activity_id;
//     $post_id = $activity_id;
// }

// print_r($icebreaker);
//for searching of ice-breakers
// $post = get_post($post_id);
// $parent = $post->post_parent;
// $parent2 = null;
// if($parent){
//     $parent_post = get_post($parent);
//     $parent2 = $parent_post->post_parent;
//     if($parent2){
//         $parent2_post = get_post($parent2);
//         $ice_breaker_parent_link = get_the_permalink($parent2);
//         // echo $ice_breaker_parent_link;
//     }
// }
// if($parent2 && ($parent2_post->post_type === 'workshops')){
//     $post_id = $parent2;
// }


$post_type = get_post_type($post_id);
$is_featured = wp_get_post_terms( $post_id, 'category', array( 'include'    =>  array(5), 'fields'  =>  'ids' ) );
$post_title = get_the_title( $post_id );
$post_date = get_the_date('d F', $post_id);

$post_date_d = get_the_date('d', $post_id);
$post_date_m = get_the_date('M', $post_id);
$post_date_y = get_the_date('Y', $post_id);


$post_excerpt = wp_trim_excerpt('', $post_id);
$post_tags = get_the_tags($post_id);
//sorting tags
if ( $post_tags && ! is_wp_error( $post_tags ) ) {
    usort( $post_tags, function( $a, $b ) {
        return $b->count - $a->count; // Swap $a and $b for ascending order.
    } );
}
$post_tags_four = array_slice($post_tags, 0, 4);


$participants = get_post_meta( $post_id, 'mo_workshop_activity_participants', true );
$maxParticipants = get_post_meta( $post_id, 'mo_workshop_activity_max_participants', true );

$age = get_post_meta( $post_id, 'mo_workshop_activity_age', true );
$duration_hrs = get_post_meta( $post_id, 'mo_workshop_activity_duration_hrs', true );
$duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );
$participants_labels = mo_generate_participants_range();
$age_labels = mo_generate_age_range();
$duration_labels = mo_generate_duration_range();
if($duration && !$post_duration_hrs){
    update_post_meta($post_id, 'mo_workshop_activity_duration_hrs', '0');
}
$image = get_the_post_thumbnail_url( $post_id, 'card-img' );

if ( !$image || empty( $image ) ) {
    $image = get_template_directory_uri() . '/images/card-covers/' . get_post_type( $post_id ) . '.jpg';
}

$post_author_id = get_post_field ('post_author', $post_id);
$first_name = get_user_meta( $post_author_id, 'first_name', true );
$last_name = get_user_meta( $post_author_id, 'last_name', true );
$fullname = $first_name . ' ' . $last_name;
$post_author_avatar = wp_get_attachment_image_url( get_user_meta( $post_author_id, 'user_img_id', 1 ), 'avatar-sm' );
$post_author_url = get_author_posts_url( $post_author_id );
$post_author_url = str_replace(" ","-",$post_author_url);

$user_bookmarks = get_user_meta( $user_id, 'user_bookmarks', true );
$user_bookmarks_arr = array();

if ( !empty($user_bookmarks) ) {
    $user_bookmarks_arr = explode( ',', $user_bookmarks );
}

// get group published
$shared_with = get_post_meta( $post_id, 'mo_workshop_shared_with', true );

if($shared_with != 'all') {
    $group_title = get_the_title( $shared_with );
    $group_avatar = get_the_post_thumbnail_url( $shared_with, 'avatar-md' );
    $group_url = get_permalink( $shared_with );
}



if ($post_type == 'articles') {

	$post_type_ar = 'مدونة';
    $post_type_icon =  get_stylesheet_directory_uri() . '/images/articles-icon.png';
    $post_type_color = "#FF595A";
   
} elseif ($post_type == 'activities') {

	$post_type_ar = 'نشاط';
    $post_type_icon =  get_stylesheet_directory_uri() . '/images/activity-icon.png';
    $post_type_color = "#0060E2";

} elseif ($post_type == 'workshops') {

	$post_type_ar = 'ورشة';
    $post_type_icon =  get_stylesheet_directory_uri() . '/images/activity-icon.png';
    $post_type_color = "#FFC055";

} elseif ($post_type == 'stories') {

	$post_type_ar = 'حكاية';
    $post_type_icon =  get_stylesheet_directory_uri() . '/images/articles-icon.png';
    $post_type_color = "#19D3C5";
    

} elseif ($post_type == 'games') {

	$post_type_ar = 'لعبة';
    $post_type_icon =  get_stylesheet_directory_uri() . '/images/activity-icon.png';
    $post_type_color = "#9164CC";
}

$url = get_the_permalink( $post_id );
?>

<div class="content-home-page-card card <?php if ( in_array( $post_id, $user_bookmarks_arr ) ) { echo 'bookmarked'; } ?>">
    <div class="card-controls">
        <?php if ( $user_id != $post_author_id ) { // if post owner dont show bookmark button ?>
            <a class="bookmark" href="#" data-b="<?php echo $post_id; ?>"><i class="icon-bookmark"></i></a>
        <?php } ?>
        <div class="dropdown">
            <button class=" share-button dropdown-toggle" type="button" id="dropdownShareButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-fontello-share"></i></button>
            <div class="dropdown-menu" aria-labelledby="dropdownShareButton" id="shareButtons">
                <?php echo do_shortcode("[mashshare shares='false' networks='facebook,twitter' services='2' size='small' text=\"$post_title\" buttons='true' align='left' url=\"$url\"]");?>
                <button class="copy-link" title="Copy link to clipboard" onclick="copyLink(this)"><i class="icon-clipboard"></i></button>
            </div>
        </div>
        <div class="post-views-count">
            <img src="<?php echo get_stylesheet_directory_uri();?>'/images/views-icon.png'" alt="">
            <?php pvc_post_views($postid = $post_id, $echo=true); ?>
        </div>
    </div>
    
    <div class="card-author">
        <?php if ($shared_with != 'all') {?>
            <a href="<?php echo $group_url; ?>" class="info-preview " title="<?php if (!empty($group_title)) { echo $group_title; } ?>" data-p="<?php echo mo_crypt($post_author_id, 'e'); ?>">
                <div class="avatar avatar-sm" <?php if ($group_avatar) { echo 'data-avatar="' . $group_avatar . '"'; } ?>></div>
                <div class=" author-name info info-sm">
                    <?php if (!empty($group_title)) { ?>
                    <p class="info-title"><?php echo $group_title; ?></p>
                    <?php } ?>
                </div>
            </a> 
        
        <?php } else { ?>
            <a href="<?php echo $post_author_url; ?>" class="info-preview get-profile" title="<?php if (!empty($fullname)) { echo $fullname; } ?>" data-p="<?php echo mo_crypt($post_author_id, 'e'); ?>">
                <div class="avatar avatar-sm" <?php if ($post_author_avatar) { echo 'data-avatar="' . $post_author_avatar . '"'; } ?>></div>
                <div class="author-name info">
                    <?php if (!empty($fullname)) { ?>
                    <p class="info-title"><?php echo $fullname; ?></p>
                    <?php } ?>
                </div>
            </a>
        <?php }?>
    </div>
    <div class="card-content">
        <!-- add get-post in class to enable ajax navigation -->
        <a href="<?php echo get_the_permalink($post_id); ?>" 
            class="stretched-link card-title" data-c="view" data-id="<?php echo $post_id; ?>" title="<?php echo $post_title; ?>">

            <?php if($icebreaker):?>
                <h5 class="card-parent-title"><?php echo get_the_title($post_id);?></h5>
                <h6><?php echo $child_title;?></h6>
            <?php else:?>
                <h6><?php echo $post_title;?></h6>
            <?php endif;?>
            </a>
        <div class="card-info">
            <div class="post-time info-item">
                <?php if ( wp_is_mobile() ):?>
                    <i class="icon-clock-fill"></i>
                <?php endif;?>
                <span><?php echo single_post_arabic_date($post_date_d, $post_date_m, $post_date_y); ?></span>
            </div>
            <div class="post-type info-item">
                <img src="<?php echo $post_type_icon;?>" alt="">
                <span style="color:<?php echo $post_type_color;?>"><?php echo $post_type_ar;?></span>
            </div>

            <?php if ( $post_tags_four && !is_wp_error( $post_tags_four ) ): ?>
            <div class="tags-wrapper info-item">
                <?php foreach ($post_tags_four as $key => $post_tag):?>
                <a href="<?php echo get_term_link($post_tag->term_id); ?>" class="btn tag tag-sm tag-related" data-t="<?php echo $post_tag->term_id; ?>" title="<?php echo $post_tag->name; ?>"><?php echo $post_tag->name; ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif;?>


            <?php if($post_duration_hrs!='' || $duration!='na'): ?>
            <div class="post-duration info-item">
                <?php if ( wp_is_mobile() ):?>
                    <i class="icon-icon-clock"></i>
                <?php endif;?>
                    <?php if($post_duration_hrs >= 1):?>
                        <span><?php echo $post_duration_hrs. ' ساعة'; ?></span>
                    <?php endif;?>
                    <?php if($duration != 'na'):?>
                        <span><?php echo " " . $duration. ' دقيقة'; ?></span>
                    <?php endif;?>
            </div>
            <?php endif;?>
            <?php if($age): ?>
                <div class="post-age-range info-item">
                <?php if ( wp_is_mobile() ):?>
                    <i class="icon-icon-users"></i>
                <?php endif;?>
                <span><?php echo $age; ?> سنة</span>
                </div>
            <?php endif;?>

            <?php if ( !empty($participants) ): ?>
            <div class="post-participants info-item">
                <?php if ( wp_is_mobile() ):?>
                    <i class="icon-icon-group"></i>
                <?php endif;?>
                <span><?php echo $participants_labels[$participants]; ?>-<?php echo $participants_labels[$maxParticipants]; ?>
                </span>
            </div>
            <?php endif;?>
            
        </div>
    </div>
</div>