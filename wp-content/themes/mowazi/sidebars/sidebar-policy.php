<div class="sidebar-policy">
    <a href="<?php echo get_site_url(); ?>" class="logo" title="Mowazi" alt="logo"></a>

    <?php
    $contact_phone = get_post_meta( 6, 'mo_contact_number', true );
    $contact_email = get_post_meta( 6, 'mo_contact_email', true );
    $contact_fb = get_post_meta( 6, 'mo_contact_fb', true );
    $contact_tw = get_post_meta( 6, 'mo_contact_tw', true );
    $contact_in = get_post_meta( 6, 'mo_contact_in', true );
    $contact_insta = get_post_meta( 6, 'mo_contact_insta', true );
    ?>
    <div class="contact-side">
        <div class="contact-ways">
            <p>تواصل معنا</p>
            <?php if ( !empty( $contact_phone ) ) { ?>
            <p><?php echo $contact_phone; ?></p>
            <?php } ?>

            <?php if ( !empty( $contact_email ) ) { ?>
            <p><?php echo $contact_email; ?></p>
            <?php } ?>

            <ul class="list-unstyled soical-icons">
                <?php if ( !empty( $contact_fb ) ) { ?>
                <li><a href="<?php echo $contact_fb; ?>" target="blank"><i class="icon-logo-facebook"></i></a></li>
                <?php } ?>

                <?php if ( !empty( $contact_tw ) ) { ?>
                <li><a href="<?php echo $contact_tw; ?>" target="blank"><i class="icon-logo-twitter"></i></a></li>
                <?php } ?>

                <?php if ( !empty( $contact_in ) ) { ?>
                <li><a href="<?php echo $contact_in; ?>" target="blank"><i class="icon-logo-linkedin"></i></a></li>
                <?php } ?>

                 <?php if ( !empty( $contact_insta ) ) { ?>
                <li><a href="<?php echo $contact_insta; ?>" target="blank"><i class="icon-fontello-instagram"></i></a></li>
                <?php } ?>
            </ul>
        </div>
        <p class="copyright">جميع الحقوق محفوظة لموازي 2020</p>
    </div>
</div>