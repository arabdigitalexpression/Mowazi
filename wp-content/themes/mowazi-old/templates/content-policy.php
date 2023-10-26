<?php
$post_title = get_the_title(3);
$post_date = get_the_date( 'Y/m/d', 3 );
$post_content = get_post(3);
$content = $post_content->post_content;
$content = apply_filters('the_content', $content);
?>
<section class="view-content">
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="view-content_container">
                    
                    <div class="view-content__container_header">
                        <h1>
                            <?php if ( $post_title ) { echo $post_title; } ?>
                        </h1>


                        <div class="post-details">
                            <?php if ( $post_date ) { ?>
                            <div class="post-time">
                                <i class="icon-clock-fill"></i>
                                <span><?php echo $post_date; ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="view-content__container_body privacy-policy_content">
                        <?php if ( $content ) { echo $content; } ?>   
                    </div>

                </div>

            </div>

            <div class="col-md-3">
                <div class="sidebar-sticky">
                   
                    <?php get_template_part('sidebars/sidebar-policy'); ?>
                    
                </div>
            </div>

        </div>
    </div>
</section>
