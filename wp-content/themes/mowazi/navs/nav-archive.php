<ul class="nav nav-archive">
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('articles')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('articles'); ?>" title="مقال" data-archive="articles">مدونات</a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('workshops')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('workshops'); ?>" title="ورشة" data-archive="workshops">ورش</a>
    </li> -->
    <li class="nav-item dropdown">
        <button class="nav-link dropdown-toggle <?php //if (is_post_type_archive('activities')) { echo 'active'; } ?>" 
        id="activitesMenuButton"
        type="button"
        data-toggle="dropdown" aria-haspopup="true" 
        aria-expanded="false"
         title="انشطة">انشطة</button>

         <div class="dropdown-menu" aria-labelledby="activitesMenuButton">
            <a class="dropdown-item nav-link <?php if (is_post_type_archive('activities')) { echo 'active'; }?> " href="<?php echo get_post_type_archive_link('activities'); ?>" data-archive="activities">انشطة</a>
            <a class="dropdown-item nav-link <?php if (is_post_type_archive('workshops')) { echo 'active'; }?>" href="<?php echo get_post_type_archive_link('workshops'); ?>" data-archive="workshops">ورش</a>
            <a class="dropdown-item nav-link <?php if (is_post_type_archive('games')) { echo 'active'; }?>" href="<?php echo get_post_type_archive_link('games'); ?>" data-archive="games">ألعاب</a>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('stories')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('stories'); ?>" title="حكاية" data-archive="stories">حكايات</a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('games')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('games'); ?>" title="لعبة" data-archive="games">ألعاب</a>
    </li> -->
    <li class="nav-item show-for-footer-only">
        <a class="nav-link" href="<?php echo get_permalink(6396); ?>" title="عن موازي">عن موازي</a>
    </li>
    <li class="nav-item show-for-footer-only yellow">
        <a class="nav-link" href="<?php echo get_permalink(3); ?>" title="الشروط والأحكام">الشروط والأحكام</a>
    </li>
</ul>