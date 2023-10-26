
<section id="about-banner" class="section-md">
    <div class="container">
        <div class="banner-content">
            <h1 class="banner-title"><?php the_field('banner_title')?></h1>
            <p class="banner-text"> <?php the_field('banner_text')?></p>
        </div>
    </div>
</section>
<!-- start white section -->
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
                        <!-- <a href="<?php echo get_permalink(6396); ?>" title="join us" class="btn btn-primary">
                        <span>اعرف اكثر عن موازي</span>
						</a> -->
                    </div>
                <?php endif;?>
            </div>
            <?php $index++; endwhile;?>
    </div>
</section>
<?php endif;?>

<?php if(get_field('container_text')):?>
<section class="section-md" id="why-join-mowazi">
    <div class="container">
        <div class="image-or-video">    
            <?php if(get_field('container_image')):?>
                <img src="<?php the_field('container_image');?>" alt="">
            <?php elseif (get_field('container_video')):?>
                <iframe src="<?php the_field('container_video'); ?>" width="100%" height="550px" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php endif;?>
        </div>
        <div class="container-content">
            <h2 class="container-title"><?php the_field('container_title');?></h2>
            <p class="container-text"><?php the_field('container_text');?></p>
        </div>
    </div>
</section>
<?php endif;?>



<?php if(have_rows('mowazi_illustrations_2')):?>
<section id="path-id" class="section-md">
    <!-- <a href="#" class="scroll"><i class="icon-mouse"></i> سكرول واعرف أكتر
    </a> -->
    <div class="container">
            <?php $index = 0; while(have_rows('mowazi_illustrations_2')): the_row();?>
            <div class="hero-wrapper">
                <?php if($index % 2 == 1):?>
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
                        <!-- <a href="<?php echo get_permalink(6396); ?>" title="join us" class="btn btn-primary">
                        <span>اعرف اكثر عن موازي</span>
						</a> -->
                    </div>
                <?php endif;?>
            </div>
            <?php $index++; endwhile;?>
    </div>
</section>
<?php endif;?>

<?php if(get_field('container_text_2')):?>
<section class="section-md" id="why-join-mowazi">
    <div class="container">
        <div class="image-or-video">    
            <?php if(get_field('container_image_2')):?>
                <img src="<?php the_field('container_image_2');?>" alt="">
            <?php elseif (get_field('container_video_2')):?>
                <iframe src="<?php the_field('container_video_2'); ?>" width="100%" height="550px" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php endif;?>
        </div>
        <div class="container-content">
            <p class="container-text"><?php the_field('container_text_2');?></p>
        </div>
    </div>
</section>
<?php endif;?>

<!-- yellow -section -->
<section id="testimonal-section" class="about-testimonals section-md common-section <?php if(!get_field('container_text_2')){ echo "white"; }?>">
		<div class="container">
			<h4>أصدقاء البرنامج</h4>
			<h1>مين بيعتمد علي موازي؟</h1>
			<div class="items">
				<?php while(have_rows('testimonals', 6)): the_row();?>

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
					<?php $carousel = get_field('testimonals', 6);
							$carousel_rows =  count($carousel);
							$i = 0;
					?>
					<?php while($i < $carousel_rows):?>
						<li data-target="#carouselTestimonalsIndicators" data-slide-to="<?php echo $i;?>" class="<?php if($i==0){ echo 'active';}?>"></li>
						<?php $i++;
					endwhile;?>
				</ol>
				<div class="carousel-inner">
					<?php $i = 0; while(have_rows('testimonals', 6)): the_row();?>

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