<?php
global $group_id;
global $user_id;

if ( !$user_id ) {
    $user_id = get_current_user_id();
}

$group_title = get_the_title( $group_id );

$group_avatar = get_the_post_thumbnail_url( $group_id, 'avatar-xl' );
$group_url = get_permalink( $group_id );

$group_desc = get_post($group_id);
$desc = $group_desc->post_content;


$members_count = 0;
$group_admins = get_post_meta( $group_id, 'mo_group_admins', true );
$group_members = get_post_meta( $group_id, 'mo_group_members', true );
$admins_arr = array();

if ( !empty( $group_admins ) && is_array( $group_admins ) ) {
    $members_count += count( $group_admins );

    foreach ($group_admins as $group_admin) {
        if ( !in_array( $group_admin['user_id'], $admins_arr ) ) {
            $admins_arr[] = $group_admin['user_id'];
        }
    }
}

if ( !empty( $group_members ) && is_array( $group_members ) ) {
    $members_count += count( $group_members );
}
?>
<div class="sidebar">
    <div class="card preview-card">
        <div class="card-body">
            <!-- info preview component -->
            <div  class="info-preview info-preview__lg">
            <!-- href="<?php //echo $group_url; ?>" -->
            <!-- title="<?php //if (!empty($group_title)) { echo $group_title; } ?>" data-p="<?php // echo mo_crypt($group_id, 'e'); ?>" -->
                <!-- avatar component -->
                 <div class="avatar avatar-xl changeable group-photo" data-avatar="<?php if ( $group_avatar && !empty( $group_avatar ) ) { echo $group_avatar; } else { echo get_template_directory_uri() .  '/images/logo-sm.svg'; } ?>">

                    <?php 
                    if ( in_array( $user_id, $admins_arr ) ) { ?>
                    <div class="change-photo">
                        <p><i class="icon-camera-alt-solid"></i>تغيير</p>
                    </div>
                    <?php } ?>
                </div>
                <!-- end of avatar component -->
                <div class="info info-sm">
                    <?php if (!empty($group_title)) { ?>
                    <h4 class="info-title"><?php echo $group_title; ?></h4>
                    <?php } ?>

                    <?php if ( $members_count !== 0 ) { ?>
                    <p class="info-subtitle"><?php echo $members_count; ?> عضو في المجموعة</p>
                    <?php } ?>
                </div>
                <!-- end of user preview component -->
            </div>
            <?php if (!empty($desc)) { ?>
            <p class="card-text text-center"><?php echo $desc; ?></p>
            <?php } ?>
        </div>
    </div>
</div>