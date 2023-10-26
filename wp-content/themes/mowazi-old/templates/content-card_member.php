<?php
global $profile_id;

$first_name = get_user_meta( $profile_id, 'first_name', true );
$last_name = get_user_meta( $profile_id, 'last_name', true );
$fullname = $first_name . ' ' . $last_name;

$profile_avatar = wp_get_attachment_image_url( get_user_meta( $profile_id, 'user_img_id', 1 ), 'avatar-xl' );
$profile_url = get_author_posts_url( $profile_id );

$profile_bio = get_user_meta( $profile_id, 'description', true );
?>
<div class="card card-member">
    <div class="card-header">
        <!-- info preview component -->
        <div class="info-preview">
            <!-- avatar component -->
            <div class="avatar avatar-sm" <?php if ($profile_avatar) { echo 'data-avatar="' . $profile_avatar . '"'; } ?>></div>
            <!-- end of avatar component -->
            <div class="info info-sm">
                <h4 class="info-title"><?php echo $fullname; ?></h4>
            </div>
            <!-- end of user preview component -->
        </div>
    </div>
    <div class="card-body">
        <p class="card-text"><?php echo $profile_bio; ?></p>
    </div>
    <div class="card-footer">
        <a href="<?php echo $profile_url; ?>" class="stretched-link get-profile" data-p="<?php echo mo_crypt($profile_id, 'e'); ?>">عرض الملف الشخصي</a>
    </div>
</div>