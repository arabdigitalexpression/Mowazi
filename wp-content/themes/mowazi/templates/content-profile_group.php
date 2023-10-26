<?php
global $group_id;
global $post_id;
global $user_id;
global $profile_id;

if ( !$group_id ) {
    $group_id = $wp_query->get_queried_object()->ID;
}

if (!$user_id) {
    $user_id = get_current_user_id();
}

$group_desc = get_post($group_id);
$desc = $group_desc->post_content;
$group_author = get_post_field ('post_author', $group_id);
$group_admins = get_post_meta( $group_id, 'mo_group_admins', true );
$group_members = get_post_meta( $group_id, 'mo_group_members', true );
$admins = array();
$members = array();

foreach ($group_admins as $admin) {
    if ( isset( $admin['user_id'] ) && !in_array( $admin['user_id'], $admins ) ) {
        $admins[] = $admin['user_id'];
    }
}

foreach ($group_members as $member) {
    if ( isset( $member['user_id'] ) && !in_array( $member['user_id'], $members ) ) {
        $members[] = $member['user_id'];
    }
}

$group_posts = get_post_meta( $group_id, 'mo_group_posts', true );

// var_dump($group_posts);
?>
<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="content-wrapper">
                    <div class="section-wrapper group-profile">

                            <div class="content-section_header tabs" id="list-tab" role="tablist">
                                <div class="list-group">
                                    <a class="btn view-tab active show" id="list-posts" data-toggle="tab" href="#posts" role="tab" aria-controls="home" ><i class="icon-posts"></i>المنشورات</a>
                                    <a class="btn view-tab" data-toggle="tab" id="list-moawzi-groups" href="#groups" role="tab" aria-controls="groups" ><i class="icon-icon-users"></i>الأعضاء</a>
                                    <?php if ( $user_id == $group_author || in_array( $user_id, $admins ) ) { ?>
                                    <a  class="btn view-tab" data-toggle="tab" id="list-settings" href="#settings" role="tab" aria-controls="settings"><i class="icon-cog"></i>الاعدادات</a>
                                    <?php } ?>
                                    <!-- back button -->
                                    <a href="#" id="backToView"  class="btn view-tab active"><i class="icon-arrow-right"></i>العودة</a>
                                </div>
                                <div> 
                                    <!-- buttons for save settings -->
                                    <a class="btn view-tab btn-primary update-group d-none"><i class="icon-save"></i>حفظ</a>       
                                    <!-- <a href="#" class="btn btn-white edit-setting ">
                                        <div><i class="icon-edit"></i><span>تعديل</span></div>
                                        <div class="d-none"><i class="icon-close"></i><span>الغاء</span></div>
                                    </a>   -->
                                </div>
                            </div>

                            <div class="tab-content">
                                <!-- posts -->
                                <div class="tab-pane fade active show" id="posts" aria-labelledby="list-posts" role="tabpanel">
                                    <div class="row">
                                        <?php
                                        if ( !empty( $group_posts ) ) {
                                            foreach ($group_posts as $group_post) {
                                               $post_id = $group_post['post_id'];
                                            
                                        ?>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php
                                            if ( in_array( $user_id, $admins ) || in_array( $user_id, $members ) ) {
                                                $profile_id = $user_id;
                                                get_template_part('templates/content-card_author');
                                            } else {
                                                get_template_part('templates/content-card_new');
                                            }
                                            ?>
                                        </div>
                                        <?php } } else { ?>
                                        <div class="empty-content text-center">
                                            <p>لا يوجد محتوى. هل تريد نشر محتوي؟</p>
                                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#NewPost">محتوي جديد</a>
                                        </div>
                                        <?php } ?>
                                        <!-- <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <div class="card card-folder">
                                                <a href="#" class="stretched-link card-folder-link"></a>
                                                <div class="card-body">
                                                    
                                                    <h5 class="card-title"><i class="icon-file"></i> البطة و بيت الغول</h5>
                                                    <p class="card-text">كان يا مكان كان في تلات بنات اخوات، </p>
                                                    
                                                </div>
                                            </div>
                                        </div> -->

                                    </div>
                                </div>

                                <!-- members -->
                                <div class="tab-pane" id="groups" role="tabpanel" aria-labelledby="list-groups">
                                    <div class="row">
                                        <?php
                                        if ( !empty( $group_members ) ) {
                                            foreach ($group_members as $member) {
                                                $profile_id = $member['user_id'];
                                        ?>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php get_template_part('templates/content-card_member'); ?>
                                        </div>
                                        <?php } } ?>

                                        <?php
                                        if ( !empty( $group_admins ) ) {
                                            foreach ($group_admins as $admin) {
                                                if(!in_array($admin,$group_members)){
                                                $profile_id = $admin['user_id'];
                                        ?>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php get_template_part('templates/content-card_member'); ?>
                                        </div>
                                        <?php }} 
                                        } ?>
                                    </div>
                                </div>

                                <?php if ( $user_id == $group_author || in_array( $user_id, $admins ) ) { ?>
                                <!-- settings -->
                                <div class="tab-pane" id="settings" aria-labelledby="list-settings" role="tabpanel">
                                    <form id="formUpdateGroup" data-bv-onsuccess="updateGroup" data-g="<?php echo $group_id; ?>">
                                        <div class="form-group form-group_alt form-group_settings">
                                            <label for="title">عنوان المجموعة</label>
                                            <input type="text" name="title" value="<?php echo get_the_title( $group_id ); ?>" class="form-control" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        </div>

                                        <div class="form-group form-group_settings form-group_alt">
                                            <label for="desc">وصف المجموعة</label>
                                            <textarea class="form-control" name="desc" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"><?php echo $desc; ?></textarea>
                                        </div>
                                        
                                        <div class="form-group form-group_settings form-group_alt form-group-member">
                                            <label for="members">قائمة الأعضاء</label>
                                            <select style="width:100%;" name="members" class="form-control bg-white" multiple="multiple" data-placeholder="إدراج أسماء أو عناوين البريد الإلكتروني">
                                                <?php
                                                if ( !empty( $group_members ) ) {
                                                    foreach ($group_members as $member) {
                                                        $member_id = $member_name = $member_avatar = '';

                                                        if ( isset( $member['name'] ) ) {
                                                            $member_name = $member['name'];
                                                        }

                                                        if ( isset( $member['user_id'] ) ) {
                                                            $member_id = $member['user_id'];
                                                            $member_avatar = wp_get_attachment_image_url( get_user_meta( $member_id, 'user_img_id', 1 ), 'avatar-xs' );

                                                            if ( !$member_avatar ) {
                                                                $member_avatar = get_template_directory_uri() . '/images/logo-sm.svg';
                                                            }
                                                        }

                                                    
                                                ?>
                                                <option value="<?php echo $member_id; ?>" data-name="<?php echo $member_name; ?>" data-url="<?php echo $member_avatar; ?>" selected></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <i class="icon-icon-users"></i>
                                        </div>

                                        <div class="group-member_wrapper">
                                            <?php
                                            if ( !empty( $group_members ) ) {
                                                foreach ($group_members as $member) {
                                                    $member_id = $member_name = $member_profile_url = $member_avatar = '';

                                                    if ( isset( $member['name'] ) ) {
                                                        $member_name = $member['name'];
                                                    }

                                                    if ( isset( $member['profile_url'] ) ) {
                                                        $member_profile_url = $member['profile_url'];
                                                    }

                                                    if ( isset( $member['user_id'] ) ) {
                                                        $member_id = $member['user_id'];
                                                        $member_avatar = wp_get_attachment_image_url( get_user_meta( $member_id, 'user_img_id', 1 ), 'avatar-xs' );
                                                    }
                                                
                                            ?>
                                            <div class="group-member">
                                                <a href="<?php echo $member_profile_url; ?>" class="info-preview get-profile" data-p="<?php echo mo_crypt($member_id, 'e'); ?>">
                                                    <div class="avatar avatar-xs" <?php if ($member_avatar) { echo 'data-avatar="' . $member_avatar . '"'; } ?>></div>
                                                    <h6><?php echo $member_name; ?></h6>
                                                </a>
                                                <?php if ( count( $group_members ) > 1 ) { ?>
                                                <a href="#" class="mo-icon-circle delete-member" data-id="<?php echo $member_id; ?>">
                                                    <i class="icon-trash"></i>
                                                </a>
                                                <?php } ?>
                                            </div>
                                            <?php } } ?>
                                        </div>

                                        <div class="form-group form-group_settings form-group_alt form-group-member">
                                            <label for="admins">قائمة المسؤولين</label>
                                            <select style="width:100%;" name="admins" class="form-control bg-white" multiple="multiple" data-placeholder="اختر من قائمة الأعضاء الخاصة بك">
                                                <?php
                                                if ( !empty( $group_admins ) ) {
                                                    foreach ($group_admins as $admin) {
                                                        $admin_id = $admin_name = $admin_avatar = '';

                                                        if ( isset( $admin['name'] ) ) {
                                                            $admin_name = $admin['name'];
                                                        }

                                                        if ( isset( $admin['user_id'] ) ) {
                                                            $admin_id = $admin['user_id'];
                                                            $admin_avatar = wp_get_attachment_image_url( get_user_meta( $admin_id, 'user_img_id', 1 ), 'avatar-xs' );

                                                            if ( !$admin_avatar ) {
                                                                $admin_avatar = get_template_directory_uri() . '/images/logo-sm.svg';
                                                            }
                                                        }

                                                    
                                                ?>
                                                <option value="<?php echo $admin_id; ?>" data-name="<?php echo $admin_name; ?>" data-url="<?php echo $admin_avatar; ?>" selected></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <i class="icon-admin"></i>
                                        </div>

                                        <div class="group-member_wrapper">
                                            <?php
                                            if ( !empty( $group_admins ) ) {
                                                foreach ($group_admins as $admin) {
                                                    $admin_id = $admin_name = $admin_profile_url = $admin_avatar = '';

                                                    if ( isset( $admin['name'] ) ) {
                                                        $admin_name = $admin['name'];
                                                    }

                                                    if ( isset( $admin['profile_url'] ) ) {
                                                        $admin_profile_url = $admin['profile_url'];
                                                    }

                                                    if ( isset( $admin['user_id'] ) ) {
                                                        $admin_id = $admin['user_id'];
                                                        $admin_avatar = wp_get_attachment_image_url( get_user_meta( $admin_id, 'user_img_id', 1 ), 'avatar-xs' );
                                                    }
                                                
                                            ?>
                                            <div class="group-member group-admin">
                                                <a href="<?php echo $admin_profile_url; ?>" class="info-preview get-profile" data-p="<?php echo mo_crypt($admin_id, 'e'); ?>">
                                                    <div class="avatar avatar-xs" <?php if ($admin_avatar) { echo 'data-avatar="' . $admin_avatar . '"'; } ?>></div>
                                                    <h6><?php echo $admin_name; ?></h6>
                                                </a>
                                                <div>
                                                    <span class="mo-icon-circle">
                                                        <i class="icon-admin"></i>
                                                    </span>

                                                    <?php if ( count( $group_admins ) > 1 ) { ?>
                                                    <a href="#" class="mo-icon-circle delete-member" data-id="<?php echo $admin_id; ?>">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                            <?php } } ?>
                                        </div>

                                    </form>
                                </div>
                                <?php } ?>

                                <!-- <div class="inside-folder">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php //get_template_part('templates/content-card'); ?>
                                        </div>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php //get_template_part('templates/content-card'); ?>
                                        </div>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php //get_template_part('templates/content-card'); ?>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                </div>
            </div>  

            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-profile_group'); ?>
            </div>

        </div>
    </div>
</section>

<?php
// if user is admin or memeber in group include delete modal
if ( in_array( $user_id, $admins ) || in_array( $user_id, $members ) ) {
    get_template_part('modals/modal-remove_post');
}
?>
