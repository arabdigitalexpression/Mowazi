<?php
global $post_id;

$scrollspy = get_post_meta( $post_id, 'mo_scrollspy_group', true );
?>
<div class="right-side_info">
    <?php
    if ( !empty( $scrollspy ) ) {
        foreach ($scrollspy as $headline) {
            $text = $target = '';

            if ( isset( $headline['headline'] ) ) {
                $text = $headline['headline'];
            }

            if ( isset( $headline['target'] ) ) {
                $target = $headline['target'];
            }
    ?>
    <a href="#" data-target="<?php echo $target; ?>" class="article-title"><?php echo $text; ?></a>
    <?php
        }
    }
    ?>
</div>