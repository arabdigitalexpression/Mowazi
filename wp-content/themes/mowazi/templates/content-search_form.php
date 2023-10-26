<?php global $keyword;
?>
<form id="formSearch" class="form logged-in" data-bv-onsuccess="getSearch">
    <div class="form-group form-group_search">
        <!-- <input class="form-control" type="search" name="keyword" placeholder="دور علي طرق تعلم، مناهج، افكار، تعميق…" aria-label="Search" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"> -->
        <input class="form-control" type="search" name="keyword" placeholder="دور على مناهج، انشطة، طرق تعلم، أفكار للورش ...
" aria-label="Search" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" value="<?php if($keyword){ echo $keyword; }?>">

        <button class="btn btn-search" type="submit">
            <i class="icon-icon-search">
            </i>
            <span class="sr-only">ابحث</span>
        </button>
        
        <!-- <a class="filter-search" href="#" role="button" id="dropdownMenuSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-tringle-down">
            </i>
        </a> -->
        <div class="tag-container">

        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuSearch">
            <!-- check list -->
            <div class="custom-control custom-checkbox w-100">
                <input type="checkbox" class="custom-control-input" value="all" id="all">
                <label class="custom-control-label" for="all" name="filterType">الكل</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="workshops" name="filterType" id="workshops">
                <label class="custom-control-label" for="workshops">ورشة</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="activities" name="filterType" id="activities">
                <label class="custom-control-label" for="activities">نشاط</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="games" name="filterType" id="games">
                <label class="custom-control-label" for="games">لعبة</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="stories" name="filterType" id="stories">
                <label class="custom-control-label" for="stories">حكاية</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="articles" name="filterType" id="articles">
                <label class="custom-control-label" for="articles">مقال</label>
            </div>
            <!-- end Check list -->
            <!-- select2 filters -->
            <div class="select2-item">
                <i class="icon-icon-users"></i>
                <div class="form-group form-group_search__filter">
                    <label for="filterNumbers">عدد المشاركين</label>
                    <select class="filter-select2" style="width: 100%;" name="participants" id="filterNumbers" data-placeholder="الكل">
                        <option></option>
                        <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- select2 filters -->
            <div class="select2-item">
                <i class="icon-icon-group"></i>
                <div class="form-group form-group_search__filter">
                    <label for="filterAge">السن</label>
                    <select class="filter-select2" style="width: 100%;" name="age" id="filterAge" data-placeholder="السن">
                        <option></option>
                        <?php foreach ( mo_generate_age_range() as $key => $value ) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- select2 filters -->
            <div class="select2-item">
                <i class="icon-icon-clock"></i>
                <div class="form-group form-group_search__filter">
                    <label for="filterTime">التوقيت</label>
                    <select class="filter-select2" style="width: 100%;" name="duration" id="filterTime" data-placeholder="التوقيت">
                        <option></option>
                        <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary btn-sm" type="submit">أبحث</button>


        </div>
    </div>  
</form>