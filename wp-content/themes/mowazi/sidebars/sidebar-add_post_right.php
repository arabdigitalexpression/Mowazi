<?php
global $post_id;

$post_type = get_post_type( $post_id );
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
    $post_duration_hrs = get_post_meta( $post_id, 'mo_workshop_activity_duration_hrs', true );
    $post_duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );
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
}
?>
<div class="right-side_info sidebar-sticky workshop-sidebar">
    <?php if($post_duration || $post_duration_hrs){ ?>
        <div class="duration-counter">
            <i class="icon-icon-clock"></i>
            <?php $duration = (int)$post_duration + ((int)$post_duration_hrs * 60); ?>
            <span><?php echo $duration; ?></span>
        </div>
    <?php } ?>
    <a href="#" class="btn add-workshop_partition" id="workshopPartition" data-placement="bottom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-plus"></i>
            <span>جديد</span>
            <i class="icon-tringle-down"></i>
    </a>
    <div class="dropdown">
            <div class="dropdown-menu dropdown-workshop_partition dropdown-menu-right" aria-labelledby="workshopPartition">
            <a class="dropdown-item purble-color" href="#">
            كاسر جليدي
            </a>
            <a class="dropdown-item trkuaz-color" href="#">
            مناقشة
            </a>
            <a class="dropdown-item orang-color" href="#">
            استراحة
            </a>
            <a class="dropdown-item whiteblue-color" href="#">
            نشاط
            </a>
            </div>
    </div>
    <div class="workshop-wrapper">
        <?php
        if ( !empty( $days ) && $post_type == 'workshops' ) {
            $tab_count = 0;
            foreach ($days as $day) {
                $tab_count++;
                $tab_target = get_post_meta( $day, 'mo_day_target', true );
        ?>
        <div data-mo-target="<?php echo $tab_target; ?>" class="<?php if ( $tab_count == 1 ) { echo 'd-block'; } else { echo 'd-none'; } ?>">
            
            <?php
            $entries_args['post_parent'] = $day;
            $entries = get_posts( $entries_args );

            if ( !empty( $entries ) ) {
                foreach ($entries as $entry_id) {
                    $color = str_replace( ' ', '', get_post_meta( $entry_id, 'mo_entry_color', true ) );
                    $target = get_post_meta( $entry_id, 'mo_entry_target', true );
                    $title = get_the_title( $entry_id );
            ?>
            <a href="#" class="workshop_partition <?php echo $color; ?>" data-panel="<?php echo $target; ?>"><span class="get-time">0</span><span class="get-text"><?php echo $title; ?></span><i class="icon-tringle-down"></i></a>
            <?php
                }
            }
            ?>
        </div>
        <?php
            }
        } elseif ( $post_type == 'activites' ) { // activity type
            $entries_args['p'] = $post_id;
            $entries = get_posts( $entries_args );
            if ( !empty( $entries ) ) {
                foreach ($entries as $entry_id) {
                    $color = str_replace( ' ', '', get_post_meta( $entry_id, 'mo_entry_color', true ) );
                    $target = get_post_meta( $entry_id, 'mo_entry_target', true );
        ?>
        <a href="#" class="workshop_partition <?php echo $color; ?>" data-panel="<?php echo $target; ?>"><span class="get-time">0</span><span class="get-text">نشاط</span><i class="icon-tringle-down"></i></a>
        <?php
                }
            }
        }
        ?>
    </div>
</div>