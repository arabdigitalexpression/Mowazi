<?php 
global $post_id;

?>
<!-- first blue section -->

<div id="carouselHomeIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
	  <?php $carousel = get_field('carousel', $post_id);
	  		$carousel_rows =  count($carousel);
			  $i = 0;
	  ?>
	  <?php while($i < $carousel_rows):?>
		<li data-target="#carouselHomeIndicators" data-slide-to="<?php echo $i;?>" class="<?php if($i==0){ echo 'active';}?>"></li>
		<?php $i++;
	  endwhile;?>
    <!-- <li data-target="#carouselHomeIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselHomeIndicators" data-slide-to="1"></li>
    <li data-target="#carouselHomeIndicators" data-slide-to="2"></li> -->
  </ol>
  <div class="carousel-inner">
	  <?php $i = 0; while(have_rows('carousel', $post_id)): the_row();?>

	  <div class="carousel-item <?php if($i==0){ echo 'active';}?>">
      <!-- <img class="d-block w-100" src="..." alt="First slide"> -->
	  <section class="section-lg bg-blue center-img home-section-1">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h1><?php the_sub_field('title')?></h1>
					<!-- <h1>لكل <span class="titleHighlight">شخص</span>
					 <div class="animation">
						<ul>
							<li>معلم</li>
							<li>ميسر</li>
							
						</ul>
					</div>
					 مهتم بالتعليم</h1> -->
					 <p><?php the_sub_field('paragraph');?></p>
					<!-- <p>
					بأي شكل من الأشكال و بيحب يعرف أساليب تعليمية سهلة ومبتكرة. 
					</p> -->
					<a href="<?php echo get_permalink(10); ?>" title="join us" class="btn btn-primary" data-page="10">
					<span>انضم الينا</span>
					<!-- <i class="icon-arrow-left"></i> -->
					</a>
					<a href="<?php echo get_permalink(6396); ?>" title="Know More" class="btn btn-outline-light btn-know-more">
					<span>اعرف اكثر</span>
					<!-- <i class="icon-arrow-left"></i> -->
					</a>
				<!-- this part is test for aniamtion toggle word -->
				
				<!-- end this part is test for aniamtion toggle word -->


				</div>
			</div>
		</div>
	</section>
    </div>
	  <?php $i++; endwhile;?>
  </div>
  <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a> -->
</div>


	<!-- start search section -->
	<section id="search-section">
		<!-- search form -->
		<div class="container">
		<?php get_template_part('templates/content-search_form'); ?>
		</div>
		<!-- end search form -->
	</section>


<?php if(have_rows('mowazi_illustrations')):?>
<section id="path-id" class="section-md">
    <!-- <a href="#" class="scroll"><i class="icon-mouse"></i> سكرول واعرف أكتر
    </a> -->
    <div class="container">
            <?php $index = 0; while(have_rows('mowazi_illustrations')): the_row();?>
            <div class="hero-wrapper">
                <?php if($index % 2 == 0):?>
                    <div class="section-text">
                        <p></p>
                        <h2><?php the_sub_field('section_title');?></h2>
                        <p><?php the_sub_field('section_text');?></p>
                        <a href="<?php echo get_permalink(10); ?>" title="join us" class="btn btn-primary" data-page="10">
                        <span>انضم الينا</span>
                        </a>
                    </div>
                    <div class="section-img">
                        <img src="<?php the_sub_field('illustration_image');?>" alt="main image">
                    </div>
                <?php else:?>
                    <div class="section-img">
                        <img src="<?php the_sub_field('illustration_image');?>" alt="main image">
                    </div>
                    <div class="section-text">
                        <p></p>
                        <h2><?php the_sub_field('section_title');?></h2>
                        <p><?php the_sub_field('section_text');?></p>
						<a href="<?php echo get_permalink(6396); ?>" title="join us" class="btn btn-primary">
                        <span>اعرف اكثر عن موازي</span>
						</a>
                    </div>
                <?php endif;?>
            </div>
            <?php $index++; endwhile;?>
    </div>
