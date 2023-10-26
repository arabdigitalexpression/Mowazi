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

$tag_posts = get_posts( array(
    'post_type'         =>  'any',
    'post_status'       =>  'publish',
    'posts_per_page'    =>  -1,
    'post_parent'       =>  0,
    'fields'            =>  'ids',
    'tag_id'            =>  $tag_id
) );

?>
<!-- <a class="btn tag filter-tag" href="#">
    اطفال
    <i class="icon-close"></i>
    </a> -->
<section class="content-section">
    <div class="container">
        
        <div class="row">
            <div class="col-md-9">
                <?php if ( !empty($tag_posts) ) { ?>
                <div class="content-wrapper">
                    <div class="content-section_header d-flex justify-content-between align-items-center">
                        <h2>المحتوى المنشور تحت وسم "<?php echo $tag_name; ?>"</h2>
                    </div>
                    <div class="section-wrapper">
                        <div class="row">
                            <?php 
                            foreach ($tag_posts as $key => $post_id) {
                            ?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                <?php get_template_part('templates/content-card'); ?>
                            </div>
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

            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-tags'); ?>
            </div>

        </div>
    </div>
</section>