<?php
global $post_id;
global $types;
global $keyword;
global $participants;
global $maxParticipants;
global $age;
global $duration;
global $durationHrs;
global $user_id;
global $group_id;
global $profile_id;

$meta_query = array();


if (!$user_id) {
    $user_id = get_current_user_id();
}

$result_posts_args = array(
    'post_type'         =>  array('groups','workshops', 'activities', 'stories', 'games', 'articles' ),
    'post_status'       =>  'publish',
    'posts_per_page'    =>  -1,
    // 'post_parent'       =>  0,
    'fields'            =>  'ids',
    'include_children'  =>  true,
);

$users = new WP_User_Query( array(
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key'     => 'first_name',
            'value'   => $keyword,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'last_name',
            'value'   => $keyword,
            'compare' => 'LIKE'
        ),
        array(
            'key'     => 'display_name',
            'value'   => $keyword,
            'compare' => 'LIKE'
        ),
    )
) );
$users_found = $users->get_results();


if ( $types && !empty( $types ) ) {
    $result_posts_args['post_type'] = $types;
}

if ( $keyword && !empty( $keyword ) ) {
    $result_posts_args['s'] = $keyword;
}

if ( $participants && !empty( $participants ) ) {
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
        'key'   =>  'mo_workshop_activity_participants',
        'value' =>  $participants
    );
}
if ( $maxParticipants && !empty( $maxParticipants ) ) {
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
        'key'   =>  'mo_workshop_activity_max_participants',
        'value' =>  $maxParticipants
    );
}

if ( $age && !empty( $age ) ) {
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
        'key'   =>  'mo_workshop_activity_age',
        'value' =>  $age
    );
}

if ( $duration && !empty( $duration ) ) {
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
        'key'   =>  'mo_workshop_activity_duration',
        'value' =>  $duration
    );
}
if ( $durationHrs && !empty( $durationHrs ) ) {
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
        'key'   =>  'mo_workshop_activity_duration_hrs',
        'value' =>  $durationHrs
    );
}

$result_posts_args['meta_query'] = $meta_query;
$result_posts = get_posts( $result_posts_args );

///search for activities

$activities_found = get_posts(
    array(
    'post_type'         =>  'activities',
    'post_status'       =>  'publish',
    'posts_per_page'    =>  -1,
    // 'post_parent'       =>  0,
    'fields'            =>  'ids',
    'include_children'  =>  true,
    'meta_query'        => array(
                            'relation' => 'AND',
                            array(
                                'compare' => 'LIKE',
                                'key' => 'mo_entry_group',
                                'value' => $keyword
                            ))
    )
);
// foreach($activities_and_workshops as $key => $act_id){
//     $act = get_post($act_id);
//     print_r(get_post_meta($act_id, 'mo_entry_group'));
// }
// echo "Activities";

// print_r($activities_found);
// $result = array_intersect($result_posts, $activities_found);
$activities_found = array_diff($activities_found, $result_posts);
// echo "Common Values";

// print_r($result);
// echo "AFter removing dups";
// print_r($activities_found);

?>

<section class="content-section">
    <div class="container">
        <div class="row">
            <div class="col-md-9">

            	<?php if ( !empty($result_posts) || !empty($users_found) || !empty ($activities_found) ) { ?>
                <div class="content-wrapper">

                    <div class="section-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <h2>نتائج البحث</h2>
                        </div>
                        <div class="row">

                            <?php foreach($users_found as $user):?>
                                <div class="col-md-6 mz-mb-35">
                                    <?php $profile_id = $user->ID;
                                 get_template_part('templates/content-card_member');?>
                                </div>
                            <?php endforeach;?>

                        	<?php foreach ($result_posts as $key => $post_id) {
                                $post = get_post($post_id);
                                $parent = $post->post_parent;
                                // if($parent){
                                //     $post = get_post($parent);
                                //     $parent = $post->post_parent;
                                //     if($parent){
                                //         $post_id = $parent;
                                //     }
                                // }?>
                                <div class="col-md-6 mz-mb-35">
                                    <?php if($post->post_type == "groups"):?>
                                        <?php $group_id = $post_id; get_template_part('templates/content-card-group');?>
                                    <?php else:?>
                                	    <?php get_template_part('templates/content-card'); ?>
                                    <?php endif;?>
                                </div>
	                        <?php } ?>

                            <?php foreach ($activities_found as $key => $post_id) {
                                $post = get_post($post_id);
                                $parent = $post->post_parent;
                                ?>
                                <div class="col-md-6 mz-mb-35">
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
