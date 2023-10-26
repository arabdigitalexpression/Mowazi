<?php
global $post_id;
global $user_id;
global $sidebar_posts_post_id;
global $sidebar_bookmarks_post_id;

$main_post_id = $post_id;

$post_type = get_post_type( $post_id );


$all_posts_tab = get_posts( array(
    'post_type'         =>  array( 'articles', 'activities', 'workshops', 'games', 'stories' ),
    'post_status'       =>  'publish',
    'posts_per_page'    =>  -1,
    'post_parent'       =>  0,
    'post__not_in'      =>  array( $post_id ),
    'author'            =>  $user_id,
    'fields'            =>  'ids'
) );

$user_bookmarks = get_user_meta( $user_id, 'user_bookmarks', true );
$user_bookmarks_arr = array();

if ( !empty($user_bookmarks) ) {
    $user_bookmarks_arr = explode( ',', $user_bookmarks );
}

$post_age_range = get_post_meta( $post_id, 'mo_workshop_activity_age', true );

$post_duration_hrs = get_post_meta( $post_id, 'mo_workshop_activity_duration_hrs', true );
$post_duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );

$post_participants = get_post_meta( $post_id, 'mo_workshop_activity_participants', true );
$post_max_participants = get_post_meta( $post_id, 'mo_workshop_activity_max_participants', true );

$post_location = get_post_meta( $post_id, 'mo_workshop_location', true );
$post_goals = get_post_meta( $post_id, 'mo_workshop_goals', true );
$post_revisions = wp_get_post_revisions( $main_post_id );
$post_collaborators = get_post_meta( $main_post_id, 'mo_workshop_collaborators', true );
$post_attachments = get_post_meta( $main_post_id, 'mo_post_attachments', true );
$post_attachment_links = get_post_meta( $main_post_id, 'mo_post_attachment_group', true );
$post_material = get_post_meta($main_post_id, 'mo_workshop_material_group', true);
$post_comments = get_comments( array(
    'post_id'       =>  $main_post_id,
    'status'        =>  'approve',
    'hierarchical'  =>  'threaded'
) );

