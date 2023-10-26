<?php
global $post_id;
global $types;
global $keyword;
// global $participants;
global $maxParticipants;
// global $age;
// global $duration;
global $durationHrs;
global $user_id;
global $group_id;
global $profile_id;
global $icebreaker; 
global $child_title;

$meta_query = array();

$post_type_filter = get_query_var('post_type_filter');
$participants = get_query_var('participants');
$age_range = get_query_var('age_range');
$duration = get_query_var('duration');

$filters_nothing_found = true;

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
    'orderby'=> 'post_date', 
    'order' => 'DESC'
);

if(!$participants && !$age_range && !$duration){
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
    }

if ( $types && !empty( $types ) ) {
    $result_posts_args['post_type'] = $types;
}

if ( $post_type_filter && !empty( $post_type_filter ) ) {
    $result_posts_args['post_type'] = $post_type_filter;
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

if ( $age_range && !empty( $age_range ) ) {
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
        'key'   =>  'mo_workshop_activity_age',
        'value' =>  $age_range
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
    'orderby'           => 'post_date', 
    'order'             => 'DESC',
    'meta_query'        => array(
                            'relation' => 'AND',
                            array(
                                'compare' => 'LIKE',
                                'key' => 'mo_entry_group',
                                'value' => $keyword
                            ), $meta_query)
    )
);

$activities_found = array_diff($activities_found, $result_posts);


?>

<section class="content-section search-results">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-filters-tags'); ?>
            </div>
            <div class="col-md-9">

            	<?php if ( !empty($result_posts) || !empty($users_found) || !empty ($activities_found) ) { ?>
                <div class="content-wrapper">

                    <div class="section-wrapper">
                        <div class="content-section_header d-flex align-items-center">
                            <h2>نتائج البحث عن:</h2>
                            <div class="fake-search-bar">
                                <i class="icon-icon-search"></i>
                                <p><?php echo $keyword;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <?php if(($post_type_filter == 'users') || ($post_type_filter == '') ):?>
                                <?php $filters_nothing_found = false;?>
                            <?php if(!empty($users_found)):?>
                            <?php foreach($users_found as $key => $userObj):?>
                                <div class="col-md-6 mz-mb-35">
                                    <?php $profile_id = $userObj->ID;
                                 get_template_part('templates/content-card_member');?>
                                </div>
                                <?php if(($key > 0) && ($key % 4 == 0)): ?>
                                    <div class="col-md-6 col-xl-4 mz-mb-35">
                                        <?php $suggestion =  rand(1,3); 
                                        switch($suggestion){
                                            case 1: 
                                                get_template_part('templates/content-suggestions-1');
                                                break;
                                            case 2:
                                                get_template_part('templates/content-suggestions-2');
                                                break;
                                            case 3: 
                                                get_template_part('templates/content-suggestions-3');
                                                break;
                                        }  
                                        ?>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                            <?php endif;?>
                            <?php endif;?>

                        	<?php foreach ($result_posts as $key => $post_id) {
                                $post = get_post($post_id);
                                $parent = $post->post_parent;
                                $filters_nothing_found = false;
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
                                        <?php if($post->post_type == "workshops"):?>
                                            <?php
                                                $post = get_post($post_id);
                                                $parent = $post->post_parent;
                                                // echo $parent;
                                                if($parent){
                                                    $parent_post = get_post($parent);
                                                    $parent2 = $parent_post->post_parent;
                                                    $child_title = get_the_title($post_id);
                                                    if($parent2){
                                                        $post_id = $parent2;
                                                        $icebreaker=true;
                                                        get_template_part('templates/content-card_new');
                                                    }
                                                }else{
                                                    $icebreaker = false;
                                                    $child_title = "";
                                                    get_template_part('templates/content-card_new');
                                                }
                                            ?>
                                        <?php else:?>
                                            <?php $icebreaker = false;
                                                $child_title = "";
                                            ?>
                                            <?php get_template_part('templates/content-card_new'); ?>
                                        <?php endif;?>
                                    <?php endif;?>
                                </div>

                                <?php if(($key > 0) && ($key % 4 == 0)): ?>
                                    <div class="col-md-6 col-xl-4 mz-mb-35">
                                        <?php $suggestion =  rand(1,3); 
                                        switch($suggestion){
                                            case 1: 
                                                get_template_part('templates/content-suggestions-1');
                                                break;
                                            case 2:
                                                get_template_part('templates/content-suggestions-2');
                                                break;
                                            case 3: 
                                                get_template_part('templates/content-suggestions-3');
                                                break;
                                        }  
                                        ?>
                                    </div>
                                <?php endif;?>

	                        <?php } ?>
                            <?php if(($post_type_filter == 'activities') || ($post_type_filter == '') ):?>
                            <?php foreach ($activities_found as $key => $post_id) {
                                $post = get_post($post_id);
                                $parent = $post->post_parent;
                                $filters_nothing_found = false;
                                ?>
                                <div class="col-md-6 mz-mb-35">
                                	<?php get_template_part('templates/content-card_new'); ?>
                                </div>

                                <?php if(($key > 0) && ($key % 4 == 0)): ?>
                                    <div class="col-md-6 col-xl-4 mz-mb-35">
                                        <?php $suggestion =  rand(1,3); 
                                        switch($suggestion){
                                            case 1: 
                                                get_template_part('templates/content-suggestions-1');
                                                break;
                                            case 2:
                                                get_template_part('templates/content-suggestions-2');
                                                break;
                                            case 3: 
                                                get_template_part('templates/content-suggestions-3');
                                                break;
                                        }  
                                        ?>
                                    </div>
                                <?php endif;?>

	                        <?php } ?>
                            <?php endif;?>

                            <?php if($filters_nothing_found):?>
                            <div class="col-md-6 col-xl-4 mz-mb-35">
                                <?php get_template_part('templates/content-suggestions-3'); ?>
                            </div>
                            <?php endif;?>
                            
                        </div>
                    </div>

                </div>
	            <?php 
	        	} else {?>
                    <div class="content-wrapper">
                        <div class="section-wrapper">
                            <div class="content-section_header d-flex justify-content-between align-items-center">
                                <h2>نتائج البحث عن:</h2>
                                <div class="fake-search-bar">
                                    <i class="icon-icon-search"></i>
                                    <p><?php echo $keyword;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
	        		<?php get_template_part('templates/content-empty');
	        	} 
	            ?>
            </div>  

            <!-- <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-tags'); ?>
            </div> -->

        </div>
    </div>
</section>
