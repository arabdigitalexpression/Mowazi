<?php
global $profile_id;
global $user_id;
global $post_id;
global $group_id;

if (!$profile_id) {
    $profile_id = get_queried_object()->ID;
}

if (!$user_id) {
    $user_id = get_current_user_id();
}

if ( $profile_id == $user_id ) {
    $query_status = 'any';
} else {
    $query_status = 'publish';
}

$posts_args = array(
    'post_type'         =>  array( 'articles', 'activities', 'stories', 'games', 'workshops' ),
    'post_status'       =>  $query_status,
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

$profile_posts = get_posts( $posts_args );

$user_groups = get_user_meta( $profile_id, 'user_groups', true );
$user_bookmarks = get_user_meta( $profile_id, 'user_bookmarks', true );
$user_bookmarks_arr = array();

if ( !empty($user_bookmarks) ) {
    $user_bookmarks_arr = explode( ',', $user_bookmarks );
}

$first_name = get_user_meta( $profile_id, 'first_name', true );
$last_name = get_user_meta( $profile_id, 'last_name', true );
$fullname = $first_name . ' ' . $last_name;
$user_bdate = get_user_meta( $profile_id, 'user_bdate', true );
$user_bio = get_user_meta( $profile_id, 'description', true );
$profile_user = get_user_by( 'id', $profile_id );
$user_email = $profile_user->user_email;
?>
<section class="content-section profilePage">
    <div class="container">
        <div class="row profilePage-body">
            <div class="col-md-9">
                <div class="content-wrapper">
                    <div class="section-wrapper">

                            <!-- tabs navigation -->
                            <div class="content-section_header tabs" id="list-tab" role="tablist">
                                <div class="list-group">
                                    <a class="btn view-tab active show" id="list-posts" data-toggle="tab" href="#posts" role="tab" aria-controls="home" ><i class="icon-posts"></i>المنشورات</a>
                                    <?php if ( $profile_id == $user_id ) { // profile owner ?>
                                    <a class="btn view-tab" data-toggle="tab" id="list-bookmarks" href="#bookmarked" role="tab" aria-controls="bookmarks" ><i class="icon-bookmark"></i>المحفظة</a>
                                    <?php } ?>
                                    <a class="btn view-tab" data-toggle="tab" id="list-moawzi-groups" href="#groups" role="tab" aria-controls="groups" ><i class="icon-icon-users"></i>المجموعات</a>
                                    <?php if ( $profile_id == $user_id ) { // profile owner ?>
                                    <a  class="btn view-tab" data-toggle="tab" id="list-settings" href="#settings" role="tab" aria-controls="settings"><i class="icon-cog"></i>الاعدادات</a>
                                    <?php } ?>
                                </div>
                                <?php if ( $profile_id == $user_id ) { // profile owner ?>
                                <div>
                                    <!-- buttons for save settings & create group -->
                                    <a href="#" class="btn view-tab btn-primary d-none <?php if ( empty($user_groups) ) { echo 'd-none'; } ?>" data-toggle="modal" data-target="#newGroup"><i class="icon-icon-users"></i> مجموعة جديدة</a>
                                </div>
                                <?php } ?>
                            </div>
                            <!-- tabs navigation -->
    
                            <div class="tab-content">
                                <!-- posts tab -->
                                <div class="tab-pane fade active show" id="posts" aria-labelledby="list-posts" role="tabpanel">
                                    <?php
                                    //if current user is profile owner reorder the posts to show draft posts on top
                                    if ( $profile_id == $user_id ) {
                                        $profile_posts = mo_reorder_posts_private_first($profile_posts);
                                    }

                                    if ( !empty($profile_posts) ) {
                                    ?>

                                    <div class="row">
                                        <?php foreach ($profile_posts as $key => $post_id) {
                                            $post_status = get_post_status($post_id);
                                        ?>
                                        <div class="<?php if ($post_status && $post_status == 'private') { echo 'col-md-12'; } else { echo 'col-md-6 col-xl-4'; } ?> mz-mb-35">
                                                <?php get_template_part('templates/content-card_author'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <?php } else { // empty posts ?>
                                    <div class="empty-content text-center">
                                    <?php if ( $profile_id == $user_id ) { // profile owner ?>
                                        <p>لا يوجد محتوى. هل تريد نشر محتوي؟</p>
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#NewPost">محتوي جديد</a>
                                    <?php } else { // visitor ?>
                                        <p>لا يوجد محتوى. هل تريد تصفح محتوى اخر؟</p>
                                        <a href="<?php echo get_site_url(); ?>" class="btn btn-primary">الصفحة الرئيسية</a>
                                    <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!-- end posts tab -->

                                <?php if ( $profile_id == $user_id ) { // profile owner ?>
                                <!-- bookmarks tab -->
                                <div class="tab-pane" id="bookmarked" role="tabpanel" aria-labelledby="list-bookmarks">
                                    <?php if ( !empty($user_bookmarks_arr) ) { ?>

                                    <div class="row">
                                        <?php
                                        foreach ($user_bookmarks_arr as $post_id) {
                                            if ( !empty($post_id) ) {
                                        ?>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php //get_template_part('templates/content-card'); ?>
                                            <?php get_template_part('templates/content-card_new'); ?>
                                        </div>
                                        <?php } } ?>
                                    </div>

                                    <?php } else { ?>
                                    <div class="empty-content text-center">
                                        <p>ليس لديك أي إشارات مرجعية حتى الآن. هل تريد تصفح المحتوى؟</p>
                                        <a href="<?php echo get_site_url(); ?>" class="btn btn-primary">الصفحة الرئيسية</a>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!-- end bookmarks tab -->
                                <?php } ?>

                                <!-- groups tab -->
                                <div class="tab-pane" id="groups" role="tabpanel" aria-labelledby="list-moawzi-groups">
                                    <?php if ( !empty($user_groups) ) { ?>
                                    <div class="row">
                                        <?php foreach ($user_groups as $group_id) { ?>
                                        <div class="col-md-6 col-xl-4 mz-mb-35">
                                            <?php get_template_part('templates/content-card-group'); ?>
                                        </div>
                                        <?php } ?>
                                    </div>  
                                    <?php } else { ?>
                                    <!-- if there's no groups -->
                                    <div class="empty-content text-center">
                                        <p>ليست مشترك في أي مجموعة حتى الآن. هل تريد إنشاء مجموعة؟</p>
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#newGroup">مجموعة جديدة</a>
                                    </div>
                                    <?php } ?>             
                                </div>
                                <!-- end groups tab -->

                                <?php if ( $profile_id == $user_id ) { // profile owner ?>
                                <!-- settings tab -->
                                <div class="tab-pane" id="settings" aria-labelledby="list-settings" role="tabpanel">
                                    <div class="view-content_container">
                                        <div>
                                            <p>المعلومات الشخصية</p>
                                            <div>
                                                <a href="#" class="btn btn-secondary save-settings d-none">
                                                    <div> <i class="icon-save"></i><span>حفظ</span></div>
                                                    
                                                </a> 
                                                <a href="#" class="btn btn-white edit-setting">
                                                    <div><i class="icon-edit"></i><span>تعديل</span></div>
                                                <div class="d-none"><i class="icon-close"></i><span>الغاء</span></div>
                                                </a> 
                                            </div>
                                        </div>
                                        <form id="formUpdateUser" data-bv-onsuccess="updateUser">
                                            <div class="form-group form-group_setting">
                                                <label for="fullname">الاسم</label>
                                                <input type="text" name="fullname" id="fullname" disabled="disabled" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"  class="form-control" value="<?php echo $fullname; ?>">
                                            </div>
                                            <div class="form-group form-group_setting">
                                                <label for="email">البريد الإلكتروني</label>
                                                <input type="email" name="email" id="email" disabled="disabled" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"  class="form-control" value="<?php echo $user_email; ?>">
                                            </div>
                                            <div class="form-group form-group_setting">
                                                <label for="bdate">تاريخ الميلاد</label>
                                                <input type="text" name="bdate" id="bdate" disabled="disabled" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" class="form-control" value="<?php echo $user_bdate; ?>">
                                            </div>
                                            <div class="change-pass_link">
                                                <p>كلمة المرور</p>
                                                <a href="#changePass" class="text-secondary" data-toggle="modal" role="button">تغير كلمة المرور</a>
                                                <!-- <div class="collapse" id="changePass">
                                                </div> -->
                                                
                                            </div>
                                            <div class="form-group form-group_setting textarea_desc">
                                                <label for="desc">التعريف الشخصي</label>
                                                <textarea name="desc" disabled="disabled" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" class="form-control"><?php echo $user_bio; ?></textarea>
                                            </div>
                                        </form>
                                        <!-- <p>ليس لديك أي إشارات مرجعية حتى الآن. هل تريد تصفح المحتوى؟</p>
                                        <a href="<?php //echo get_site_url() . '?l=1'; ?>" class="btn btn-primary">الصفحة الرئيسية</a> -->
                                    </div>
                                </div>
                                <!-- settings tab -->
                                <?php } ?>

                            </div>
                            <!-- end tab content -->
                            
                        </div>
                </div>
            </div>
            <!-- sidebar -->
            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-profile_user'); ?>
            </div>
            <!-- sidebar -->
        </div>
    </div>
</section>
<?php
// if profile owner include remove modal & new group modal
if ( $profile_id == $user_id ) {
    get_template_part('modals/modal-remove_post');
    get_template_part('modals/modal-new_group');
    get_template_part('modals/modal-change_pass');     
}
?>
