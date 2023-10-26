<?php
global $post_id;

if ( !$post_id ) {
    $post_id = $wp_query->get_queried_object()->ID;
}

$post_type = get_post_type($post_id);

$post_title = get_the_title( $post_id );
$post_title = str_replace( 'Private: ', '', $post_title );
$post_title = str_replace( 'خاص: ', '', $post_title );

if (!$post_title) {
    $post_title = 'ماذا تعرف عن منهج مونتيسوري التعليمي ؟';
}
?>
<!-- header  -->
<header class="main-header header-post">

        <div class="container-fluid p-0">

            <div class="container-post-wrapper">

                <div class="container-post__right_side">
                    <a href="<?php echo get_site_url(); ?>" class="logo" title="Mowazi"><img src="<?php echo get_template_directory_uri() . '/images/logo-black.svg';?>" alt="mowazi logo"></a>
                </div>

                <div class="container-post__center">
                    <div class="form-group form-group_alt_post">
                      <input type="text" value="<?php echo $post_title; ?>" name="title" class="form-control" placeholder="العنوان">
                    </div>
                </div>

                <div class="container-post__left_side">
                   <!--  <a href="#" class="btn btn-outline-blue">
                        <i class="icon-download"></i>
                        <span>تنزيل</span>
                    </a> -->
                    <?php if(function_exists('mpdf_pdfbutton')) 
                        mpdf_pdfbutton(true, '<i class="icon-download"></i> <span>تنزيل</span>'); ?>

                    <a href="#" class="btn btn-outline-blue publish-post" data-draft="1" data-post="<?php echo $post_id; ?>">
                        <i class="icon-preview"></i>
                        <span>حفظ ومعاينة</span>
                    </a>

                    <a href="#editWorkShop" data-toggle="modal" class="btn btn-primary">
                        <i class="icon-upload"></i>
                        <span>أنشر</span>    
                    </a>
                </div>

            </div>
        </div>

</header>
<!-- end of header  -->