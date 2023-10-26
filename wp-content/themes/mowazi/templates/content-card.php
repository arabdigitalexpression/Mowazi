<?php
global $post_id;
global $user_id;
global $sidebar_bookmarks_post_id;
global $sidebar_search_id;

// if template was called from left side bar bookmark
if ( $sidebar_bookmarks_post_id ) {
    $post_id = $sidebar_bookmarks_post_id;
}

// if template was called from left side bar search
if ( $sidebar_search_id ) {
    $post_id = $sidebar_search_id;
}

$is_featured = wp_get_post_terms( $post_id, 'category', array( 'include'    =>  array(5), 'fields'  =>  'ids' ) );
$post_title = get_the_title( $post_id );
$post_date = get_the_date('d F', $post_id);
$post_excerpt = wp_trim_excerpt('', $post_id);
$post_tags = get_the_tags($post_id);

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

?>
<div class="card <?php if ( in_array( $post_id, $user_bookmarks_arr ) ) { echo 'bookmarked'; } ?>">

<?php 
//for searching of ice-breakers
    $post = get_post($post_id);
    $parent = $post->post_parent;
    if($parent){
        $parent_post = get_post($parent);
        $parent2 = $parent_post->post_parent;
        if($parent2){
            $parent2_post = get_post($parent2);
            $ice_breaker_parent_link = get_the_permalink($parent2);
            // echo $ice_breaker_parent_link;
        }
    }
?>

    <a href="<?php 
        if($ice_breaker_parent_link){ 
            echo $ice_breaker_parent_link; 
            } else { 
                echo get_the_permalink($post_id);
            } ?>"
        class="stretched-link get-post" data-c="view" data-id="<?php if($ice_breaker_parent_link){ 
            echo $parent2;
            } else {echo $post_id;} ?>" title="<?php echo $post_title; ?>"></a>

    <?php if ( !is_wp_error( $is_featured ) && !empty( $is_featured ) ) { ?>
    <div class="special-content">
        <i class="icon-star"></i>
        <span>متميز</span>
    </div>
    <?php } ?>
    
    <?php if ( $user_id != $post_author_id ) { // if post owner dont show bookmark button ?>
    <div class="card-controls">
        <a class="bookmark" href="#" data-b="<?php echo $post_id; ?>"><i class="icon-bookmark"></i></a>
    </div>
    <?php } ?>

    <div class="card-img-top" <?php if ($image) { echo 'data-avatar="' . $image . '"'; } ?>></div>

    <?php if ( $post_date ) { ?>
    <div class="card-header">
        <p><?php echo $post_date; ?></p>
    </div>
    <?php } ?>

    <div class="card-body">

        <?php 
        //if searching for icebreakers, display workshop name
        if($ice_breaker_parent_link):?>
            <h3 class="card-parent-title"><?php echo get_the_title($parent2);?></h3>
        <?php endif;?>

        <h5 class="card-title"><?php echo $post_title; ?></h5>
        <p class="card-text"><?php echo $post_excerpt; ?></p>
    </div>

    <div class="card-footer">
        <?php
       /* if ($post_tags && !is_wp_error($post_tags)) {
            foreach ($post_tags as $key => $tag) {*/
        ?>
       <!--  <a href="<?php /*echo get_term_link($tag->term_id);*/ ?>" class="btn tag tag-sm" data-t="<?php/* echo $tag->term_id;*/ ?>" title="<?php /*echo $tag->name;*/ ?>"><?php /*echo $tag->name;*/ ?></a> -->
        <?php /* } }*/ ?>

        <?php if ( !empty($participants) || !empty($maxParticipants) || !empty($age) || !empty($duration) ) { ?>
        <div class="card-details">
            <?php if ( !empty($age) ) { ?>
            <p><i class="icon-icon-users"></i><?php echo $age_labels[$age]; ?></p>
            <?php } if ( !empty($participants) ) { ?>
            <p><i class="icon-icon-group"></i><?php echo $participants_labels[$participants]; ?>-<?php echo $participants_labels[$maxParticipants]; ?></p>
            <?php } if ( !empty($duration) ) { ?>
            <p><i class="icon-icon-clock"></i><?php //echo $duration_labels[$duration];?> <?php echo $duration_hrs. ' ساعة '.$duration. ' دقيقة';?></p>
            <?php } ?>
        </div>
        <?php } ?>
        <?php if ($shared_with != 'all') {?>
            <a href="<?php echo $group_url; ?>" class="info-preview " title="<?php if (!empty($group_title)) { echo $group_title; } ?>" data-p="<?php echo mo_crypt($post_author_id, 'e'); ?>">
                <div class="avatar avatar-sm" <?php if ($group_avatar) { echo 'data-avatar="' . $group_avatar . '"'; } ?>></div>
                <div class="info info-sm">
                    <?php if (!empty($group_title)) { ?>
                    <h4 class="info-title"><?php echo $group_title; ?></h4>
                    <?php } ?>
                </div>
            </a> 
           
        <?php } else { ?>
            <a href="<?php echo $post_author_url; ?>" class="info-preview get-profile" title="<?php if (!empty($fullname)) { echo $fullname; } ?>" data-p="<?php echo mo_crypt($post_author_id, 'e'); ?>">
                <div class="avatar avatar-sm" <?php if ($post_author_avatar) { echo 'data-avatar="' . $post_author_avatar . '"'; } ?>></div>
                <div class="info info-sm">
                    <?php if (!empty($fullname)) { ?>
                    <h4 class="info-title"><?php echo $fullname; ?></h4>
                    <?php } ?>
                </div>
            </a>
        <?php }?>
    </div>
</div>