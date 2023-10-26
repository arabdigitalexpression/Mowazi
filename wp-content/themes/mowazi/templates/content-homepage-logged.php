<?php
global $post_id;
global $profile_id;
global $group_id; 

$user_id = get_current_user_id();

$defaultPostTypes = array( 'articles', 'activities', 'stories', 'games', 'workshops' );
$filteredPostTypes;

$participants = get_query_var('participants');
$age_range = get_query_var('age_range');
$duration = get_query_var('duration');
$post_type_filter = get_query_var('post_type_filter');

$posts_per_page = 10;
$meta_query = array();

if($participants){
    $posts_per_page= -1;
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
            'key' => 'mo_workshop_activity_participants',
            'value' => $participants
    );
}

if($age_range){
    $posts_per_page= -1;
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
            'key' => 'mo_workshop_activity_age',
            'value' => $age_range 
    );
}

if($duration){
    $posts_per_page= -1;
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
            'key' => 'mo_workshop_activity_duration',
            'value' => $duration
    );
}

if($post_type_filter){
    $posts_per_page= -1;
    $filteredPostTypes = array($post_type_filter);
}

?>

<div id="carouselHomeIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php $carousel = get_field('carousel');
                $carousel_rows =  count($carousel);
                $i = 0;
        ?>
        <?php while($i < $carousel_rows):?>
            <li data-target="#carouselHomeIndicators" data-slide-to="<?php echo $i;?>" class="<?php if($i==0){ echo 'active';}?>"></li>
            <?php $i++;
        endwhile;?>
    </ol>
    <div class="carousel-inner">
        <?php $i = 0; while(have_rows('carousel', $post_id)): the_row();?>

        <div class="carousel-item <?php if($i==0){ echo 'active';}?>">
        <!-- <img class="d-block w-100" src="..." alt="First slide"> -->
        <section class="section-lg bg-blue center-img home-section-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <h1><?php the_sub_field('title')?></h1>
                        <!-- <h1>لكل <span class="titleHighlight">شخص</span>
                        <div class="animation">
                            <ul>
                                <li>معلم</li>
                                <li>ميسر</li>
                                
                            </ul>
                        </div>
                        مهتم بالتعليم</h1> -->
                        <p><?php the_sub_field('paragraph');?></p>
                        <!-- <p>
                        بأي شكل من الأشكال و بيحب يعرف أساليب تعليمية سهلة ومبتكرة. 
                        </p> -->
                        <a href="<?php echo get_permalink(10); ?>" title="join us" class="btn btn-primary" data-page="10">
                        <span>انضم الينا</span>
                        <!-- <i class="icon-arrow-left"></i> -->
                        </a>
                        <a href="<?php echo get_permalink(6396); ?>" title="Know More" class="btn btn-outline-light btn-know-more">
                        <span>اعرف اكثر</span>
                        <!-- <i class="icon-arrow-left"></i> -->
                        </a>
                    <!-- this part is test for aniamtion toggle word -->
                    
                    <!-- end this part is test for aniamtion toggle word -->
                    </div>
                </div>
            </div>
        </section>
        </div>
        <?php $i++; endwhile;?>
    </div>
</div>

<section class="content-section homepage-loggedin">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-home');?>
                <?php get_template_part('sidebars/sidebar-filters-tags'); ?>
            </div>

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
                    <?php } ?>
                    
                    <?php
                    // latest posts
                    $latest_posts = get_posts( array(
                        'post_type'         =>  $filteredPostTypes ? $filteredPostTypes : $defaultPostTypes,
                        'post_status'       =>  'publish',
                        'posts_per_page'    =>  $posts_per_page,
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
                        ),
                        'meta_query'        =>  $meta_query
                        ) );

                    if (!empty($latest_posts) && ($post_type_filter != 'users')) {
                    ?>
                    <div class="section-wrapper homepage-content-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <!-- <h2>المحتوى المنشور مؤخرا</h2>  -->
                        </div>
                        <div class="row">
                            <?php 
                            foreach ($latest_posts as $key => $post_id) {
                            ?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                    <!-- <?php //get_template_part('templates/content-card'); ?> -->
                                    <?php $post = get_post($post_id);?>
                                    <?php if($post->post_type == "groups"):?>
                                        <?php $group_id = $post_id; get_template_part('templates/content-card-group');?>
                                    <?php else:?>
                                	    <?php get_template_part('templates/content-card_new'); ?>
                                    <?php endif;?>

                            </div>
                            <?php if(($key > 0) && ($key % 4 == 0)): ?>
                                <div class="col-md-6 col-xl-4 mz-mb-35">
                                    <?php $suggestion =  rand(1,3); 
                                    switch($suggestion){
                                        case 1: 
                                            get_template_part('templates/content-suggestions-1');
                                            break;
                                        case 2:
                                            get_template_part('templates/content-suggestions-2');
                                            break;
                                        case 3: 
                                            get_template_part('templates/content-suggestions-3');
                                            break;
                                    }  
                                    ?>
                                </div>
                            <?php endif;?>
                            <?php } ?>
                        </div>
                        <?php if($posts_per_page == 10):?>
                        <div class="btn-readMore">
                            <?php
                            $load_more_link = apply_filters( 'load_more_link', '<a href="#" class="btn bg-white content-section_btn" data-load>عرض الكل</a>', 'all', $user_bookmarks_arr, array( 5 ), false, $user_id, 3 );

                            if ( !empty($load_more_link) ) {
                                echo $load_more_link;
                            } ?>
                        </div>
                        <?php endif;?>
                    </div>
                    <?php } ?>


                    <?php if($post_type_filter == 'users'):?>
                    <?php 
                        // $users = new WP_User_Query();
                        // $users_found = $users->get_results();
                        // $print_r($users_found);
                        $users = get_users();
                    ?>
                    <?php if (!empty($users)) {
                    ?>
                    <div class="section-wrapper homepage-content-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <!-- <h2>المحتوى المنشور مؤخرا</h2>  -->
                        </div>
                        <div class="row">
                            <?php 
                            foreach ($users as $key => $user) {
                            ?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                    <!-- <?php //get_template_part('templates/content-card'); ?> -->
                                    <?php $profile_id = $user->ID;?>
                                    <?php get_template_part('templates/content-card_member'); ?>

                            </div>
                            <?php if(($key > 0) && ($key % 4 == 0)): ?>
                                <div class="col-md-6 col-xl-4 mz-mb-35">
                                    <?php $suggestion =  rand(1,3); 
                                    switch($suggestion){
                                        case 1: 
                                            get_template_part('templates/content-suggestions-1');
                                            break;
                                        case 2:
                                            get_template_part('templates/content-suggestions-2');
                                            break;
                                        case 3: 
                                            get_template_part('templates/content-suggestions-3');
                                            break;
                                    }  
                                    ?>
                                </div>
                            <?php endif;?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php endif;?>


                </div>
            </div>  
            <!-- <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-tags'); ?>
            </div> -->
        </div>
    </div>
</section>

