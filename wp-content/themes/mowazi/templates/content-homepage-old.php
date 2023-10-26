<?php
global $post_id;
$user_id = get_current_user_id();
?>
<section class="content-section homepage-loggedin">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="content-wrapper">
                   <!-- <div class="introDesc">
                        <p>لوريم إيبسوم هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر</p>
                        <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#NewPost">أضف محتوى جديد</a>
                    </div> -->
                    <?php
                    // bookmarked posts
                    $user_bookmarks = get_user_meta( $user_id, 'user_bookmarks', true );
                    $user_bookmarks_arr = array();

                    if ( !empty($user_bookmarks) ) {
                        $user_bookmarks_arr = explode( ',', $user_bookmarks );
                    }

                    if ( !empty($user_bookmarks_arr) ) {
                        $bookmarks_count = 0;
                    ?>
                    <div class="section-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <h2>العلامات التي أتابعها</h2>
                            <?php
                            $load_more_link = apply_filters( 'load_more_link', '<a href="#" class="btn bg-white content-section_btn" data-load>عرض الكل</a>', 'bookmarks', false, false, false, $user_id, 3 );

                            if ( !empty($load_more_link) ) {
                                echo $load_more_link;
                            }
                            ?>
                        </div>
                        <div class="row">
                            <?php
                            foreach ($user_bookmarks_arr as $post_id) {
                                $bookmarks_count++;

                                if ($bookmarks_count > 4) {
                                    break;
                                }
                                
                                if ( !empty($post_id) ) {
                            ?>
                                <div class="col-md-6 col-xl-4 mz-mb-35">
                                    <?php get_template_part('templates/content-card'); ?>

                            </div>
                            <?php } } ?>
                        </div>
                    </div>
                    <?php } ?>

                    <?php
                    // featured posts
                    $featured_posts = get_posts( array(
                        'post_type'         =>  array( 'articles', 'activities', 'stories', 'games', 'workshops' ),
                        'post_status'       =>  'publish',
                        'posts_per_page'    =>  3,
                        'post_parent'       =>  0,
                        'fields'            =>  'ids',
                        'post__not_in'      =>  $user_bookmarks_arr,
                        
                        'meta_key' => '_is_ns_featured_post', 
                        'meta_value' => 'yes' 
                    ) );

                    if (!empty($featured_posts)) {
                    ?>
                    <div class="section-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <h2>محتوى متميز</h2>
                            <?php
                            $load_more_link = apply_filters( 'load_more_link', '<a href="#" class="btn bg-white content-section_btn" data-load>عرض الكل</a>', 'all', $user_bookmarks_arr, array( 5 ), true, $user_id, 3 );

                            if ( !empty($load_more_link) ) {
                                echo $load_more_link;
                            }
                            ?>
                        </div>
                        <div class="row">
                            <?php 
                            foreach ($featured_posts as $key => $post_id) {
                            ?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                    <?php get_template_part('templates/content-card'); ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php
                    // latest posts
                    $latest_posts = get_posts( array(
                        'post_type'         =>  array( 'articles', 'activities', 'stories', 'games', 'workshops' ),
                        'post_status'       =>  'publish',
                        'posts_per_page'    =>  3,
                        'post_parent'       =>  0,
                        'fields'            =>  'ids',
                        'post__not_in'      =>  $user_bookmarks_arr,
                        'tax_query'         => array(
                             array(
                                'taxonomy'  => 'category',
                                'field'     => 'term_id',
                                'terms'     => 5,
                                'operator'  =>  'NOT IN'
                            ),
                        )
                    ) );

                    if (!empty($latest_posts)) {
                    ?>
                    <div class="section-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <h2>المحتوى المنشور مؤخرا</h2>
                            
                        </div>
                        <div class="row">
                            <?php 
                            foreach ($latest_posts as $key => $post_id) {
                            ?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                <?php get_template_part('templates/content-card'); ?>

                            </div>
                            <?php } ?>
                        </div>
                        <div class="btn-readMore">
                            <?php
                            $load_more_link = apply_filters( 'load_more_link', '<a href="#" class="btn bg-white content-section_btn" data-load>عرض الكل</a>', 'all', $user_bookmarks_arr, array( 5 ), false, $user_id, 3 );

                            if ( !empty($load_more_link) ) {
                                echo $load_more_link;
                            } ?>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>  
            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-tags'); ?>
            </div>
        </div>
    </div>
</section>

