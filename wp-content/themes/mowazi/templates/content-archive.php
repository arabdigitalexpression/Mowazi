<?php
global $post_type;
global $post_id;
global $user_id;

if (!$user_id) {
    $user_id = get_current_user_id();
}

$section_title_prefix = '';
$introDesc = '';


$participants = get_query_var('participants');
$age_range = get_query_var('age_range');
$duration = get_query_var('duration');

$posts_per_page = 10;
$meta_query = array();

if($participants){
    $posts_per_page= -1;
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
            'key' => 'mo_workshop_activity_participants',
            'value' => $participants
    );
}

if($age_range){
    $posts_per_page= -1;
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
            'key' => 'mo_workshop_activity_age',
            'value' => $age_range 
    );
}

if($duration){
    $posts_per_page= -1;
    $meta_query['relation'] = 'AND';
    $meta_query[] = array(
            'key' => 'mo_workshop_activity_duration',
            'value' => $duration
    );
}

if ($post_type == 'articles') {

	$section_title_prefix = 'المدونات';
    $introDesc = ' هنا مساحة للتوثيق والمشاركة ! بنحكي عن أفكار و تجارب عملية وتعليمية مرينا بيها و نقرأ عن تجارب  ناس آخرين و نبني على بعض.';

} elseif ($post_type == 'activities') {

	$section_title_prefix = 'الانشطة';
    $introDesc = 'افكار عملية و مسلية لتطبيق محتوى نظري!  هنا أنشطة متمكن تعزز بيها توصيل الفكرة ومساحة لتسجيل و مشاركة النشاطات الي نفذتها من قبل.';

} elseif ($post_type == 'workshops') {

	$section_title_prefix = 'الورش';
    $introDesc = 'وسيلة مساعدة  لتنظيم  و كتابة محتوى ورشة كامل ، من البداية للنهاية. وفرصة للإلهام وجمع المعلومات  عن ورش سابقة اتنفذت بطرق مبتكرة.';

} elseif ($post_type == 'stories') {

	$section_title_prefix = 'القصص';
    $introDesc = 'حكايات من كل مكان وأعمار مختلفة.';

} elseif ($post_type == 'games') {

	$section_title_prefix = 'الألعاب';
    $introDesc = 'هنا افكار كتير و مختلفة عن وسائل للتسلية ممكن تنفذها مع أصدقاء أو عائلة أو في ورشة أو مدرسة!';

}

$featured_posts = get_posts( array(
	'post_type'         =>  $post_type,
    'post_status'       =>  'publish',
    'posts_per_page'    =>  2,
    'post_parent'       =>  0,
    'fields'            =>  'ids',
    'tax_query'			=> array(
    	 array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => 5,
        ),
	)
) );

$latest_posts = get_posts( array(
	'post_type'         =>  $post_type,
    'post_status'       =>  'publish',
    'posts_per_page'    =>  $posts_per_page,
    'post_parent'       =>  0,
    'fields'            =>  'ids',
    'orderby'           => 'post_date',
    'order'             => 'desc',
    'tax_query'			=> array(
    	 array(
            'taxonomy' 	=> 'category',
            'field'    	=> 'term_id',
            'terms'    	=> 5,
            'operator'	=>	'NOT IN'
        ),
	),
    'meta_query'        =>  $meta_query
) );

?>

<section class="content-section">
    <div class="container">
        <div class="row">
        <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-filters-tags'); ?>
            </div>

            <div class="col-md-9">
                <ul class="breadcrumbs">
                    <li><a href="<?php echo get_site_url(); ?>">الرئسية</a></li>
                    <li>/</li>
                    <li><?php echo $section_title_prefix; ?></li>
                </ul>

                <div class="introDesc">
                    <p><?php echo $introDesc; ?></p>
                    <!-- <a href="#" class="btn btn-outline-secondary" data-toggle="modal" data-target="#NewPost">أضف محتوى جديد</a> -->
                </div>
            	<?php if ( !empty($featured_posts) || !empty($latest_posts) ) { ?>
                <div class="content-wrapper archive-listing">
                    <?php //echo breadcrumbs($post_type); ?>
                	<?php if (!empty($featured_posts)) { ?>
                    <div class="section-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <h2><?php echo $section_title_prefix; ?> المميزة</h2>
                            <?php
                            $load_more_link = apply_filters( 'load_more_link', '<a href="#" class="btn bg-white content-section_btn" data-load>عرض الكل</a>', array($post_type), false, array( 5 ), true, $user_id, 2 );

                            if ( !empty($load_more_link) ) {
                                echo $load_more_link;
                            }
                            ?>
                        </div>
                        <div class="row">
                        	<?php 
                        	foreach ($featured_posts as $key => $post_id) {
                        	?>
                                <div class="col-md-6">
                                    <?php get_template_part('templates/content-card_new'); ?>
                                </div>
	                        <?php } ?>
                        </div>
                    </div>
	                <?php } ?>

                	<?php if (!empty($latest_posts)) { ?>
                    <div class="section-wrapper">
                        <div class="content-section_header d-flex justify-content-between align-items-center">
                            <h2><?php echo $section_title_prefix; ?> الجديدة</h2>
                        </div>
                        <div class="row">
                            <?php 
                        	foreach ($latest_posts as $key => $post_id) {
                        	?>
                                <div class="col-md-6 col-xl-4 mz-mb-35">
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
                            <?php if($posts_per_page == 10):?>
                            <?php
                            $load_more_link = apply_filters( 'load_more_link', '<a href="#" class="btn bg-white content-section_btn" data-load>عرض الكل</a>', array($post_type), false, array( 5 ), false, $user_id, 6 );

                            if ( !empty($load_more_link) ) {
                                echo $load_more_link;
                            }
                            ?>
                            <?php endif;?>
                        </div>
                    </div>
	                <?php } ?>

                </div>
	            <?php 
	        	} else {
	        		get_template_part('templates/content-empty');
	        	} 
	            ?>
            </div>  

            <!-- <div class="col-md-3">
                <?php get_template_part('sidebars/sidebar-tags'); ?>
            </div> -->

        </div>
    </div>
</section>
