<?php 
global $user_id;

if (!$user_id) {
    $user_id = get_current_user_id();
}
$cur_user_url = get_author_posts_url( $user_id );

?>


<div class="user-content-tabs">
    <div class="list-group">
        <a class="btn" id="list-posts" href="<?php echo $cur_user_url; ?>#posts" data-p="<?php echo mo_crypt($user_id, 'e'); ?>" role="tab" aria-controls="home" ><i class="icon-posts"></i>المنشورات</a>
        
        <a class="btn" id="list-bookmarks" href="<?php echo $cur_user_url; ?>#bookmarked" data-p="<?php echo mo_crypt($user_id, 'e'); ?>" role="tab" aria-controls="bookmarks" ><i class="icon-bookmark"></i>المحفظة</a>

        <a class="btn" id="list-moawzi-groups"  href="<?php echo $cur_user_url; ?>#groups" data-p="<?php echo mo_crypt($user_id, 'e'); ?>" role="tab" aria-controls="groups" ><i class="icon-icon-users"></i>المجموعات</a>
    </div>
</div>