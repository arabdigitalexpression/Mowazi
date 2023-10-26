<?php
global $post_id;

$scrollspy = get_post_meta( $post_id, 'mo_scrollspy_group', true );

if ( !empty( $scrollspy ) ) {
?>
<div class="card card-titles mz-mb-35">
    <div class="card-header">
        <a href="<?php echo get_the_permalink(13) . '?l=1'; ?>" class="info-preview">
            <!-- avatar component -->
            <div class="avatar avatar-md bg-secondary" ></div>
            <!-- end of avatar component -->
            <div href="#" class="info info-sm">
                <h4 class="info-title">موازي العاب</h4>
                <p class="info-subtitle">23 عضو في المجموعة</p>
            </div>
            <!-- end of user preview component -->
        </a>
    </div>
    <div class="card-body">
        <?php
        foreach ($scrollspy as $headline) {
            $text = $target = '';

            if ( isset( $headline['headline'] ) ) {
                $text = $headline['headline'];
            }

            if ( isset( $headline['target'] ) ) {
                $target = $headline['target'];
            }
        ?>
        <a href="#" data-target="<?php echo $target; ?>" class="btn article-title"><?php echo $text; ?></a>
        <?php } ?>
    </div>
</div>
<?php } ?>