</section>
<?php endif;?>

	<?php
	/*$top_users = get_users( array(
		'role'					=>	'facilitator',
		'orderby'				=>	'post_count',
		'order'					=>	'DESC',
		'fields'				=>	'ID',
		'number'				=>	6,
		'has_published_posts'	=>	array( 'workshops', 'activities', 'articles', 'stories', 'games' )
	) );

	if ( !empty( $top_users ) ) {
		$top_users_chunk = array_chunk( $top_users, 2 );*/
	
	?>
	<!-- start yellow section -->
	<!-- <section class="section-md line-through-section" >
		<h2>المشاركين</h2>
		<div class="container line-throught-container"> -->
			<?php
			/*foreach ($top_users_chunk as $top_users_row) {*/
			?>
			<!-- wrapper -->
			<!-- <div class="card-wrapper"> -->
				<?php
				/*foreach ($top_users_row as $top_user_id) {
					$first_name = get_user_meta( $top_user_id, 'first_name', true );
					$last_name = get_user_meta( $top_user_id, 'last_name', true );
					$fullname = $first_name . ' ' . $last_name;

					$profile_avatar = wp_get_attachment_image_url( get_user_meta( $top_user_id, 'user_img_id', 1 ), 'avatar-lg' );
					$profile_url = get_author_posts_url( $top_user_id );*/
				?>
				<!-- card component -->
				<!-- <a href="<?php /*echo $profile_url;*/ ?>" class="card card_sm get-profile" data-p="<?php/* echo mo_crypt($top_user_id, 'e');*/ ?>"> -->
					<!-- info preview component -->
					<!-- <div class="info-preview"> -->
						<!-- avatar component -->
						<!-- <div class="avatar avatar-lg" <?php/* if ($profile_avatar) { echo 'data-avatar="' . $profile_avatar . '"'; }*/ ?>></div> -->
						<!-- end of avatar component -->
						<!-- <div class="info info-sm info-text-sm">
							<h4 class="info-title"><?php /*echo $fullname*/ ?></h4>
						</div> -->
						<!-- end of info preview component -->
					<!-- </div>
				</a> -->
				<!-- end card component -->
				<?php /* }*/ ?>
			<!-- </div> -->
			<?php /*}*/ ?>