$post_activities = get_post_meta($post_id ,'activities', true);
$post_activities_titles = array();
foreach ($post_activities as $act_id){
    $post_activity_title = get_post($act_id) -> post_title;
    $post_activity_url = get_permalink($act_id);
    array_push($post_activities_titles, array($post_activity_url, $post_activity_title));
}
// echo $post_activity_titles;
?>
<div class="sidebar-sticky sidebar-sticky-left">
    <div class="left-side_info">
        <div class="tab-content more-info">
            <div class="tab-pane active show" id="infoSidebar" aria-labelledby="info-sidebar" role="tabpanel">
                <p class="tab-header">المعلومات</p>
                <?php if ( !empty( $post_goals ) ) { ?>
                    <div class="block-content_side">
                        <h2>الأهداف</h2>
                        <?php echo wpautop( $post_goals ); ?>
                    </div>
                <?php } ?>
                <?php //print_r($post_activity_titles); ?>
               <?php if ( !empty( $post_activities_titles ) ) { ?>
                    <div class="block-content_side">
                        <h2>الانشطة</h2>
                        <?php foreach($post_activities_titles as $activity_title):?>
                            <a target="_blank" href="<?php echo $activity_title[0]; ?>"><?php echo wpautop($activity_title[1])?></a>
                        <?php endforeach;?>
                    </div>
                <?php } ?>
                
                <?php if ( !empty( $post_location ) ) { ?>
                    <div class="block-content_side">
                        <h2>المكان</h2>
                        <?php echo wpautop( $post_location ); ?>
                    </div>
                <?php } 
                if ( !empty( $post_participants ) && !empty( $post_max_participants ) ) { ?>
                    <div class="block-content_side participants-content">
                        <h2>عدد المشاركين  <i class="icon-edit" data-edit-post='participants'></i></h2>
                        <div>
                             <i class="icon-icon-users"></i>
                            <span id="maxParticipants"><?php echo wpautop( $post_max_participants ); ?></span>
                            -
                            <span id="minParticipants"><?php echo wpautop( $post_participants ); ?></span>
                        </div>
                        <form method='post' action>
                            <div class="form-group" data-post-info='participants'>
                                <div class="form-group_post">
                                    <select style="width: 100%;" name="participants" data-placeholder="الحد الأدنى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        <option></option>
                                        <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                     <select style="width: 100%;" name="maxParticipants" data-placeholder="الحد الأقصى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        <option></option>
                                        <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        var url = window.location.href;
                                        url = url.replace("?c=edit", "");
                                        jQuery('.left-side_info select[name="participants"]').on('change',function(){
                                            jQuery.ajax({
                                                type: "POST",
                                                data: { ajax1: 1, minParticipants: this.value }
                                            }).done(function( msg ) { 
                                                jQuery('.participants-content #minParticipants').text(this.value);
                                                jQuery('[data-post-info="participants"]').fadeOut();
                                                var php = "<?php if( isset($_POST['ajax1']) && isset($_POST['minParticipants']) ){
                                                        $min = $_POST['minParticipants'];
                                                        update_post_meta($post_id, 'mo_workshop_activity_participants', $min);
                                                        exit;
                                                    } ?>";
                                                setTimeout(function(){ location.reload(); }, 1000);
                                            });
                                            
                                            
                                        });
                                        jQuery('.left-side_info select[name="maxParticipants"]').on('change',function(){
                                            jQuery.ajax({
                                                type: "POST",
                                                data: { ajax2: 1, maxParticipants: this.value }
                                            }).done(function( msg ) { 
                                                jQuery('.participants-content #maxParticipants').text(this.value);
                                                jQuery('[data-post-info="participants"]').fadeOut();
                                                var php = "<?php if( isset($_POST['ajax2']) && isset($_POST['maxParticipants']) ){
                                                        $max = $_POST['maxParticipants'];
                                                        update_post_meta($post_id, 'mo_workshop_activity_max_participants', $max);
                                                        exit;
                                                    } ?>"
                                                setTimeout(function(){ location.reload(); }, 1000);
                                            });
                                            
                                            
                                        });
                                    </script>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                <?php }
                if ( !empty( $post_age_range ) ) { ?>
                    <div class="block-content_side age_range-content">
                        <h2>السن  <i class="icon-edit" data-edit-post='age_range'></i></h2>
                        <div>
                            <i class="icon-icon-group"></i>
                            <?php echo wpautop( $post_age_range ); ?>
                        </div>
                        <form>
                            <div class="form-group" data-post-info='age_range'>
                                <div class="form-group_post">
                                   <select style="width: 100%;" name="age" data-placeholder="السن" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        <option></option>
                                        <?php foreach ( mo_generate_age_range() as $key => $value ) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        jQuery('.left-side_info select[name="age"]').on('change',function(){
                                            jQuery.ajax({
                                                type: "POST",
                                                data: { ajax: 2, age: this.value }
                                            }).done(function( msg ) { 
                                                jQuery('.age_range-content p').text(this.value);
                                                jQuery('[data-post-info="age_range"]').fadeOut();
                                                var php = "<?php if( isset($_POST['ajax']) && isset($_POST['age']) ){
                                                        $age = $_POST['age'];
                                                        update_post_meta($post_id, 'mo_workshop_activity_age', $age);
                                                        exit;
                                                    } ?>";
                                                setTimeout(function(){ location.reload(); }, 1000);
                                            });
                                            
                                        });
                                    </script>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                <?php }
                if ( !empty( $post_duration ) || !empty( $post_duration_hrs ) ) { ?>
                    <div class="block-content_side duration-content">
                        <h2>التوقيت <i class="icon-edit" data-edit-post='duration'></i></h2>
                        <div>
                            <i class="icon-icon-clock"></i>
                            <?php echo wpautop( $post_duration_hrs ) .'ساعة '. wpautop( $post_duration ).'دقيقة '; ?>
                        </div>
                         <form method='post' action>
                            <div class="form-group" data-post-info='duration'>
                                <div class="form-group_post">
                                   <select style="width: 100%;" name="durationHrs" data-placeholder="ساعة" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        <option></option>
                                        <?php foreach ( mo_generate_duration_range_hrs() as $key => $value ) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                     <select style="width: 100%;" name="durationMin" data-placeholder="دقائق" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        <option></option>
                                        <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        jQuery('.left-side_info select[name="durationHrs"]').on('change',function(){
                                            jQuery.ajax({
                                                type: "POST",
                                                data: { ajax3: 1, durationHrs: this.value }
                                            }).done(function( msg ) { 
                                                //jQuery('.duration-content p').text(this.value);
                                                jQuery('[data-post-info="duration"]').fadeOut();
                                                var php ="<?php if( isset($_POST['ajax3']) && isset($_POST['durationHrs']) ){
                                                        $durationHrs = $_POST['durationHrs'];
                                                        update_post_meta($post_id, 'mo_workshop_activity_duration_hrs', $durationHrs);
                                                        exit;
                                                    } ?>"
                                                setTimeout(function(){ location.reload(); }, 1000);
                                            });
                                            
                                        });
                                        jQuery('.left-side_info select[name="durationMin"]').on('change',function(){
                                            jQuery.ajax({
                                                type: "POST",
                                                data: { ajax4: 1, durationMin: this.value }
                                            }).done(function( msg ) { 
                                                //jQuery('.duration-content p').text(this.value);
                                                jQuery('[data-post-info="duration"]').fadeOut();
                                                var php ="<?php if( isset($_POST['ajax4']) && isset($_POST['durationMin']) ){
                                                        $durationMin = $_POST['durationMin'];
                                                        update_post_meta($post_id, 'mo_workshop_activity_duration', $durationMin);
                                                        exit;
                                                    } ?>"
                                                setTimeout(function(){ location.reload(); }, 1000);
                                            });
                                            
                                        });
                                    </script>
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
            <!--  postsSidebar -->
            <div class="tab-pane" id="postsSidebar" aria-labelledby="posts-sidebar" role="tabpanel">
                <p class="tab-header">المنشورات</p>
                <div class="container-wrapper <?php if ( $post_type == 'workshops' ) { echo 'drag-option'; } ?>">
                    
                    <?php
                    if ( !empty( $all_posts_tab ) ) {
                        foreach ($all_posts_tab as $sidebar_posts_post_id) {
                            $post_tab_type = get_post_type( $sidebar_posts_post_id );
                    ?>
                    <div class="mz-mb-35 <?php if ( $post_tab_type !== 'activities' ) { echo 'nodrag'; } ?>">
                        <?php get_template_part('templates/content-card_author'); ?>
                    </div>
                    <?php } } ?>
                    
                </div>

            </div>
            <!--  searchSidebar -->
            <div class="tab-pane" id="searchSidebar" aria-labelledby="search-sidebar" role="tabpanel">
                <p class="tab-header">البحث</p>
                <div class="form-group search-side">
                    <input type="search" class="form-control" name="searcSide" aria-describedby="helpId" placeholder="البحث عن انشطة" data-callback="getSearchSide">
                </div>
                <div id="search_side_result" class="container-wrapper <?php if ( $post_type == 'workshops' ) { echo 'drag-option'; } ?>"></div>
            </div>
            <!--  notesSidebar -->
            <!--<div class="tab-pane" id="notesSidebar" aria-labelledby="notes-sidebar" role="tabpanel">
                <p class="tab-header">الملحوظات</p>
                <div class="container-wrapper" id="notesArea">
                    <div class="workshop-textarea-wrapper">
                        <form data-bv-live="disabled">
                            <div class="form-group">
                                <textarea class="form-control workshop-textarea" name="sidebarNotes" placeholder="ملحوطة جديدة" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                <a href="#" class="workshop-textarea_options">
                                    <i class="icon-dots"></i>
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">اضف</button>
                        </form>
                    </div>
                    <div class="workshop-textarea-wrapper" >
                        <div class="workshop-textarea purble-color">
                            <div id="notesOne" class="collapse show" aria-labelledby="notesOne" data-parent="#notesArea">
                                <p >- يتم تخطيط الأرض بالطباشير على هيئة مستطيل و يقسم اٍلى أربعة قطع أو أجزاء متساوية و كل جزء يتقسم اٍلى جزئيين الا الجزء الأخير لا ينقسم و يسمى بالمسبح. و هكذا تتكون 6 من المربعات او البيوت و رقم 7 هو المسبح..</p>
                            </div>
                        </div>
                        <a href="#" class="workshop-textarea_options">
                            <i class="icon-dots"></i>
                        </a>
                        <a href="#" class="workshop-textarea_options"data-toggle="collapse" data-target="#notesOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="icon-arrow-down-alt"></i>
                        </a>
                    </div>
                    <div class="workshop-textarea-wrapper">
                        <div class="workshop-textarea trkuaz-color">
                            <div id="notestwo" class="collapse show" aria-labelledby="notestwo" data-parent="#notesArea">
                                <p >- يتم تخطيط الأرض بالطباشير على هيئة مستطيل و يقسم اٍلى أربعة قطع أو أجزاء متساوية و كل جزء يتقسم اٍلى جزئيين الا الجزء الأخير لا ينقسم و يسمى بالمسبح. و هكذا تتكون 6 من المربعات او البيوت و رقم 7 هو المسبح..</p>
                            </div>
                        </div>
                        <a href="#" class="workshop-textarea_options">
                            <i class="icon-dots"></i>
                        </a>
                        <a href="#" class="workshop-textarea_options"data-toggle="collapse" data-target="#notestwo" aria-expanded="true" aria-controls="notestwo">
                            <i class="icon-arrow-down-alt"></i>
                        </a>
                    </div>
                    
                </div>
            </div> -->
            <!-- commentsSidebar -->
            <div class="tab-pane" id="commentsSidebar" aria-labelledby="comments-sidebar" role="tabpanel">
                <p class="tab-header">التعليقات</p>
                <div class="container-wrapper">
                    <div class="workshop-textarea-wrapper">
                        <form id="formSideComment_<?php echo $main_post_id; ?>" data-bv-live="disabled" data-bv-onsuccess="addComment" data-post="<?php echo $main_post_id; ?>" class="side-comment">
                            <div class="form-group">
                                <textarea class="form-control workshop-textarea" placeholder="تعليق عام" name="comment" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                <a href="#" class="workshop-textarea_options">
                                    <i class="icon-dots"></i>
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">ارسل</button>
                        </form>
                    </div>
                
                <?php if ( !empty( $post_comments ) ) { 
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
                            $comment_author_avatar = wp_get_attachment_image_url( get_user_meta( $post_comment->user_id, 'user_img_id', 1 ), 'avatar-xs' );
                    ?>
                    <div class="workshop-comment-wrapper">
                        <div class="workshop-collebrators">
                            <!-- info preview component -->
                            <a href="<?php echo $comment_author_url; ?>" class="info-preview get-profile" data-p="<?php echo mo_crypt($post_comment->user_id, 'e'); ?>" title="<?php echo $comment_author_name; ?>">
                                <!-- avatar component -->
                                <div class="avatar avatar-xs" <?php if ($comment_author_avatar) { echo 'data-avatar="' . $comment_author_avatar . '"'; } ?>></div>
                                <!-- end of avatar component -->
                                <div class="info info-sm">
                                    <h4 class="info-title"><?php echo $comment_author_name; ?></h4>
                                    <p class="info-subtitle"><?php echo $post_comment->comment_date; ?></p>
                                </div>
                                <!-- end of user preview component -->
                            </a>
                            <!-- <a href="#" class="workshop-textarea_options">
                                <i class="icon-dots"></i>
                            </a> -->
                        </div>
                        <div class="comment-view">
                            <p><?php echo $post_comment->comment_content; ?></p>
                            <form id="formSideComment_<?php echo $post_comment_id; ?>" data-bv-live="disabled" data-bv-onsuccess="addComment" data-post="<?php echo $main_post_id; ?>" data-parent="<?php echo $post_comment_id; ?>" class="side-comment">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="comment" placeholder="أكتب تعليق…" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                </div>
                                <button type="submit" class="btn btn-secondary m-3">ارسل</button>
                            </form>
                        </div>
                    </div>

                        <?php
                        if( !empty( $comment_replies ) ) {
                            foreach ($comment_replies as $comment_reply_id => $comment_reply) {
                                $reply_author = get_user_by( 'id', $comment_reply->user_id );

                                if ( $reply_author ) {
                                    $reply_author_name = $reply_author->first_name . ' ' . $reply_author->last_name;
                                    $reply_author_url = get_author_posts_url( $comment_reply->user_id );
                                    $reply_author_avatar = wp_get_attachment_image_url( get_user_meta( $comment_reply->user_id, 'user_img_id', 1 ), 'avatar-xs' );
                        ?>
                                <div class="workshop-comment-wrapper workshop-reply-wrapper">
                                    <div class="workshop-collebrators">
                                        <!-- info preview component -->
                                        <a href="<?php echo $reply_author_url; ?>" class="info-preview get-profile" data-p="<?php echo mo_crypt($comment_reply->user_id, 'e'); ?>" title="<?php echo $reply_author_name; ?>">
                                            <!-- avatar component -->
                                            <div class="avatar avatar-xs" <?php if ($reply_author_avatar) { echo 'data-avatar="' . $reply_author_avatar . '"'; } ?>></div>
                                            <!-- end of avatar component -->
                                            <div class="info info-sm">
                                                <h4 class="info-title"><?php echo $reply_author_name; ?></h4>
                                                <p class="info-subtitle"><?php echo $comment_reply->comment_date; ?></p>
                                            </div>
                                            <!-- end of user preview component -->
                                        </a>
                                        <!-- <a href="#" class="workshop-textarea_options">
                                            <i class="icon-dots"></i>
                                        </a> -->
                                    </div>
                                    <div class="comment-view">
                                        <p><?php echo $comment_reply->comment_content; ?></p>
                                    </div>
                                </div>
                        <?php } } } ?>
                    
                    <?php } } ?>
                  
                <?php } ?>
                </div>
            </div>
            <!-- attachesSidebar -->
            <div class="tab-pane" id="attachesSidebar" aria-labelledby="sources-sidebar" role="tabpanel">
                <p class="tab-header">المرفقات</p>
                <div class="container-wrapper">
                    <form id="addAttach">
                        <div id="pc" data-post="<?php echo $main_post_id; ?>">
                            <div class="wrapper">
                                <div>
                                    <i class="icon-cloud-upload"></i>
                                    <p>ارفع من الحاسوب</p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="wrapper-file-added">
                            <div class="file-added">
                                <p class="exe">pdf</p>
                                <div>
                                    <p>اسم الملف…</p>
                                    <span>20kb</span>
                                </div>
                            </div>
                            <div>
                                <a href="#" class="btn btn-secondary"> <i class="icon-upload"></i> <span>رفع</span> </a>
                                <a href="#" class="btn btn-close"> <i class="icon-close"></i> <span>الغاء</span> </a>
                            </div>
                        </div> -->
                    </form>
                    <div id="attach_list">
                        <h6 class="subHtab"> قائمة المرفقات</h6>
                        <?php
                        if ( !empty($post_attachments) ) {
                            foreach ( $post_attachments as $post_attachment_id => $post_attachments_url ) {
                                $post_attachment_name = $post_attachment_type = $post_attachment_size = '';

                                $post_attachment_name = get_the_title( $post_attachment_id );
                                $post_attachment_type = get_post_mime_type($post_attachment_id);
                                $post_attachment_size = round(filesize( get_attached_file( $post_attachment_id ) ) / 1024);
                        ?>

                        <a href="<?php echo $post_attachments_url; ?>" class="file-added uploaded" download>
                            <p class="exe"><?php echo $post_attachment_type; ?></p>
                            <div>
                                <div>
                                    <p><?php echo $post_attachment_name; ?></p>
                                    <span><?php echo $post_attachment_size; ?>kb</span>
                                </div>
                                <!-- <a href="#" class="workshop-textarea_options">
                                    <i class="icon-dots"></i>
                                </a> -->
                            </div>
                        </a>

                        <?php
                            }
                        }
                        ?>
                        <?php
                        if ( !empty($post_attachment_links) ) {
                            foreach ( $post_attachment_links as $link ) { ?>

                        <a href="<?php echo $link['link']; ?>" class="file-added uploaded">
                            <p class="exe">Links</p>
                            <div>
                                <div>
                                    <p>Link</p>
                                    <span>1kb</span>
                                </div>
                            </div>
                        </a>

                        <?php
                            }
                        }
                        ?>
                       
                        <?php 
                        /*if( isset($_POST['ajax']) && isset($_POST['attachLink']) && isset($_POST['attachName'])){
                            $links = array();
                            $link = $_POST['attachLink'];
                            $name = $_POST['attachName'];

                            if ( !is_array( $post_attachment_links ) ) {
                                $post_attachment_links = array();
                            }
                            $links['link'] = $link;
                            
                            $post_attachment_links[]=$links;

                            //update_post_meta($post_id, 'mo_post_attachment_group', $post_attachment_links);
                            exit;
                        }*/ ?>
                    </div>
                </div>
            </div>
            <!-- collaboratorSidebar -->
            <div class="tab-pane" id="collaboratorSidebar" aria-labelledby="collaborator-sidebar" role="tabpanel"> 
                <p class="tab-header">المشاركة</p>
                <!-- workshop-collebrators -->
                <div class="container-wrapper">
                    <form action="">
                        <div class="form-group form-group-icon">
                            <input type="text" class="form-control copy-clipboard" readonly name="documentLink" value="<?php echo get_permalink( $main_post_id ); ?>" data-toggle="tooltip" title="تم نسخ الرابط" data-trigger="click" data-placement="top" data-delay="500" >
                                <i class="icon-clipboard"></i>
                        </div>
                        <div class="form-group form-group-icon">
                            <!-- <input type="email" class="form-control" name="shareDocument" placeholder="البريد الإلكتروني" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-bv-emailaddress-message="هذا الحقل لا يمكن ان يكون فارغا"> 
                             <i class="icon-share-mail"></i> -->
                            <select id="collaboratorsList" style="width:100%;" name="collaborators" class="form-control bg-white" multiple="multiple" data-placeholder="إدراج أسماء أو عناوين البريد الإلكتروني">
                                <?php if ( !empty( $post_collaborators ) ) {
                                    foreach ($post_collaborators as $collaborator) {
                                        $collaborator_first_name = get_user_meta( $collaborator, 'first_name', true );
                                        $collaborator_last_name = get_user_meta( $collaborator, 'last_name', true );
                                        $collaborator_fullname = $collaborator_first_name . ' ' . $collaborator_last_name;
                                        $collaborator_profile_avatar = wp_get_attachment_image_url( get_user_meta( $collaborator, 'user_img_id', 1 ), 'avatar-xxs' );

                                        if ( !$collaborator_profile_avatar ) {
                                            $collaborator_profile_avatar = get_template_directory_uri() . '/images/logo-sm.svg';
                                        } ?>
                                        <option value="<?php echo $collaborator; ?>" data-name="<?php echo $collaborator_fullname; ?>" data-url="<?php echo $collaborator_profile_avatar; ?>" selected><?php echo $collaborator_fullname?></option>
                                    <?php } 
                                } /*else{*/
                                    //$collaborators = mo_generate_users();
                                    $collaborators = get_users( array(
                                        'role'  =>  'facilitator',
                                        'exclude' => $post_collaborators,
                                    ) );

                                    if ( !empty( $collaborators ) ) {
                                        foreach ($collaborators as $collaborator) {
                                            $collaborator_first_name = get_user_meta( $collaborator->ID, 'first_name', true );
                                            $collaborator_last_name = get_user_meta( $collaborator->ID, 'last_name', true );
                                            $collaborator_fullname = $collaborator_first_name . ' ' . $collaborator_last_name;
                                            $collaborator_profile_avatar = wp_get_attachment_image_url( get_user_meta( $collaborator->ID, 'user_img_id', 1 ), 'avatar-xxs' );
                                            //$collaborator_email = get_userdata($collaborator->ID)->user_email;

                                            if ( !$collaborator_profile_avatar ) {
                                                $collaborator_profile_avatar = get_template_directory_uri() . '/images/logo-sm.svg';
                                            } ?>
                                            <option value="<?php echo $collaborator->ID; ?>" data-name="<?php echo $collaborator_fullname; ?>" data-url="<?php echo $collaborator_profile_avatar; ?>"><?php echo $collaborator_fullname; ?>
                                            </option>
                                        <?php } 
                                    }
                                /*}*/ ?>
                            </select>
                            <i class="icon-icon-users"></i>


                        </div>
                        <a href="#" add-collaborators class="btn btn-secondary"> <i class="icon-plus"></i> <span>ارسل</span> </a>
                        <a href="#" class="btn btn-close"> <i class="icon-close"></i> <span>الغاء</span> </a>
                        <script type="text/javascript">
                            var url = window.location.href;
                            url = url.replace("?c=edit", "");
                            jQuery('a[add-collaborators]').on('click',function(){
                                var collaborators = jQuery('select#collaboratorsList').val();
                                console.log(collaborators);
                                jQuery.ajax({
                                    type: "POST",
                                    data: { ajaxColl: 1, collaborators: collaborators }
                                }).done(function( msg ) { 
                                    var php = "<?php if( isset($_POST['ajaxColl']) && isset($_POST['collaborators']) ){
                                        $collaborators = $_POST['collaborators'];
                                        update_post_meta($main_post_id, 'mo_workshop_collaborators', $collaborators);
                                        if ( !empty( $collaborators ) ) {
                                            foreach ( $collaborators as $new_collaborator_id ) {
                                                mo_send_notification( $new_collaborator_id, $user_id, $main_post_id, 'تم دعوتك للمشاركة في محتوى' );
                                            }
                                        }
                                        exit;
                                    } ?>";
                                });
                                setTimeout(function(){ location.reload(); }, 1000);
                                
                            });
                        </script>
                    </form>

                    <?php if ( !empty( $post_collaborators ) ) { ?>
                    <div class="workshop-collebrators_wrapper">
                        <h6 class="subHtab">قائمة المشاركين</h6>
                        <?php
                        foreach ( $post_collaborators as $post_collaborator_id ) {
                            $post_collaborator_revision = wp_get_post_revisions( $main_post_id, array( 'posts_per_page'  =>  1, 'author' =>  $post_collaborator_id ) );
                            // var_dump($post_collaborator_revision);
                            // echo '</br>';

                            if ( $post_collaborator_revision && !empty( $post_collaborator_revision ) ) {
                                foreach ( $post_collaborator_revision as $collaborator_revision ) {
                                    $collaborator_revision_date_gmt = $collaborator_revision->post_modified_gmt;
                                    $collaborator_revision_time = time_elapsed_string( $collaborator_revision_date_gmt );
                                    $collaborator_revision_author_first_name = get_user_meta( $post_collaborator_id, 'first_name', true );
                                    $collaborator_revision_author_last_name = get_user_meta( $post_collaborator_id, 'last_name', true );
                                    $collaborator_revision_author_fullname = $collaborator_revision_author_first_name . ' ' . $collaborator_revision_author_last_name;
                                    $collaborator_revision_author_avatar = wp_get_attachment_image_url( get_user_meta( $post_collaborator_id, 'user_img_id', 1 ), 'avatar-xl' );
                                    $collaborator_revision_author_profile_url = get_author_posts_url( $post_collaborator_id );
                            
                        ?>
                            <div class="workshop-collebrators">
                                <!-- info preview component -->
                                <a href="<?php echo $collaborator_revision_author_profile_url; ?>" class="info-preview get-profile" data-p="<?php echo mo_crypt($post_collaborator_id, 'e'); ?>">
                                    <!-- avatar component -->
                                    <div class="avatar avatar-xs" <?php if ( !empty( $collaborator_revision_author_avatar ) ) { echo 'data-avatar="' . $collaborator_revision_author_avatar . '"'; }?>></div>
                                    <!-- end of avatar component -->
                                    <div class="info info-sm">
                                        <h4 class="info-title"><?php echo $collaborator_revision_author_fullname; ?></h4>
                                        <p class="info-subtitle"><?php echo $collaborator_revision_time; ?></p>
                                    </div>
                                    <!-- end of user preview component -->
                                </a>
                                <!-- <a href="#" class="workshop-textarea_options">
                                    <i class="icon-dots"></i>
                                </a> -->
                            </div>
                        <?php } } } ?>
                    </div>
                    <?php } ?>

                </div>
                
            </div>
            <!-- bookmarkSidebar -->
            <div class="tab-pane" id="bookmarkSidebar" aria-labelledby="bookmark-sidebar" role="tabpanel">
                <p class="tab-header">المحفظة</p>
                <div class="container-wrapper <?php if ( $post_type == 'workshops' ) { echo 'drag-option'; } ?>">
                    
                    <?php
                    if ( !empty($user_bookmarks_arr) ) {
                        foreach ($user_bookmarks_arr as $sidebar_bookmarks_post_id) {
                            if ( !empty($sidebar_bookmarks_post_id) ) {
                                $post_bookmarked_type = get_post_type( $sidebar_bookmarks_post_id );
                    ?>
                    <div class="mz-mb-35 <?php if ( $post_bookmarked_type !== 'activities' ) { echo 'nodrag'; } ?>">
                        <?php get_template_part('templates/content-card'); ?>
                    </div>
                    <?php } } } ?>

                </div>

            </div>
            <!-- materialSidebar -->
            <div class="tab-pane" id="materialSidebar" aria-labelledby="material-sidebar" role="tabpanel">
                <p class="tab-header">خامات</p>
                <form id="formMaterial" data-bv-onsuccess="addMaterial" class="p-4" data-post="<?php echo $main_post_id; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="البند" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" />
                    </div>
                    <div class="form-group">
                        <!-- <input type="text" class="form-control" name="number" placeholder="العدد" data-bv-digits="true" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-bv-digits-message="هذا الحقل يحتوي على ارقام فقط" /> -->
                        <input id="materialQty" type="text" class="form-control" name="number" placeholder="العدد"  data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block text-right"><i class="icon-plus ml-2"></i>أضف</button>
                </form>
                <?php if ( !empty( $post_material ) ) { ?>
                <div class="table-responsive p-4">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">البند</th>
                                <th scope="col">العدد</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ( $post_material as $material_entry ) {
                            $title = $number = ' ';

                            if ( isset( $material_entry['title'] ) ) {
                                $title = esc_html( $material_entry['title'] );
                            }

                            if ( isset( $material_entry['number'] ) ) {
                                $number = esc_html( $material_entry['number'] );
                            }
                        ?>
                        <tr>
                            <td>
                                <a href="#" 
                                    data-material="<?php echo array_search( $material_entry, $post_material )?>" 
                                    data-post="<?php echo $main_post_id; ?>"
                                    class="remove-material"  
                                >
                                    <i 
                                    data-material="<?php echo array_search( $material_entry, $post_material )?>"
                                    data-post="<?php echo $main_post_id; ?>"
                                    class="icon-delete"></i>
                                </a>
                            </td>
                        <td>
                            <?php echo $title; ?>
                        </td>
                            <td>
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <!-- <a href="#" class="incMin">
                                    <i class="icon-plus"></i>
                                </a> -->
                                <?php echo $number; ?>
                                <!-- <a href="#" class="decMin">
                                    <i class="icon-minus"></i>
                                </a> -->
                            </div>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
            <!-- historySidebar -->
            <div class="tab-pane" id="historySidebar" aria-labelledby="history-sidebar" role="tabpanel">
                <p class="tab-header">التاريخ</p>

                <?php if ( !empty( $post_revisions ) ) { ?>
                <div class="container-wrapper">
                    <?php
                    foreach ( $post_revisions as $post_revision ) {
                        // check if post title empty to get around the update post revision hack check $post_record_revision @mo_publish_post in mo-functions.php
                        if ( !empty( $post_revision->post_title ) ) {
                            $post_revision_author_id = $post_revision->post_author;
                            $post_revision_date_gmt = get_the_modified_date('F j, Y g:i a', $post_revision->ID);
                            $post_revision_author_first_name = get_user_meta( $post_revision_author_id, 'first_name', true );
                            $post_revision_author_last_name = get_user_meta( $post_revision_author_id, 'last_name', true );
                            $post_revision_author_fullname = $post_revision_author_first_name . ' ' . $post_revision_author_last_name;
                    ?>
                            <div class="editing-history">
                                <p><?php echo $post_revision_date_gmt; ?></p>
                                <small><?php echo $post_revision_author_fullname; ?></small>
                            </div>
                    <?php } } ?>

                </div>
                <?php } ?>
            </div>
            
        </div>
    </div>

    <div class="list-group left-side-icons">
        <a href="#infoSidebar" class="btn mo-icon-sidebar active" data-toggle="tab">
            <i class="icon-help"></i>
        </a>
        <a href="#postsSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-burger"></i>
            <span>المنشورات</span>
        </a>
        <a href="#searchSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-icon-search"></i>
            <span>البحث</span>
        </a>
        <!-- <a href="#notesSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-notes"></i>
            <span>الملحوظات</span>
        </a> -->
        <a href="#commentsSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-comment"></i>
            <span>تعليقات</span>
        </a>
        <a href="#attachesSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-attach-alt"></i>
            <span>المرفقات</span>
        </a>
        <a href="#collaboratorSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-icon-users"></i>
            <span>المشاركة</span>
        </a>
        <a href="#bookmarkSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-bookmark"></i>
            <span>المحفظة</span>
        </a>
        <a href="#materialSidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-material"></i>
            <span>خامات</span>
        </a>
        <a href="#historySidebar" class="btn mo-icon-sidebar" data-toggle="tab">
            <i class="icon-history"></i>
            <span>التاريخ</span>
        </a>
    </div>
</div>