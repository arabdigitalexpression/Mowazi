<?php
global $tag_id;
global $tag_name;
global $post_id;

if ( !$tag_id ) {
    $tag_id = get_queried_object()->term_id;
}

if ( !$tag_name ) {
    $tag_name = get_queried_object()->name;
}

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

$tags_post_types = 'any';
if($post_type_filter){
    $tags_post_types = $post_type_filter;
}

$tag_posts = get_posts( array(
    'post_type'         =>  $tags_post_types,
    'post_status'       =>  'publish',
    'posts_per_page'    =>  -1,
    'post_parent'       =>  0,
    'fields'            =>  'ids',
    'tag_id'            =>  $tag_id,
    'meta_query'        =>  $meta_query
) );

?>
<!-- <a class="btn tag filter-tag" href="#">
    اطفال
    <i class="icon-close"></i>
    </a> -->
<section class="content-section tags-archive-listing">
    <div class="container">
        
        <div class="row">
            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-filters-tags'); ?>
            </div>
            <div class="col-md-9">
                <div class="content-section_header d-flex justify-content-between align-items-center">
                    <h2>المحتوى المنشور تحت وسم "<?php echo $tag_name; ?>"</h2>
                </div>
                <?php if ( !empty($tag_posts) ) { ?>
                <div class="content-wrapper">
                    <!-- <div class="content-section_header d-flex justify-content-between align-items-center">
                        <h2>المحتوى المنشور تحت وسم "<?php echo $tag_name; ?>"</h2>
                    </div> -->
                    <div class="section-wrapper">
                        <div class="row">
                            <?php 
                            foreach ($tag_posts as $key => $post_id) {
                            ?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                <?php get_template_part('templates/content-card_new'); ?>
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

                </div>
                <?php 
                } else {
                    get_template_part('templates/content-empty');
                } 
                ?>
            </div>  

            <!-- <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-tags'); ?>
            </div> -->

        </div>
    </div>
</section>