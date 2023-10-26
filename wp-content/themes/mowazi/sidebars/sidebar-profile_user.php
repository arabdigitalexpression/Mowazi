<?php
global $profile_id;
global $user_id;

if ( !$user_id ) {
    $user_id = get_current_user_id();
}

$first_name = get_user_meta( $profile_id, 'first_name', true );
$last_name = get_user_meta( $profile_id, 'last_name', true );
$fullname = $first_name . ' ' . $last_name;

$profile_avatar = wp_get_attachment_image_url( get_user_meta( $profile_id, 'user_img_id', 1 ), 'avatar-xl' );
$profile_url = get_author_posts_url( $profile_id );

$profile_bio = get_user_meta( $profile_id, 'description', true );

?>
<div class="sidebar">
    <div class="card preview-card">
        <div class="card-body">
            <!-- info preview component -->
            <div class="info-preview info-preview__lg" data-p="<?php echo mo_crypt($profile_id, 'e'); ?>">
                <!-- avatar component -->
                <!-- href="<?php //echo $profile_url; ?>" class="info-preview info-preview__lg get-profile" title="<?php // if (!empty($fullname)) { echo $fullname; } ?>" data-p="<?php //echo mo_crypt($profile_id, 'e'); ?>"> -->

                <div class="avatar avatar-xl changeable <?php if ( !$profile_avatar || empty( $profile_avatar ) ) { echo 'placeholder'; } ?>" data-avatar="<?php if ( $profile_avatar && !empty( $profile_avatar ) ) { echo $profile_avatar; } else { echo get_template_directory_uri() .  '/images/logo-sm.svg'; } ?>">
                    <?php if ( $profile_id == $user_id ) { ?>
                    <div class="change-photo">
                        <p><i class="icon-camera-alt-solid"></i>تغيير</p>
                    </div>
                    <?php } ?>
                </div>
                <!-- end of avatar component -->
                <div class="info info-sm">
                    <?php if (!empty($fullname)) { ?>
                    <a href="<?php echo $profile_url; ?>" class="info-title get-profile" title="<?php if (!empty($fullname)) { echo $fullname; } ?>" data-p="<?php echo mo_crypt($profile_id, 'e'); ?>"><?php echo $fullname; ?></a>
                    <?php } ?>
                </div>
                <!-- end of user preview component -->
            </div>
            <?php if (!empty($profile_bio)) { ?>
            <p class="card-text text-center"><?php echo $profile_bio; ?></p>
            <?php } ?>
        </div>
    </div>
</div>