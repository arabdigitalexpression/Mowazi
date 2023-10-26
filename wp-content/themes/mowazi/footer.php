</main>
	<footer class="mt-auto bg-blue <?php if ( is_page(3) ) {echo 'd-none';} ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<div class="footer-wrapper">
						<a href="<?php echo get_site_url(); ?>" class="logo" title="Mowazi" target="blank"><img src="<?php echo get_template_directory_uri() . '/images/logo-new.png';?>" alt="mowazi logo"></a>
						<a href="https://drosos.org/en" class="logo" title="drosos" target="blank"><img src="<?php echo get_template_directory_uri() . '/images/partners/drosos.png';?>" alt="drosos logo"></a>
						<a href="https://makouk.com/" class="logo" title="makouk" target="blank"><img src="<?php echo get_template_directory_uri() . '/images/partners/makouk.png';?>" alt="makouk logo"></a>
						 <?php get_template_part('navs/nav-archive'); ?>
					<form>
						<div class="form-group news">
							<label for="news">اشترك في موازي عبر البريد الإلكتروني</label>
							<input type="email" required class="form-control" name="news" id="news" aria-describedby="helpId" placeholder="البريد الإلكتروني"  
						data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-bv-emailaddress-message="هذا الحقل لا يمكن ان يكون فارغا">
							<button class="btn btn-primary" type="submit"> اشترك</button>
						</div>
					</form>
					</div>
				</div>
				<?php
				$contact_phone = get_post_meta( 6, 'mo_contact_number', true );
				$contact_email = get_post_meta( 6, 'mo_contact_email', true );
				$contact_fb = get_post_meta( 6, 'mo_contact_fb', true );
				$contact_tw = get_post_meta( 6, 'mo_contact_tw', true );
				$contact_in = get_post_meta( 6, 'mo_contact_in', true );
				$contact_insta = get_post_meta( 6, 'mo_contact_insta', true );
				?>
				<div class="col-md-3 offset-md-4 d-flex flex-wrap justify-flex-end">
					<div class="contact-side w-100">
						<p>تواصل معنا</p>
						<div class="contact-ways">
							<?php if ( !empty( $contact_phone ) ) { ?>
							<p><?php echo $contact_phone; ?></p>
							<?php } ?>

							<?php /*if ( !empty( $contact_email ) ) {*/ ?>
							<!-- <p><?php/* echo $contact_email;*/ ?></p> -->
							<?php /*}*/ ?>

							<ul class="list-unstyled soical-icons">
								<?php if ( !empty( $contact_fb ) ) { ?>
								<li><a href="<?php echo $contact_fb; ?>" target="blank"><i class="icon-logo-facebook"></i></a></li>
								<?php } ?>

								<!-- <?php if ( !empty( $contact_tw ) ) { ?>
								<li><a href="<?php echo $contact_tw; ?>" target="blank"><i class="icon-logo-twitter"></i></a></li>
								<?php } ?>

								<?php if ( !empty( $contact_in ) ) { ?>
								<li><a href="<?php echo $contact_in; ?>" target="blank"><i class="icon-logo-linkedin"></i></a></li>
								<?php } ?> -->

								<?php if ( !empty( $contact_insta ) ) { ?>
								<li><a href="<?php echo $contact_insta; ?>" target="blank"><i class="icon-fontello-instagram"></i></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<p class="copyright w-100 mt-auto">
						<a href="https://creativecommons.org/licenses/by-sa/4.0/deed.ar"><img src="<?php echo get_template_directory_uri().'/images/attribution_icon_white_x2.png';?>"></a>
						<a href="https://creativecommons.org/licenses/by-sa/4.0/deed.ar"><img src="<?php echo get_template_directory_uri().'/images/cc_icon_white_x2.png';?>"></a>
						<a href="https://creativecommons.org/licenses/by-sa/4.0/deed.ar"><img src="<?php echo get_template_directory_uri().'/images/sa_white_x2.png';?>"></a>
						<!-- <span>جميع الحقوق محفوظة لموازي <?php echo date('Y'); ?></span>	 -->
					</p>
				</div>

			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
	
	</body>
</html>