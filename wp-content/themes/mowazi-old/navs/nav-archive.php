<ul class="nav">
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('articles')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('articles'); ?>" title="مقال" data-archive="articles">مدونات</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('workshops')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('workshops'); ?>" title="ورشة" data-archive="workshops">ورش</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('activities')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('activities'); ?>" title="نشاط" data-archive="activities">انشطة</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('stories')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('stories'); ?>" title="حكاية" data-archive="stories">حكايات</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if (is_post_type_archive('games')) { echo 'active'; } ?>" href="<?php echo get_post_type_archive_link('games'); ?>" title="لعبة" data-archive="games">ألعاب</a>
    </li>
    <li class="nav-item show-for-footer-only">
        <a class="nav-link" href="<?php echo get_permalink(3); ?>" title="الشروط والأحكام">الشروط والأحكام</a>
    </li>
</ul>