<?php

global $post_type;

$tags = get_tags( array(
    'orderby'   =>  'count',
    'order'     =>  'DESC'
) );

$duration="";
$age_range="";
$participants="";
$post_type_filter="";

// $params = array(
// );

if($_GET['participants']){
    $participants = $_GET['participants'];
    // $params['participants'] = $participants;
}
if($_GET['age_range']){
    $age_range = $_GET['age_range'];
    // $params['age_range'] = $age_range;
}
if($_GET['duration']){
    $duration = $_GET['duration'] ;
    // $params['duration'] = $duration;
}
if($_GET['post_type_filter']){
    $post_type_filter = $_GET['post_type_filter'] ;
    // $params['post_type'] = $post_type;
}

function getArabicPostType($type){
    switch($type){
        case 'articles':
            echo 'مدونات';
            break;
        case 'stories':
            echo 'حكايات';
            break;
        case 'workshops':
             echo 'ورش';
             break;
        case 'activities': 
            echo 'انشطة';
            break;
        case 'games': 
            echo 'ألعاب';
            break;
        case 'users': 
            echo 'الاشخاص';
            break;
        case 'groups':
            echo 'المجموعات';
            break;
        // default: echo $type;
    }
}


if ( !empty( $tags ) ) {
?>
<div class="sidebar-sticky">
    <!-- select2 filters -->
    <div class="filters-container">
        <?php if($post_type_filter || $participants || $age_range || $duration): ?>
            <a href="#" class="cancel-filters" onclick="removeAllFilters();">إلغاء التصفية </a>
        <?php endif;?>
        <?php if(!$post_type):?>
        <div class="dropdown filter-postTypes filter-item select2-item">
            <i class="icon-icon-users"></i>
            <div class="form-group">
                <label for="filterPostTypes">البحث في</label>
                <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($post_type_filter): 
                        echo getArabicPostType($post_type_filter);
                    else:?>
                الكل
                <?php endif;?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="filterPostTypes">
                    <a href="#" class="dropdown-item <?php if($post_type_filter == ''){ echo 'active';}?>" onclick="removeFilter('post_type_filter');" >الكل</a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "articles"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs('articles' , 'post_type_filter');">
                        <?php echo 'مدونات'; ?>
                    </a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "workshops"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs('workshops' , 'post_type_filter');">
                        <?php echo 'ورش'; ?>
                    </a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "activities"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs('activities' , 'post_type_filter');">
                        <?php echo 'انشطة'; ?>
                    </a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "stories"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs('stories' , 'post_type_filter');">
                        <?php echo 'حكايات'; ?>
                    </a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "games"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs( 'games', 'post_type_filter');">
                        <?php echo 'ألعاب'; ?>
                    </a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "users"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs( 'users', 'post_type_filter');">
                        <?php echo 'الاشخاص'; ?>
                    </a>
                    <a class="dropdown-item  <?php 
                    if($post_type_filter == "groups"){ echo 'active';}?>" href="#<?php 
                    ?>" onclick="setURLs( 'groups', 'post_type_filter');">
                        <?php echo 'المجموعات'; ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif;?>

    <?php //if($post_type != 'articles'):?>
        <div class="dropdown filter-participants filter-item select2-item">
            <i class="icon-icon-users"></i>
            <div class="form-group">
                <label for="filterParticipants">عدد المشاركين</label>
                <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($participants): 
                        echo $participants;
                    else:?>
                    الكل
                <?php endif;?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="filterParticipants">
                    <a href="#" class="dropdown-item <?php if($participants == ''){ echo 'active';}?>" onclick="removeFilter('participants');" >الكل</a>
                    <?php foreach (mo_generate_participants_range() as $key => $value ) { ?>
                        <a class="dropdown-item  <?php 
                        if($participants == $key){ echo 'active';}?>" href="#<?php 
                        
                        // add_query_arg(array('participants' => $key), site_url("/home"));
                         ?>" onclick="setURLs(<?php echo $key; ?> , 'participants');">
                            <?php echo $value; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php //endif;?>

        <div class="dropdown select2-item filter-age filter-item">
            <i class="icon-icon-group"></i>
            <div class="form-group">
                <label for="filterAge"> السن</label>
                <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($age_range):
                        echo $age_range;
                    else:
                        ?>
                    الكل
                    <?php endif;?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="filterAge">
                    <a href="#" class="dropdown-item <?php if($age_range == ''){ echo 'active';}?>" onclick="removeFilter('age_range');" >الكل</a>
                    <?php foreach ( mo_generate_age_range() as $key => $value ) { ?>
                        <a class="dropdown-item   <?php 
                        if($age_range == $key){ echo 'active';}?>" href="#<?php 
                            // echo add_query_arg(array('age_range' => $key), site_url("/home")); ?>" 
                            onclick="setURLs(`<?php echo $key; ?>` , 'age_range');"
                            >
                            <?php echo $value; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

    <?php //if($post_type != 'articles'):?>
        <div class="dropdown select2-item filter-time filter-item">
        <i class="icon-icon-clock"></i>
            <div class="form-group">
                <label for="filterTime">التوقيت</label>
                <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($duration):
                        echo $duration;
                    else:
                        ?>
                    الكل
                <?php endif;?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="filterTime">
                    <a href="#" class="dropdown-item <?php if($duration == ''){ echo 'active';}?>" onclick="removeFilter('duration');" >الكل</a>
                    <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                        <a class="dropdown-item  <?php 
                        if($duration == $key){ echo 'active';}?>" href="#<?php 
                            // echo add_query_arg(array('duration' => $key), site_url("/home")); ?>"
                            onclick="setURLs(<?php echo $key; ?> , 'duration');"
                            >
                            <?php echo $value; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php //endif;?>

        <!-- select2 filters -->
        <!-- <div class="select2-item">
            <i class="icon-icon-clock"></i>
            <div class="form-group form-group_search__filter">
                <label for="filterTime">التوقيت</label>
                <select class="filter-select2" style="width: 100%;" name="duration" id="filterTime" data-placeholder="التوقيت">
                    <option></option>
                    <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                    <option value="<?php echo $key; ?>" onclick="setURLs(<?php echo $key; ?> , 'duration');" ><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div> -->
        <!-- <button class="btn btn-primary btn-sm" type="submit">filter</button> -->
    </div>

    

    <div class="tags-container">
        <h3>#الوسوم</h3>

        <?php foreach ($tags as $tag) {
            $count = $tag->count;
            if($count >= 50){ ?>
                <a class="btn tag" href="<?php echo get_term_link($tag->term_id); ?>" data-t="<?php echo $tag->term_id; ?>" title="<?php echo $tag->name; ?>">
                    <span><?php echo $tag->name; ?></span>
                    <span>(<?php echo $count; ?>)</span>
                </a>
            <?php }
        } ?>

    </div>
</div>
<?php } ?>

<script type="text/javascript">

function myAjax(key) {
      jQuery.ajax({
           type: "POST",
           url: 'http://localhost:8888/mowazi/wp-content/themes/mowazi/filters.php',
           data:{action:'call_this', newKey: key},
           success:function(html) {
            //  alert(key);
           }

      });
 }
 function setURLs(key, type){
    let url =  new URL(window.location.href);
    url.searchParams.set(type,key);
    window.location.href= url;
 }
 function removeAllFilters(){
    let url =  new URL(window.location.href);
    let keyword = url.searchParams.get('k');
    var url2 = new URL(window.location.href.split('?')[0]);
	if(keyword){
		url2.searchParams.set('k', url.searchParams.get('k') );
	}
    window.location.href = url2;
 }
 function removeFilter(type){
    let url =  new URL(window.location.href);
    url.searchParams.delete(type);
    window.location.href = url;
 }
</script>