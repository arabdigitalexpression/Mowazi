<?php
global $group_id;

$group_title = get_the_title( $group_id );

$group_avatar = get_the_post_thumbnail_url( $group_id, 'avatar-md' );
$group_url = get_permalink( $group_id );

$members_count = 0;
$group_admins = get_post_meta( $group_id, 'mo_group_admins', true );
$group_members = get_post_meta( $group_id, 'mo_group_members', true );

$group_members_display = array();

if ( !empty( $group_admins ) && is_array( $group_admins ) ) {
    $members_count += count( $group_admins );
    $group_members_display[] = $group_admins[0];
}

if ( !empty( $group_members ) && is_array( $group_members ) ) {
    $members_count += count( $group_members );
    $group_members_count = 0;

    foreach ($group_members as $group_member) {
        $group_members_count++;

        if ( $group_members_count < 3 ) {
            $group_members_display[] = $group_member;
        }
    }
}
?>
<!-- <div class="card mo-card-group">
    <div class="card-header">
        <a href="<?php echo $group_url; ?>" class="info-preview get-profile" title="<?php if (!empty($group_title)) { echo $group_title; } ?>" data-p="<?php echo mo_crypt($group_id, 'e'); ?>">
           
            <div class="avatar avatar-md bg-secondary" <?php if ($group_avatar) { echo 'data-avatar="' . $group_avatar . '"'; } ?>></div>
           
            <div class="info info-sm">
                <?php if (!empty($group_title)) { ?>
                <h4 class="info-title"><?php echo $group_title; ?></h4>
                <?php } ?>
                <?php if ( $members_count !== 0 ) { ?>
                <p class="info-subtitle"><?php echo $members_count; ?> عضو في المجموعة</p>
                <?php } ?>
            </div>
           
        </a>
    </div>

    <div class="card-body">
        <?php
        if ( !empty( $group_members_display ) ) {
            foreach ($group_members_display as $member) {
                $member_url = $member_name = $member_avatar = '';

                $member_url = $member['profile_url'];
                $member_name = $member['name'];
                $member_avatar = wp_get_attachment_image_url( get_user_meta( $member['user_id'], 'user_img_id', 1 ), 'avatar-sm' );
        ?>
        <a href="<?php echo $member_url ?>" class="info-preview get-profile" title="<?php echo $member_name; ?>" data-p="<?php echo mo_crypt($member['user_id'], 'e'); ?>">
            
            <div class="avatar avatar-sm" <?php if ($member_avatar) { echo 'data-avatar="' . $member_avatar . '"'; } ?>></div>
           
            <div  class="info info-sm">
                <h4 class="info-title"><?php echo $member_name; ?></h4>
            </div>
            
        </a>
        <?php } } ?>
    </div>

    <?php if ( $members_count > 3 ) { ?>
    <a href="<?php echo $group_url; ?>" class="card-footer get-profile" data-p="<?php echo mo_crypt($group_id, 'e'); ?>">
        <h6>عرض الكل (<?php echo $members_count; ?>)</h6>
    </a>
    <?php } ?>
</div> -->


<div class="card card-mo-group">
        <div class="group-info">
            <a href="<?php echo $group_url; ?>" class="info-preview get-profile" title="<?php if (!empty($group_title)) { echo $group_title; } ?>" data-p="<?php echo mo_crypt($group_id, 'e'); ?>">
                <!-- avatar component -->
                <div class="avatar avatar-sm bg-secondary" <?php if ($group_avatar) { echo 'data-avatar="' . $group_avatar . '"'; } ?>>
                </div>
                <!-- end of avatar component -->
                <div class="info info-sm group-title">
                    <?php if (!empty($group_title)) { ?>
                    <h4 class="info-title"><?php echo $group_title; ?></h4>
                    <?php } ?>
                </div>
                <div class="members-count">
                <?php if ( $members_count !== 0 ) { ?>
                    <p class="info-subtitle"><?php echo $members_count; ?> عضو في المجموعة</p>
                    <?php } ?>
                </div>
                <!-- end of user preview component -->
            </a>
        </div>
        <div class="group-members">
            <?php
            if ( !empty( $group_members_display ) ) {
                foreach ($group_members_display as $member) {
                    $member_url = $member_name = $member_avatar = '';

                    $member_url = $member['profile_url'];
                    $member_name = $member['name'];
                    $member_avatar = wp_get_attachment_image_url( get_user_meta( $member['user_id'], 'user_img_id', 1 ), 'avatar-sm' );
            ?>
            <div 
            href="<?php // echo $member_url ?>" 
            class="info-preview get-profile" title="<?php echo $member_name; ?>" data-p="<?php echo mo_crypt($member['user_id'], 'e'); ?>">
                <!-- avatar component -->
                <div class="avatar avatar-sm" <?php if ($member_avatar) { echo 'data-avatar="' . $member_avatar . '"'; } ?>></div>
                <!-- end of avatar component -->
                <!-- <div  class="info info-sm">
                    <h4 class="info-title"><?php echo $member_name; ?></h4>
                </div> -->
                <!-- end of user preview component -->
            </div>
            <?php } } ?>
        </div>
</div>