<!-- 
		</div>
		<p>
		احنا بنشتغل مع خبراء في التعليم وممارسين أكفاء، لخلق محتوى متطور وحديث
		</p>
	</section> -->
	<?php /*}*/ ?>

	<!-- start green section -->
	<!-- <section class="section-md common-section green-section">
		<div class="container">
			<div class="hero-wrapper">
				<div class="section-text">
					<p>ازاي تستفيد من المحتوي؟</p>
					<h2>
					محتوي ملئ بالافكار
					</h2>
					<p>
					علشان نوفر وقت ومجهود أي شخص او كيان أثناء تصميم المناهج أو ورش أو الجلسات، بنقدم له أداة تساعده يستخدم أي محتوى  متاح  وكمان يقدمه بشكل مبتكر ومفيد
					</p>
				</div> 
				<div class="section-img">
						<img src="<?php echo get_template_directory_uri() . '/images/main-img5.svg';?>" alt="main image">
				</div>
			</div>
		</div>
	</section> -->

	<section class="section-md common-section content-types-section ">
		<h1>ايه انواع المحتوي؟</h1>
		<div class="content-types">
			<nav>
				<div class="nav nav-tabs" id="contentTypes-tab" role="tablist">
					<a class="nav-item nav-link active" id="nav-articles-tab" data-toggle="tab" href="#nav-articles" role="tab" aria-controls="nav-articles" aria-selected="true">مدونات</a>
					<a class="nav-item nav-link" id="nav-activities-tab" data-toggle="tab" href="#nav-activities" role="tab" aria-controls="nav-activities" aria-selected="false">انشطة</a>
					<a class="nav-item nav-link" id="nav-stories-tab" data-toggle="tab" href="#nav-stories" role="tab" aria-controls="nav-stories" aria-selected="false">حكايات</a>
					<a class="nav-item nav-link" id="nav-games-tab" data-toggle="tab" href="#nav-games" role="tab" aria-controls="nav-games" aria-selected="false">العاب</a>
					<a class="nav-item nav-link" id="nav-workshops-tab" data-toggle="tab" href="#nav-workshops" role="tab" aria-controls="nav-workshops" aria-selected="false">ورش</a>
				</div>
			</nav>
			<div class="tab-content" id="contentTypes-tabContent">
			
				<div class="tab-pane fade show active" id="nav-articles" role="tabpanel" aria-labelledby="nav-articles-tab">
						<?php
						$args = array(
							'numberposts' => 4,
							'post_type'   => 'articles',
							'fields'            =>  'ids',
							'post_status'       =>  'publish'
						);
					
						$latest_articles_ids = get_posts( $args );?>

					<?php if(!empty($latest_articles_ids)):?>
						<div class="content-cards articles-cards">
							<?php foreach ($latest_articles_ids as $key => $post_id):?>
							<?php get_template_part( 'templates/content-card_new' );?>
							<?php endforeach;?>
						</div>
						<a class=" btn-outline-light show-all" href="<?php echo get_post_type_archive_link('articles'); ?>" title="مدونات" data-archive="articles">عرض كل المدونات</a>
					<?php endif;?>
				</div>


				<div class="tab-pane fade" id="nav-activities" role="tabpanel" aria-labelledby="nav-activities-tab">
				
					<?php
						$args = array(
							'numberposts' => 4,
							'post_type'   => 'activities',
							'fields'            =>  'ids',
							'post_status'       =>  'publish'
						);
					
						$latest_activities_ids = get_posts( $args );?>

					<?php if(!empty($latest_activities_ids)):?>
						<div class="content-cards activities-cards">
							<?php foreach ($latest_activities_ids as $key => $post_id):?>
							<?php get_template_part( 'templates/content-card_new' );?>
							<?php endforeach;?>
						</div>
						<a class=" btn-outline-light show-all" href="<?php echo get_post_type_archive_link('activities'); ?>" title="أنشطة" data-archive="activities">عرض كل الأنشطة</a>
					<?php endif;?>
				</div>
				<div class="tab-pane fade" id="nav-stories" role="tabpanel" aria-labelledby="nav-stories-tab">
					<?php
						$args = array(
							'numberposts' => 4,
							'post_type'   => 'stories',
							'fields'            =>  'ids',
							'post_status'       =>  'publish'
						);
					
						$latest_stories_ids = get_posts( $args );?>

					<?php if(!empty($latest_stories_ids)):?>
						<div class="content-cards stories-cards">
							<?php foreach ($latest_stories_ids as $key => $post_id):?>
							<?php get_template_part( 'templates/content-card_new' );?>
							<?php endforeach;?>
						</div>
						<a class=" btn-outline-light show-all" href="<?php echo get_post_type_archive_link('stories'); ?>" title="الحكايات" data-archive="stories">عرض كل الحكايات</a>

					<?php endif;?>
				</div>
				<div class="tab-pane fade" id="nav-games" role="tabpanel" aria-labelledby="nav-games-tab">
					<?php
						$args = array(
							'numberposts' => 4,
							'post_type'   => 'games',
							'fields'            =>  'ids',
							'post_status'       =>  'publish'
						);
					
						$latest_games_ids = get_posts( $args );?>

					<?php if(!empty($latest_games_ids)):?>
						<div class="content-cards games-cards">
							<?php foreach ($latest_games_ids as $key => $post_id):?>
							<?php get_template_part( 'templates/content-card_new' );?>
							<?php endforeach;?>
						</div>
						<a class=" btn-outline-light show-all" href="<?php echo get_post_type_archive_link('games'); ?>" title="الألعاب" data-archive="games">عرض كل الألعاب</a>

					<?php endif;?>
				</div>
				<div class="tab-pane fade" id="nav-workshops" role="tabpanel" aria-labelledby="nav-workshops-tab">
					<?php
						$args = array(
							'numberposts' => 4,
							'post_type'   => 'workshops',
							'fields'            =>  'ids',
							'post_status'       =>  'publish',
							'post_parent' => 0,
							'include_children' => false
						);
					
						$latest_workshops_ids = get_posts( $args );?>

					<?php if(!empty($latest_workshops_ids)):?>
						<div class="content-cards workshops-cards">
							<?php foreach ($latest_workshops_ids as $key => $post_id):?>
							<?php get_template_part( 'templates/content-card_new' );?>
							<?php endforeach;?>
						</div>
						<a class=" btn-outline-light show-all" href="<?php echo get_post_type_archive_link('workshops'); ?>" title="الورش" data-archive="workshops">عرض كل الورش</a>

					<?php endif;?>
				</div>
			</div>
		</div>
	</section>

	<!-- why mowazi-section -->
	<section id="why-mowazi-section" class="section-md common-section">
		<div class="container">
			<h1>ليه موازي؟</h1>
			<div class="items">
				<div class="item">
					<div class="item-img">
						<img src="<?php echo get_template_directory_uri()?>/images/arabic.svg" alt="">
					</div>
					<div class="item-text">
						<h6>محتوي عربي</h6>
						<p>أحنا بنشتغل مع خبراء في التعليم ومجتمع الممارسين علي خلق محتوي متطور ومتغير دايما،وهدفنا في المنصة ان ناس كتير تنضم لينا وتزود معانا المحتوي التعليمي</p>
					</div>
				</div>	
				<div class="item">
					<div class="item-img">
						<img src="<?php echo get_template_directory_uri()?>/images/why-mowazi-2.svg" alt="">
					</div>
					<div class="item-text">
						<h6>مفتوح المصدر</h6>
						<p>أحنا بنشتغل مع خبراء في التعليم ومجتمع الممارسين علي خلق محتوي متطور ومتغير دايما،وهدفنا في المنصة ان ناس كتير تنضم لينا وتزود معانا المحتوي التعليمي</p>
					</div>
				</div>
				<div class="item">
					<div class="item-img">
						<img src="<?php echo get_template_directory_uri()?>/images/why-mowazi-1.svg" alt="">
					</div>
					<div class="item-text">
						<h6>للجميع</h6>
						<p>أحنا بنشتغل مع خبراء في التعليم ومجتمع الممارسين علي خلق محتوي متطور ومتغير دايما،وهدفنا في المنصة ان ناس كتير تنضم لينا وتزود معانا المحتوي التعليمي</p>
					</div>
				</div>				
			</div>
		</div>
	</section>

	<!-- how-to-create-content -->
	<section id="how-to-section" class="section-md common-section">
		<div class="container">
			<h1>ازاي تخلق محتوي؟</h1>
			
			<?php if(get_field('youtube_video')):?>
				<div class="video">
					<iframe src="<?php the_field('youtube_video');?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			<?php endif;?>

			<div class="faqs">
				<div id="accordion">
					<?php $i = 0; while(have_rows('faqs')): the_row();?>
						<div class="card">
							<div class="card-header" id="heading<?php echo $i;?>">
								<h5 class="mb-0">
									<button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $i;?>" aria-expanded="true" aria-controls="collapse<?php echo $i;?>">
										<?php the_sub_field('question');?>
									</button>
								</h5>
							</div>

							<div id="collapse<?php echo $i;?>" class="collapse <?php if($i == 0 ){echo 'show';}?>" aria-labelledby="heading<?php echo $i;?>" data-parent="#accordion">
								<div class="card-body">
									<?php the_sub_field('answer');?>
								</div>
							</div>
						</div>
					<?php $i++; endwhile;?>
				</div>
				<!-- redirect to faqs page -->
				<a class="btn-outline all-faqs show-all" href="#" title="الاسئلة الشائعة" data-archive="workshops">عرض  الكل </a>
			</div>
		</div>
	</section>

