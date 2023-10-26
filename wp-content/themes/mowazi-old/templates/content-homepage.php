	<!-- first blue section -->
	<section class="section-lg bg-blue center-img">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h1>لكل <span class="titleHighlight">شخص</span>
					<!-- <div class="animation">
						<ul>
							<li>معلم</li>
							<li>ميسر</li>
							
						</ul>
					</div> -->
					 مهتم بالتعليم</h1>
					<p>
					<!-- بيحب يعرف أساليب سهلة ومبتكرة تساعده في تحضير جلسات وورش جامدة. -->
					بأي شكل من الأشكال و بيحب يعرف أساليب تعليمية سهلة ومبتكرة. 
					</p>
					<a href="<?php echo get_permalink(10); ?>" title="join us" class="btn btn-primary" data-page="10">
					<span>انضم الينا</span>
					<i class="icon-arrow-left"></i>
				</a>
				<!-- this part is test for aniamtion toggle word -->
				
				<!-- end this part is test for aniamtion toggle word -->


				</div>
			</div>
		</div>
	</section>
	<!-- start pink section -->
	<section id="path-id" class="section-md">
		<a href="#" class="scroll"><i class="icon-mouse"></i> سكرول واعرف أكتر
		</a>
		<div class="container">
			<div class="hero-wrapper">
				<div class="section-img">
						<img src="<?php echo get_template_directory_uri() . '/images/main-img2.svg';?>" alt="main image">
				</div> 
				<div class="section-text">
					<p>بنعمل ايه؟</p>
					<h2>
					محتوي تعليمي متنوع
					</h2>
					<p>
					هنا هنقرا ونخلق محتوى متنوع بالعربي، مدونات وورش وأنشطة وحكايات وألعاب.
					</p>
				</div>
				
			</div>
			<div class="hero-wrapper">
				<div class="section-text">
					<p>بنعمل ايه؟</p>
					<h2>
					محتوى تشاركي
					</h2>
					<p>
					هنا نقدر  نبني ونكمل على محتوى بعض، بدل ما نخترع كله من الأول.
					</p>
				</div>
				<div class="section-img img-lg">
					<img src="<?php echo get_template_directory_uri() . '/images/main-img3.svg';?>" alt="main image">
				</div>
			</div>
			<div class="hero-wrapper">
				<div class="section-img">
						<img src="<?php echo get_template_directory_uri() . '/images/main-img4.svg';?>" alt="main image">
				</div> 
				<div class="section-text">
					<p>منين المحتوي؟</p>
					<h2>
					اي شخص ممكن يشارك!
					</h2>
					<p>
					هنا مكان لكل الأفراد والكيانات اللي مهتمة بالتعليم، تنشر المحتوى بتاعها وتشاركه مع الآخرين.
هدفنا في المنصة ان ناس كتير تنضم لينا وتزود معانا المحتوى التعليمي.
					</p>
				</div> 
			</div>

		</div>
	</section>

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
	<section class="section-md common-section green-section">
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
	</section>
	<!-- start blue section -->
	<section class="section-md blue-section common-section">
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
	</section>

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
