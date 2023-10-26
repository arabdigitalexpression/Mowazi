<?php
global $related_post_id;
global $user_id;


$post_title = get_the_title( $related_post_id );
$post_date = get_the_date('d F', $related_post_id);
$post_type = get_post_type( $related_post_id );
$post_tags = get_the_tags($related_post_id);
$post_excerpt = '';

// if related post was activity generate the excerpt from first step desc
if ( $post_type == 'activities' ) {
    $steps = get_post_meta( $related_post_id, 'mo_entry_group', true );

    if ( !empty( $steps ) ) {
        $post_excerpt = $steps[0]['desc'];
        // trim the step desc to max 100 chars
        $post_excerpt = mb_substr( $post_excerpt, 0, 120 ) . ' ...';
    }
} elseif ( $post_type == 'workshops' ) { // if related post was workshop generate the excerpt from workshop goals CMB
    $workshop_goals = get_post_meta( $related_post_id, 'mo_workshop_goals', true );
    // trim the step desc to max 100 chars
    $post_excerpt = mb_substr( $workshop_goals, 0, 120 ) . ' ...';
} else {
    $post_excerpt = wp_trim_excerpt('', $related_post_id);
}

$user_bookmarks = get_user_meta( $user_id, 'user_bookmarks', true );
$user_bookmarks_arr = array();

if ( !empty($user_bookmarks) ) {
    $user_bookmarks_arr = explode( ',', $user_bookmarks );
}
?>
<div class="card related-posts_card <?php if ( in_array( $related_post_id, $user_bookmarks_arr ) ) { echo 'bookmarked'; } ?>">
     <a href="<?php echo get_the_permalink($related_post_id); ?>" class="stretched-link get-post" data-c="view" data-id="<?php echo $related_post_id; ?>" title="<?php echo $post_title; ?>"></a>
     
    <div class="card-controls">
        <a class="bookmark" href="#" data-b="<?php echo $related_post_id; ?>"><i class="icon-bookmark"> </i></a>
    </div>

    <?php if ( $post_date ) { ?>
    <div class="card-header">
        <p><?php echo $post_date; ?></p>
    </div>
    <?php } ?>

    <div class="card-body">
        <h5 class="card-title"><?php echo $post_title; ?></h5>
        <p class="card-text"><?php echo $post_excerpt; ?></p>
        
    </div>

    <div class="card-footer">
        <?php
        /*if ($post_tags && !is_wp_error($post_tags)) {
            foreach ($post_tags as $key => $tag) {*/
        ?>
       <!--  <a href="<?php /*echo get_term_link($tag->term_id);*/ ?>" class="btn tag tag-sm" data-t="<?php /*echo $tag->term_id;*/ ?>" title="<?php /*echo $tag->name;*/ ?>"><?php /*echo $tag->name;*/ ?></a> -->
        <?php /*} }*/ ?>
    </div>

</div>