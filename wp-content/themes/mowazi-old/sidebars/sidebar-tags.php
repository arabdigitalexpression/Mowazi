<?php
$tags = get_tags( array(
    'orderby'   =>  'count',
    'order'     =>  'DESC'
) );

if ( !empty( $tags ) ) {
?>
<div class="sidebar-sticky">
    <div class="tags-container">
        <h3>#كلمات مفتاحية الأشهر</h3>

        <?php foreach ($tags as $tag) {
            $count = $tag->count;
            if($count >= 50){ ?>
                <a class="btn tag" href="<?php echo get_term_link($tag->term_id); ?>" data-t="<?php echo $tag->term_id; ?>" title="<?php echo $tag->name; ?>">
                    <span><?php echo $tag->name; ?></span>
                    <span>(<?php echo $count; ?>)</span>
                </a>
            <?php }
        } ?>

    </div>
</div>
<?php } ?>