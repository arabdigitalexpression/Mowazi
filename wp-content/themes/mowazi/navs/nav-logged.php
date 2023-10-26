<?php
global $user_id;

if (!$user_id) {
    $user_id = get_current_user_id();
}

$cur_user_avatar = wp_get_attachment_image_url( get_user_meta( $user_id, 'user_img_id', 1 ), 'avatar-default' );
$cur_user_url = get_author_posts_url( $user_id );

$notifications = get_user_meta( $user_id, 'mo_notification_group', true );
?>
<!-- header  -->
<header class="main-header">
    <div class="container-fluid">
        <div class="header-wrapper">
            <a href="<?php echo get_site_url(); ?>" class="logo" title="Mowazi"><img src="<?php echo get_template_directory_uri() . '/images/logo-new.png';?>" alt="mowazi logo"></a>
            
            <!-- archives -->
            <?php get_template_part('navs/nav-archive'); ?>
            
            <!-- search form -->
            <?php get_template_part('templates/content-search_form'); ?>
            <!-- end search form -->
            
            <div class="d-flex align-items-center">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#NewPost">محتوي جديد</a>
               <!--  <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#NewPost">عن موازي</a> -->
                <div class="dropdown">
                    <span class="arrow-menu-top"></span>
                    <a href="#" class="btn notifications-bell" role="button" id="dropdownMenuNotifi" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-bell"></i>
                        <?php if($notification != ''){
                            foreach ($notifications as $notification) {
                               $notification_status = $notification_url = $notification_text = $notification_from_id = $notification_post_id = $notification_fullname = '';

                               if ( isset( $notification['read'] ) ) {
                                   $notification_status = $notification['read'];
                               } ?>
                                <i class="icon-Notifi-Badge <?php if (!empty($notification_status)) {
                                    echo 'd-none';
                                }  ?>"></i>
                            <?php } 
                          }?>
                        <!-- <i class="icon-Notifi-Badge"></i> -->
                    </a>
                    <div class="dropdown-menu dropdown-sm" aria-labelledby="dropdownMenuNotifi">
                        <h6 class="dropdown-header">إشعارات</h6>
                        <?php
                        if ( !empty($notifications) ) {
                        ?>
                        <div class="dropdown-notifitctions">
                            <?php
                            foreach ($notifications as $notification) {
                               $notification_status = $notification_url = $notification_text = $notification_from_id = $notification_post_id = $notification_fullname = '';

                               if ( isset( $notification['read'] ) ) {
                                   $notification_status = $notification['read'];
                               }

                               if ( isset( $notification['url'] ) ) {
                                   $notification_url = $notification['url'];
                               }

                               if ( isset( $notification['desc'] ) ) {
                                   $notification_text = $notification['desc'];
                               }

                               if ( isset( $notification['from_id'] ) ) {
                                   $notification_from_id = $notification['from_id'];

                                   $notification_first_name = get_user_meta( $notification_from_id, 'first_name', true );
                                   $notification_last_name = get_user_meta( $notification_from_id, 'last_name', true );
                                   $notification_fullname = $notification_first_name . ' ' . $notification_last_name;

                               }

                               if ( isset( $notification['post_id'] ) ) {
                                   $notification_post_id = $notification['post_id'];
                               }
                            
                            ?>
                            <a class="dropdown-item <?php if ( !empty($notification_status) ) { echo 'seen '; } if ( !empty($notification_post_id) ) { echo 'get-post'; } ?>" href="<?php if ( !empty($notification_url) ) {  echo $notification_url; } else { echo '#'; } ?>" <?php if ( !empty($notification_post_id) ) { echo 'data-id="' . $notification_post_id . '" data-c="view"'; } ?>>
                                <div class="info-preview">
                                    <!-- avatar component -->
                                    <!-- <div class="avatar avatar-lg" data-avatar="http://localhost:3000/mowazi/wp-content/themes/mowazi/images/avatar-test.svg"></div> -->
                                    <!-- end of avatar component -->
                                    <div class="info info-sm">
                                        <?php if ( !empty($notification_fullname) ) { ?>
                                        <h4 class="info-title"><?php echo $notification_fullname; ?></h4>
                                        <?php } ?>

                                        <?php if ( !empty($notification_text) ) { ?>
                                        <p class="info-subtitle"><?php echo $notification_text; ?></p>
                                        <?php } ?>

                                    </div>
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                        <a href="#"  title="تصنيف الكل كمقروء" class="dropdown-footer read-all">تصنيف الكل ك "مقروء"</a>
                        <?php } else { ?>
                            <p class="no-noti">لا يوجد إشعارات جديدة</p>
                        <?php } ?>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="<?php echo $cur_user_url; ?>" class="avatar"  <?php if ($cur_user_avatar) { echo 'data-avatar="' . $cur_user_avatar . '"'; } ?> id="dropdownMenuAvatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <span class="arrow-menu-top"></span>
                    <div class="dropdown-menu dropdown-sm " aria-labelledby="dropdownMenuAvatar">
                        <a class="dropdown-item get-profile" href="<?php echo $cur_user_url; ?>" title="صفحتي الشخصية" data-p="<?php echo mo_crypt($user_id, 'e'); ?>">صفحتي الشخصية</a>
                        <a class="dropdown-item logout" href="#">تسجيل خروج</a>
                    </div>
                </div>
 
            </div>
        </div>
    </div>
</header>
<!-- end of header  -->
<!-- Modal New Post -->
<?php get_template_part('modals/modal-new_post'); ?>
<!-- End Modal New Post -->