<?php
global $post_id;
global $user_id;
global $entry_id;

if ( !$post_id ) {
    $post_id = $wp_query->get_queried_object()->ID;
}

if (!$user_id) {
    $user_id = get_current_user_id();
}

$post_type = get_post_type( $post_id );
$post_content = get_post($post_id);
$post_author = (int)get_post_field ('post_author', $post_id);
$content = $post_content->post_content;
$content = apply_filters('the_content', $content);

$days = array();
if ( $post_type == 'workshops' ) {
    $days = get_posts( array(
        'post_type'         =>  $post_type,
        'post_status'       =>  'publish',
        'nopaging'          =>  true,
        'posts_per_page'    =>  -1,
        'post_parent'       =>  $post_id,
        'fields'            =>  'ids',
        'order'             =>  'ASC',
        'orderby'           =>  'meta_value',
        'meta_key'          =>  'mo_day_target'
    ) );
}

if ( $post_type == 'workshops' || $post_type == 'activities' ) {
    $entries_args = array(
        'post_type'         =>  $post_type,
        'nopaging'          =>  true,
        'posts_per_page'    =>  -1,
        'fields'            =>  'ids',
        'order'             =>  'ASC',
        'orderby'           =>  'meta_value_num',
        'meta_key'          =>  'mo_entry_order'
    );

    if ( $post_author == $user_id ) {
        $entries_args['post_status'] = 'any';
    }
}
?>

<?php get_template_part('modals/modal-publish_workshop'); ?>

<div class="container-fluid p-0 workshop-container">
    <div class="container-post-wrapper <?php if ( $post_type == 'activities' ) { echo 'activity-content'; } ?>">

    
        <div class="container-post__right_side">
            <?php get_template_part('sidebars/sidebar-add_post_right'); ?>
        </div>


        <div class="container-post__center" data-post="<?php echo $post_id; ?>">
            <div class="btn-days_wrapper">
                <div class="list-group" id="list-tab" role="tablist">
                    <a href="#" class="btn tab"><i class="icon-plus"></i><span>جديد</span></a>
                    <?php
                    if ( !empty( $days ) ) {
                        $nav_count = 0;
                        foreach ($days as $day) {
                            $nav_count++;
                            $nav_target = get_post_meta( $day, 'mo_day_target', true );
                    ?>
                    <a class="btn <?php if ( $nav_count == 1 ) { echo 'active'; } ?>" href="#<?php echo $nav_target; ?>" role="tab" aria-controls="<?php echo $nav_target; ?>" data-post="<?php echo $day; ?>" aria-selected="<?php if ( $nav_count == 1 ) { echo 'true'; } ?>"><?php if ( $nav_count > 1 ) { echo '<i class="icon-minus"></i>'; } ?><?php echo get_the_title( $day ); ?></a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <button onclick="toggleExpandAll(this)"><i class="icon-notes"></i> expand/collapse all</button>

            <div class="workshop-content_wrapper">
                <div class="tab-content">
                    <?php
                    if ( !empty( $days ) && $post_type == 'workshops' ) {
                        $tab_count = 0;
                        foreach ($days as $day) {
                            $tab_count++;
                            $tab_target = get_post_meta( $day, 'mo_day_target', true );
                    ?>
                    <div class="tab-pane drag-option <?php if ( $tab_count == 1 ) { echo 'active'; } ?>" id="<?php echo $tab_target; ?>" aria-labelledby="<?php echo $tab_target; ?>" role="tabpanel" data-post="<?php echo $day; ?>">

                        <?php
                        $entries_args['post_parent'] = $day;
                        $entries = get_posts( $entries_args );

                        if ( !empty( $entries ) ) {
                            foreach ($entries as $entry_id) {
                                get_template_part('templates/content-card_entry');
                            }
                        }
                        ?>

                    </div>
                    <?php
                        }
                    } elseif ( $post_type == 'activities' ) { // activity type
                        $entries_args['p'] = $post_id;
                        $entries = get_posts( $entries_args );
                        if ( !empty( $entries ) ) {
                            foreach ($entries as $entry_id) {
                                get_template_part('templates/content-card_entry');
                            }
                        }
                    }
                    ?>

                </div>
            </div>
        </div>


        <div class="container-post__left_side">
            <?php get_template_part('sidebars/sidebar-add_post_left'); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function toggleExpandAll(button){
        var elems = jQuery('.tab-pane.active .workshop_partition_content');
        if(!jQuery(button).hasClass("expanded")){
            jQuery(button).addClass('expanded');
            elems.addClass('expand-workshop-component');
        }else{
            jQuery(button).removeClass('expanded');
            elems.removeClass('expand-workshop-component');
        }
    }
</script>