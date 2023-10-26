<?php
global $profile_id;

$first_name = get_user_meta( $profile_id, 'first_name', true );
$last_name = get_user_meta( $profile_id, 'last_name', true );
$fullname = $first_name . ' ' . $last_name;

$profile_avatar = wp_get_attachment_image_url( get_user_meta( $profile_id, 'user_img_id', 1 ), 'avatar-xl' );
$profile_url = get_author_posts_url( $profile_id );
$profile_url = str_replace(" ","-",$profile_url);

$profile_bio = get_user_meta( $profile_id, 'description', true );




$user_posts_args = array(
    'post_type'         =>  array( 'articles', 'activities', 'stories', 'games', 'workshops' ),
    'post_status'       =>  'publish',
    'author'            =>  $profile_id,
    'nopaging'          =>  true,
    'posts_per_page'    =>  -1,
    'post_parent'       =>  0,
    'fields'            =>  'ids',
    'meta_query' => array(
        'relation'  =>  'OR',
        array(
            'key'     => 'mo_workshop_shared_with',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key'       => 'mo_workshop_shared_with',
            'value'     => 'all',
            'compare'   => '=',
        ),
    ),
);
$profile_posts = get_posts( $user_posts_args );
$user_posts_count = count($profile_posts);
$user_groups = get_user_meta( $profile_id, 'user_groups', true );

?>
<!-- <div class="card card-member">
    <div class="card-header">
           
        <div class="info-preview">
           
            <div class="avatar avatar-sm" <?php if ($profile_avatar) { echo 'data-avatar="' . $profile_avatar . '"'; } ?>></div>
           
            <div class="info info-sm">
                <h4 class="info-title"><?php echo $fullname; ?></h4>
            </div>
           
        </div>
    </div>
    <div class="card-body">
        <p class="card-text"><?php echo $profile_bio; ?></p>
    </div>
    <div class="card-footer">
        <a href="<?php echo $profile_url; ?>" class="stretched-link get-profile" data-p="<?php echo mo_crypt($profile_id, 'e'); ?>">عرض الملف الشخصي</a>
    </div>
</div> -->

<a class="card card-member get-profile " href="<?php echo $profile_url; ?>" data-p="<?php echo mo_crypt($profile_id, 'e'); ?>">
    <div class="member-preview">
            <!-- avatar component -->
            <div class="avatar avatar-sm" <?php if ($profile_avatar) { echo 'data-avatar="' . $profile_avatar . '"'; } ?>></div>
            <!-- end of avatar component -->
            <div class="info info-sm">
                <?php if($profile_bio):?>
                    <p class="info-bio"><?php echo $profile_bio; ?></p>
                <?php endif;?>
                <h4 class="info-title"><?php echo $fullname; ?></h4>
            </div>
            <!-- end of user preview component -->
    </div>
    <div class="member-info">
        <div class="member-posts info-item">
            <h4>المنشورات</h4>
            <p><?php echo $user_posts_count; ?></p>
        </div>
        <div class="member-groups info-item">
            <h4>المجموعات</h4>
            <p><?php if($user_groups){ echo count($user_groups);} else echo "0";?></p>
        </div>
    </div>
</a>