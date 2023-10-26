<?php
global $post_id;
global $user_id;

if (!$user_id) {
    $user_id = get_current_user_id();
}

$cur_user_avatar = wp_get_attachment_image_url( get_user_meta( $user_id, 'user_img_id', 1 ), 'avatar-xs' );

$post_comments = get_comments( array(
    'post_id'       =>  $post_id,
    'status'        =>  'approve',
    'hierarchical'  =>  'threaded'
) );

// var_dump($post_comments);

?>
<div class="view-content__comments_container">
    <!-- comment header -->
    <div class="comments-header">
        <div>
            <i class="icon-comment"></i>
            <span>التعليقات</span>
        </div>
        <div>
            <span>المزيد</span>
            <i class="icon-arrow-down">

            </i>
        </div>
    </div>

    <div class="comments-container">
        <!-- write your comment -->
        <form id="formComment_<?php echo $post_id; ?>" data-bv-live="disabled" data-bv-onsuccess="addComment" data-post="<?php echo $post_id; ?>" class="form-comment">
            <div class="form-group form-group_comment">
                <div class="avatar avatar-xs" <?php if ($cur_user_avatar) { echo 'data-avatar="' . $cur_user_avatar . '"'; } ?>></div>
                <textarea name="comment" class="form-control" placeholder="أكتب تعليق…" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
            </div>
            <button type="submit" class="btn btn-blue2 btn-sm">انشر</button>
        </form>


        <?php
        if ( !empty( $post_comments ) ) {
            foreach ($post_comments as $post_comment_id => $post_comment) {
                $comment_replies = get_comments( array(
                                        'status'        =>  'approve',
                                        'parent'        => $post_comment_id,
                                        'hierarchical'  =>  'threaded'
                                    ) );

                $comment_author = get_user_by( 'id', $post_comment->user_id );

                // if user exist
                if ($comment_author) {
                    $comment_author_name = $comment_author->first_name . ' ' . $comment_author->last_name;
                    $comment_author_url = get_author_posts_url( $post_comment->user_id );
                    $comment_author_avatar = wp_get_attachment_image_url( get_user_meta( $post_comment->user_id, 'user_img_id', 1 ), 'avatar-xs' ); ?>
                    <!-- start of comment componenet -->
                    <div class="card card-comment">
                        <!-- start of info preview component -->
                        <div class="comment-details_wrapper" data-u="<?php echo $post_comment->user_id; ?>">
                            <!-- avatar component -->
                            <a href="<?php echo $comment_author_url; ?>" class="info-preview" title="<?php echo $comment_author_name; ?>" >
                                <div class="avatar avatar-xs" <?php if ($comment_author_avatar) { echo 'data-avatar="' . $comment_author_avatar . '"'; } ?>></div>
                                <!-- end of avatar component -->
                                <div class="info info-sm info-text-sm">
                                    <h4 class="info-title"><?php echo $comment_author_name; ?></h4>
                                </div>
                            </a>
                            <div class="comment-time">
                                <i class="icon-clock-fill"></i>
                                <span><?php echo $post_comment->comment_date; ?></span>
                            </div>
                        </div>
                        <!-- end of info preview component -->
                        <div class="card-body">
                            <p><?php echo $post_comment->comment_content; ?></p>
                            <textarea class="commentTextarea"><?php echo $post_comment->comment_content; ?></textarea>
                            <?php if($user_id == $post_comment->user_id){ ?>
                                <div class="edit-comment" data-click='edit' data-id="<?php echo $post_comment_id; ?>"><i class="icon-edit"></i></div>
                                <div class="delete-comment" data-id="<?php echo $post_comment_id; ?>"><i class="icon-delete"></i></div>
                            <?php } ?>
                        </div>

                        <?php
                        if( !empty( $comment_replies ) ) {
                            foreach ($comment_replies as $comment_reply_id => $comment_reply) {
                                $reply_author = get_user_by( 'id', $comment_reply->user_id );

                                // if reply user exist
                                if ( $reply_author ) {
                                    $reply_author_name = $reply_author->first_name . ' ' . $reply_author->last_name;
                                    $reply_author_url = get_author_posts_url( $comment_reply->user_id );
                                    $reply_author_avatar = wp_get_attachment_image_url( get_user_meta( $comment_reply->user_id, 'user_img_id', 1 ), 'avatar-xs' ); ?>
                                    <!-- comment reply -->
                                    <div class="card card-comment card-comment_reply">
                                        <!-- start of info preview component -->
                                        <div class="comment-details_wrapper">
                                            <!-- avatar component -->
                                            <a href="<?php echo $reply_author_url; ?>" class="info-preview get-profile" title="<?php echo $reply_author_name; ?>" data-u="<?php echo $comment_reply->user_id; ?>">
                                                <div class="avatar avatar-sm" <?php if ($reply_author_avatar) { echo 'data-avatar="' . $reply_author_avatar . '"'; } ?>></div>
                                                <!-- end of avatar component -->
                                                <div class="info info-sm info-text-sm">
                                                    <h4 class="info-title"><?php echo $reply_author_name; ?></h4>
                                                </div>
                                            </a>
                                            <div class="comment-time">
                                                <i class="icon-clock-fill"></i>
                                                <span><?php echo $comment_reply->comment_date; ?></span>
                                            </div>
                                        </div>
                                        <!-- end of info preview component -->
                                        <div class="card-body">
                                            <p><?php echo $comment_reply->comment_content; ?></p>
                                            <textarea class="commentTextarea"><?php echo $comment_reply->comment_content; ?></textarea>
                                            <?php if($user_id == $comment_reply->user_id){ ?>
                                                <div class="edit-comment" data-click='edit' data-id="<?php echo $comment_reply_id; ?>"><i class="icon-edit"></i></div>
                                                <div class="delete-comment" data-id="<?php echo $comment_reply_id; ?>"><i class="icon-delete"></i></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- end of comment reply -->
                            <?php } // end if reply user exist ?>
                        <?php } } ?>
                        <!-- replay for existing comment -->
                        <form id="formComment_<?php echo $post_comment_id; ?>" data-bv-live="disabled" data-bv-onsuccess="addComment" data-post="<?php echo $post_id; ?>" data-parent="<?php echo $post_comment_id; ?>" class="form-reply-comment">
                            <div class="form-group form-group_comment">
                                <div class="avatar avatar-xs" <?php if ($cur_user_avatar) { echo 'data-avatar="' . $cur_user_avatar . '"'; } ?>></div>
                                <textarea name="comment" class="form-control" placeholder="أكتب تعليق…" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                            </div>
                            <button type="submit" class="btn btn-blue2 btn-sm">انشر</button>

                        </form>
                    <!-- end of comment componenet -->
            <?php } // end if user exist ?>
                    </div>
        <?php } } ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.edit-comment').on('click',function(){
            var status = jQuery(this).data('click');
            if(status == 'edit'){
                jQuery(this).siblings('.commentTextarea').css('visibility','visible');
                jQuery(this).data('click','save');
            }else{
                var newComment = jQuery(this).siblings('.commentTextarea').val();
                var commentId = jQuery(this).data('id');
                jQuery(this).siblings('p').html(newComment);
                jQuery(this).siblings('.commentTextarea').css('visibility','hidden');
                jQuery(this).data('click','edit');
                jQuery.ajax({
                    type: "POST",
                    data: { ajaxEdit: 1, commentId: commentId,  newComment:  newComment}
                }).done(function( msg ) { 
                });
                var php = "<?php if(isset($_POST['ajaxEdit'])){
                    $commentID = $_POST['commentId'];
                    $newComment = $_POST['newComment'];
                    $commentarr = array();
                    $commentarr['comment_ID'] = $commentID;
                    $commentarr['comment_content'] = $newComment;
                    $update_success = wp_update_comment($commentarr);
                    exit;
                } ?>";
            }

        });
        jQuery('.delete-comment').on('click',function(){
            var commentId = jQuery(this).data('id');
            jQuery.ajax({
                type: "POST",
                data: { ajaxDelete: 1, commentId: commentId}
            }).done(function( msg ) { 
            });
            var php = "<?php if(isset($_POST['ajaxDelete'])){
                $commentID = $_POST['commentId'];
                $update_success = wp_delete_comment($commentID);
                exit;
            } ?>";
            setTimeout(function(){ location.reload(); }, 1000);
            

        });
    });
</script>