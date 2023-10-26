<?php
global $post_id;

if ( !$post_id ) {
    $post_id = $wp_query->get_queried_object()->ID;
}

$post_content = get_post($post_id);
$content = $post_content->post_content;
$content = apply_filters('the_content', $content);
?>

<?php get_template_part('modals/modal-publish_workshop'); ?>

<div class="container-fluid p-0">
    <div class="container-post-wrapper">

    
        <div class="container-post__right_side">
            <?php get_template_part('sidebars/sidebar-add_post_scrollspy'); ?>
        </div>


        <div class="container-post__center" data-post="<?php echo $post_id; ?>">
            <textarea id="tiny" name="tinymce" data-post="<?php echo $post_id; ?>"><?php if ($content) { echo $content;} ?></textarea>
        </div>

        <div class="container-post__left_side">
            <?php get_template_part('sidebars/sidebar-add_post_left'); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        var wyswig = jQuery('.tox.tox-tinymce.tox-tinymce--toolbar-sticky-off');
        if(!wyswig){
            location.reload();
        }
    })
</script>