<!-- yellow -section -->
	<section id="testimonal-section" class="section-md common-section">
		<div class="container">
			<h4>أصدقاء البرنامج</h4>
			<h1>مين بيعتمد علي موازي؟</h1>
			<div class="items">
				<?php while(have_rows('testimonals')): the_row();?>

				<div class="item">
					<div class="flip-card">
						<div class="flip-card-inner">
							<div class="flip-card-front">
								<img src="<?php the_sub_field('image'); ?>">
								<div class="card-author">
									<p class="name"><?php the_sub_field('name');?></p>
									<p class="job-title"><?php the_sub_field('title');?></p>
								</div>
							</div>
							<div class="flip-card-back">
								<div class="message">
									<p><?php the_sub_field('message');?></p>
								</div>
								<div class="card-author">
									<img src="<?php the_sub_field('avatar');?>" alt="">
									<div class="author-info">
										<p class="name"><?php the_sub_field('name');?></p>
										<p class="job-title"><?php the_sub_field('title');?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile;?>
			</div>



			<div id="carouselTestimonalsIndicators" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php $carousel = get_field('testimonals');
							$carousel_rows =  count($carousel);
							$i = 0;
					?>
					<?php while($i < $carousel_rows):?>
						<li data-target="#carouselTestimonalsIndicators" data-slide-to="<?php echo $i;?>" class="<?php if($i==0){ echo 'active';}?>"></li>
						<?php $i++;
					endwhile;?>
				</ol>
				<div class="carousel-inner">
					<?php $i = 0; while(have_rows('testimonals')): the_row();?>

					<div class="carousel-item <?php if($i==0){ echo 'active';}?>">
						<div class="flip-card">
							<div class="flip-card-inner">
								<div class="flip-card-front">
									<img src="<?php the_sub_field('image'); ?>">
									<div class="card-author">
										<p class="name"><?php the_sub_field('name');?></p>
										<p class="job-title"><?php the_sub_field('title');?></p>
									</div>
								</div>
								<div class="flip-card-back">
									<div class="message">
										<p><?php the_sub_field('message');?></p>
									</div>
									<div class="card-author">
										<img src="<?php the_sub_field('avatar');?>" alt="">
										<div class="author-info">
											<p class="name"><?php the_sub_field('name');?></p>
											<p class="job-title"><?php the_sub_field('title');?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php $i++; endwhile;?>
				</div>
			</div>



		</div>
	</section>
	<!-- start blue section -->
	<!-- <section class="section-md blue-section common-section">
		<div class="container">
			<div class="hero-wrapper">
				<div class="section-text">
					<p>ازاي تستفيد من المحتوي؟</p>
					<h2>
					تبادل الخبرات
					</h2>
					<p>
					منصة واحدة بتجمع الكل وتساعدهم في تبادل الخبرات وكله موجود في مكان واحد سهل الاستخدام
					</p>
				</div> 
				<div class="section-img">
						<img src="<?php echo get_template_directory_uri() . '/images/Workshops2.svg';?>" alt="main image">
				</div>
			</div>
			<div class="hero-wrapper">
				<div class="section-img">
						<img src="<?php echo get_template_directory_uri() . '/images/Workshops.svg';?>" alt="main image">
				</div>
				<div class="section-text">
					<p>ازاي تستفيد من المحتوي؟</p>
					<h2>
					 أدوات تحضير سهلة
					</h2>
					<p>
					كل اللي بيصمم مناهج او ورش او جلسات يقدر يستخدم اي محتوي متاح ويقدمه بشكل جديد. صممنا أداه تساعد كل الميسيرين علشان يوفورا وقت ومجهود وقت تصميم الورش والجلسات
					</p>
				</div> 
			</div>
		</div>
	</section> -->

	<!-- start white section -->
	<!-- <section class="section-lg white-section">
		<div class="container">
			<div class="intro">
				<p>أصدقاء البرنامج</p>
				<h1>مين بيعتمد علي موازي؟</h1>
			</div> -->
			<?php
			/*$testimonial = get_post_meta( 6, 'mo_testimonial_group', true );
			if ( !empty( $testimonial ) ) {*/
			?>
			<!-- <div class="row"> -->
				<?php
				/*foreach ($testimonial as $testimonial_entry) {
					$testimonial_name = $testimonial_desc = $testimonial_photo = '';

					if ( isset( $testimonial_entry['name'] ) ) {
						$testimonial_name = esc_html( $testimonial_entry['name'] );
					}

					if ( isset( $testimonial_entry['desc'] ) ) {
						$testimonial_desc = esc_html( $testimonial_entry['desc'] );
					}

					if ( isset( $testimonial_entry['photo'] ) ) {
						$testimonial_photo = wp_get_attachment_image_url( $testimonial_entry['photo_id'], 'full' );
					}*/
				
				?>
				<!-- <div class="col-md-4"> -->
					<!-- card-testmonilas -->
					<!-- <div class="card-testmonilas">
						<div class="content">
							<div class="front" data-avatar="<?php /*echo $testimonial_photo;*/ ?>">
							</div>
							<div class="back">
								<h4> -->
								<?php /* echo $testimonial_desc;*/ ?>
								<!-- </h4> -->
								<!-- info preview component -->
								<!-- <div class="info-preview "> -->
									<!-- avatar component -->
									<!-- <div class="avatar avatar-lg" data-avatar="<?php /*echo $testimonial_photo;*/ ?>"></div> -->
									<!-- end of avatar component -->
									<!-- <div class="info info-sm ">
										<h4 class="info-title"><?php /*echo $testimonial_name*/ ?></h4>
									</div> -->
									<!-- end of info preview component -->
								<!-- </div>
							</div>
						</div>
					</div>
				</div> -->
				<?php /*}*/ ?>
			<!-- </div> -->
			<?php /*}*/ ?>

			
		<!-- </div>
	</section> -->
