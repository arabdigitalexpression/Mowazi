<?php
global $post_id;
global $user_id;
global $profile_id;
global $sidebar_posts_post_id;


// if template was called from left side bar
if ( $sidebar_posts_post_id ) {
    $post_id = $sidebar_posts_post_id;
}

$post_status = get_post_status($post_id);
$post_title = get_the_title( $post_id );

if ($post_status && $post_status == 'private') {
    $post_title = str_replace( 'Private: ', '', $post_title );
    $post_title = str_replace( 'خاص: ', '', $post_title );

    // get latest revison on private post
    $post_revisions = wp_get_post_revisions( $post_id );
    $post_latest_revision = '';
    if ( !empty($post_revisions) ) {
        $post_latest_revision = get_the_date('d F H:i', current($post_revisions)->ID);
    }
}

$post_excerpt = wp_trim_excerpt('', $post_id);

$participants = get_post_meta( $post_id, 'mo_workshop_activity_participants', true );
$maxParticipants = get_post_meta( $post_id, 'mo_workshop_activity_max_participants', true );
$age = get_post_meta( $post_id, 'mo_workshop_activity_age', true );
$duration_hrs = get_post_meta( $post_id, 'mo_workshop_activity_duration_hrs', true );
$duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );
if($duration && !$post_duration_hrs){
    update_post_meta($post_id, 'mo_workshop_activity_duration_hrs', '0');
}
$participants_labels = mo_generate_participants_range();
$age_labels = mo_generate_age_range();
$duration_labels = mo_generate_duration_range();

$post_tags = get_the_tags($post_id);

$post_date = get_the_date('d F', $post_id);

// profile owner info
$first_name = get_user_meta( $profile_id, 'first_name', true );
$last_name = get_user_meta( $profile_id, 'last_name', true );
$fullname = $first_name . ' ' . $last_name;
$profile_avatar = wp_get_attachment_image_url( get_user_meta( $profile_id, 'user_img_id', 1 ), 'avatar-sm' );

$user_bookmarks = explode( ',', get_user_meta( $user_id, 'user_bookmarks', true ) );
?>
<div class="card <?php if ($post_status && $post_status == 'private') { echo 'card-draft'; } if ( in_array( $post_id, $user_bookmarks ) ) { echo 'bookmarked'; } ?>">

    <?php if ( $profile_id !== $user_id ) { // Visitor ?>
    <a href="<?php echo get_the_permalink($post_id); ?>" class="stretched-link get-post" data-c="view" data-id="<?php echo $post_id; ?>" title="<?php echo $post_title; ?>"></a>
    <?php } ?>


    <?php if ($post_status && $post_status == 'private') { ?>
    <div class="draft-label">
        <i class="icon-icon-clock"></i>
        <span>تحت الانشاء</span>
    </div>
    <?php } ?>
    
    <div class="card-controls">
        <?php if ( $profile_id == $user_id ) { // profile owner ?>
        <a class="remove" href="#" data-toggle="modal" data-target="#deletePost" data-id="<?php echo $post_id; ?>"><i class="icon-delete"> </i></a>
        <a class="edit get-post" href="<?php echo get_the_permalink($post_id); ?>" data-c="edit" data-id="<?php echo $post_id; ?>"><i class="icon-edit"> </i></a>
        <?php } else { ?>
        <a class="bookmark" href="#" data-b="<?php echo $post_id; ?>"><i class="icon-bookmark"> </i></a>
        <?php } ?>
    </div>

    <?php if ($post_status && $post_status == 'publish' && $post_date) { ?>
    <div class="card-header">
        <p><?php echo $post_date; ?></p>
    </div>
    <?php } ?>
    
    <div class="card-body">
        <h5 class="card-title">
            <?php
            echo $post_title;
            if ($post_status && $post_status == 'private' && $post_latest_revision && !empty($post_latest_revision)) {
                echo '<p>اخر تعديل <span>' . $post_latest_revision . '</span> </p>';
            }
            ?>    
        </h5>
        <p class="card-text"><?php echo $post_excerpt; ?></p>
    </div>

    <?php if ($post_status && $post_status == 'publish') { ?>
    <div class="card-footer">

        <?php
        /*if ($post_tags && !is_wp_error($post_tags)) {
            foreach ($post_tags as $key => $tag) {*/
        ?>
       <!--  <a href="<?php /*echo get_term_link($tag->term_id);*/ ?>" class="btn tag tag-sm" data-t="<?php /*echo $tag->term_id;*/ ?>" title="<?php /*echo $tag->name;*/ ?>"><?php /*echo $tag->name;*/ ?></a> -->
        <?php /*} }*/ ?>

        <?php if ( !empty($participants) || !empty($age) || !empty($duration) ) { ?>
        <div class="card-details">
            <?php if ( !empty($age) ) { ?>
            <p><i class="icon-icon-users"></i><?php echo $age_labels[$age]; ?></p>
            <?php } if ( !empty($participants) ) { ?>
            <p><i class="icon-icon-group"></i><?php echo $participants_labels[$participants].'-'.$participants_labels[$maxParticipants]; ?></p>
            <?php } if ( !empty($duration) ) { ?>
            <p><i class="icon-icon-clock"></i><?php echo $duration_hrs. ' ساعة '.$duration. ' دقيقة';?></p>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ( $profile_id && ($profile_id !== $user_id) ) { // Visitor ?>
        <!-- info preview component -->
        <div class="info-preview">
            <!-- avatar component -->
            <div class="avatar avatar-sm" <?php if ($profile_avatar) { echo 'data-avatar="' . $profile_avatar . '"'; } ?>></div>
            <!-- end of avatar component -->
            <div class="info info-sm">
                <?php if (!empty($fullname)) { ?>
                <h4 class="info-title"><?php echo $fullname; ?></h4>
                <?php } ?>
            </div>
            <!-- end of user preview component -->
        </div>
        <?php } ?>

    </div>
    <?php } ?>
</div>