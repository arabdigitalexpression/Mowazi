<!-- header  -->
<header class="main-header">
    <div class="container-fluid">
        <div class="header-wrapper">
            <a href="<?php echo get_site_url(); ?>" class="logo" title="Mowazi"><img src="<?php echo get_template_directory_uri() . '/images/logo-new.png';?>" alt="mowazi logo"></a>
            
            <!-- archives -->
            <?php get_template_part('navs/nav-archive'); ?>
            
            <!-- search form -->
            <?php get_template_part('templates/content-search_form'); ?>
            <!-- end search form -->
            
            <div>
                <a class="btn btn-outline-blue2" href="<?php echo get_permalink(10); ?>" data-page="10">تسجيل الاشتراك</a>
                <a class="btn btn-primary" href="<?php echo get_permalink(8); ?>" data-page="8">تسجيل الدخول</a>
                
            </div>
        </div>
    </div>
</header>
    <!-- end of header  -->