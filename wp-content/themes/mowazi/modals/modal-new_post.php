<?php global $tooltip_message;?>
<div class="modal fade new-content" id="NewPost" tabindex="-1" role="dialog" aria-labelledby="NewPost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4>محتوي جديد</h4>
            </div>

            <div class="modal-body">
                <div class="new-content_info">
                    <span><i class="icon-info"></i></span>
                    <p>هنا مساحة للتوثيق والمشاركة ! بنحكي عن أفكار و تجارب عملية وتعليمية مرينا بيها . وسيلة مساعدة  لتنظيم  و كتابة محتوى كامل، من البداية للنهاية</p>
                </div>

                <div class="post-content_tabs">
                    <p>اختار نوع المحتوي</p>
                    <div class="post-tabs" id="post-tab" role="tablist">
                        <div class="list-group flex-row">
                            <a class="btn post-tab_btn active show" data-toggle="tab" href="#articleContent" role="tab" aria-controls="article-content" >مدونات</a>
                            <a class="btn post-tab_btn" data-toggle="tab" href="#workshopContent" role="tab" aria-controls="workshop-content" >ورشة</a>
                            <a class="btn post-tab_btn" data-toggle="tab" href="#activityContent" role="tab" aria-controls="activity-content" >نشاط</a>
                            <a class="btn post-tab_btn" data-toggle="tab" href="#storyContent" role="tab" aria-controls="story-content" >حكاية</a>
                            <a class="btn post-tab_btn" data-toggle="tab" href="#gameContent" role="tab" aria-controls="game-content" >لعبة</a>
                        </div>

                        <!-- tab-content -->
                        <div class="tab-content">
                            <!-- articles  -->
                            <div class="tab-pane fade active show" id="articleContent" aria-labelledby="article-content" role="tabpanel">
                                <form id="formArticle" data-post="articles">
                                    <div class="form-group form-group_alt form-group-relative">
                                        <input type="text" name="title" class="form-control" placeholder="العنوان" aria-describedby="postTitle" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                       <?php $tooltip_message = 'هذا الحقل لا يمكن ان يكون فارغا'; ?>
                                       <?php get_template_part('templates/content-tooltip');?>
                                        <!-- <div class="field-info-popup">
                                            <span class="triangle"></span>
                                            <p>هذا الحقل لا يمكن ان يكون فارغا</p>
                                        </div> -->
                                    </div>
                                    <div class="form-group form-group_alt form-group_select2Ajax form-group_expand form-group-relative">
                                        <select style="width:100%;" name="articleTags" id="articleTags" class="form-control"
                                                multiple="multiple" data-placeholder="الوسوم" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        </select>
                                        <small class="subtitle-secondary">زودو فصلة بعد الوسم او دوسو انتر</small>
                                        <?php $tooltip_message = 'لا يمكن ان يكون فارغا'; ?>
                                       <?php get_template_part('templates/content-tooltip');?>
                                    </div>
                                    <!-- <div class="form-group form-group_alt ">
                                        <textarea class="form-control" name="goals" placeholder="الاهداف" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                    </div> -->
                                </form>
                            </div>
                            <!-- End of articles  -->

                            <!-- workshop  -->
                            <div class="tab-pane" id="workshopContent" aria-labelledby="workshop" role="tabpanel">
                                <form id="formWorkshop" data-post="workshops">
                                    <div class="form-group form-group_alt">
                                        <input type="text" name="title" class="form-control" placeholder="العنوان" aria-describedby="postTitle" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                    </div>
                                    <div class="form-group form-group_alt form-group_select2Ajax form-group_expand">
                                        <select style="width:100%;" name="workshopTags" id="workshopTags" class="form-control"
                                                multiple="multiple" data-placeholder="الوسوم" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group form-group_alt">
                                                <label for="participants">عدد المشاركين</label>
                                                <div class="participantsContainer">
                                                    <div class="participantsContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-users"></i>
                                                            <select style="width: 100%;" name="participants" data-placeholder="الحد الأدنى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="participantsContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-users"></i>
                                                            <select style="width: 100%;" name="maxParticipants" data-placeholder="الحد الأقصى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group_alt">
                                                <label for="age">السن</label>
                                                <div class="form-group_post">
                                                    <i class="icon-icon-group"></i>
                                                    <select style="width: 100%;" name="age" data-placeholder="السن" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                        <option></option>
                                                        <?php foreach ( mo_generate_age_range() as $key => $value ) { ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group_alt">
                                                <label for="duration">التوقيت</label>
                                                <div class="durationContainer">
                                                    <div class="durationContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-clock"></i>
                                                            <select style="width: 100%;" name="durationHrs" data-placeholder="ساعة" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_duration_range_hrs() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="durationContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-clock"></i>
                                                            <select style="width: 100%;" name="durationMin" data-placeholder="دقائق " data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group form-group_alt ">
                                        <textarea class="form-control" name="goals" placeholder="الاهداف" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                    </div>

                                    <?php 
                                        $activities = get_posts(
                                            array(
                                            'post_type'         =>  'activities',
                                            'post_status'       =>  'publish',
                                            'posts_per_page'    =>  -1,
                                            // 'post_parent'       =>  0,
                                            'fields'            =>  'ids',
                                            'include_children'  =>  true,
                                            )
                                        );
                                    ?>
                                    <!-- workshop activities -->
                                    <div class="form-group form-group_alt form-group_select2AjaxActivities form-group_expand">

                                    <select multiple="multiple" style="width: 100%;" name="workshopActivities" data-placeholder="الانشطة " data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        <option></option>
                                        <?php
                                            foreach($activities as $key => $activity_id):
                                                $activity_title = get_the_title($activity_id);
                                            ?>
                                            <option data-activity-id = "<?php echo $activity_id; ?>" 
                                            value="<?php echo $activity_id; ?>">
                                                <?php echo $activity_title; ?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>


                                        <!-- <select style="width:100%;" name="workshopActivities" id="workshopActivities" class="form-control"
                                                multiple="multiple" data-placeholder="الانشطة" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                            <?php
                                            // foreach($activities as $key => $activity_id):
                                            //     $activity_title = get_the_title($activity_id);
                                            ?>
                                            <option data-activity-id = "<?php //echo $activity_id; ?>" 
                                            value="<?php //echo $activity_title; ?>">
                                                <?php //echo $activity_title; ?>
                                            </option>
                                            <?php //endforeach;?>
                                        </select> -->
                                    </div>

                                </form>
                            </div>
                            <!-- workshop  -->

                            <!-- activity  -->
                            <div class="tab-pane" id="activityContent" aria-labelledby="activity" role="tabpanel">
                                <form id="formActivity" data-post="activities">
                                    <div class="form-group form-group_alt">
                                        <input type="text" name="title" class="form-control" placeholder="العنوان" aria-describedby="postTitle" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                    </div>
                                    <div class="form-group form-group_alt form-group_select2Ajax form-group_expand">
                                        <select style="width:100%;" name="activityTags" id="activityTags" class="form-control"
                                                multiple="multiple" data-placeholder="الوسوم" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        </select>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group form-group_alt">
                                                <label for="participants">عدد المشاركين</label>
                                                <div class="participantsContainer">
                                                    <div class="participantsContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-users"></i>
                                                            <select style="width: 100%;" name="participants" data-placeholder="الحد الأدنى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    <div class="participantsContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-users"></i>
                                                            <select style="width: 100%;" name="maxParticipants" data-placeholder="الحد الأقصى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group_alt">
                                                <label for="age">السن</label>
                                                <div class="form-group_post">
                                                    <i class="icon-icon-group"></i>
                                                    <select style="width: 100%;" name="age" data-placeholder="السن" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                        <option></option>
                                                        <?php foreach ( mo_generate_age_range() as $key => $value ) { ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group form-group_alt">
                                                <label for="duration">التوقيت</label>
                                                <div class="durationContainer">
                                                    <div class="durationContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-clock"></i>
                                                            <select style="width: 100%;" name="durationHrs" data-placeholder="ساعة" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_duration_range_hrs() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="durationContainer-content">
                                                        <div class="form-group_post">
                                                            <i class="icon-icon-clock"></i>
                                                            <select style="width: 100%;" name="durationMin" data-placeholder="دقائق " data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                                <option></option>
                                                                <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group_alt ">
                                        <textarea class="form-control" name="goals" placeholder="الاهداف" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                    </div>
                                </form>
                            </div>
                            <!-- activity  -->
                            <!-- story  -->
                            <div class="tab-pane" id="storyContent" aria-labelledby="story" role="tabpanel">
                                <form id="formStories" data-post="stories">
                                    <div class="form-group form-group_alt">
                                        <input type="text" name="title" class="form-control" placeholder="العنوان" aria-describedby="postTitle" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                    </div>
                                    <div class="form-group form-group_alt form-group_select2Ajax form-group_expand">
                                        <select style="width:100%;" name="storyTags" id="storyTags" class="form-control"
                                                multiple="multiple" data-placeholder="الوسوم" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        </select>
                                    </div>
                                    <div class="form-group form-group_alt ">
                                        <textarea class="form-control" name="goals" placeholder="الاهداف" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                    </div>
                                </form>
                            </div>
                            <!-- story  -->
                            <!-- game  -->
                            <div class="tab-pane" id="gameContent" aria-labelledby="game" role="tabpanel">
                                <form id="formGames" data-post="games">
                                    <div class="form-group form-group_alt">
                                        <input type="text" name="title" class="form-control" placeholder="العنوان" aria-describedby="postTitle" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                    </div>
                                    <div class="form-group form-group_alt form-group_select2Ajax form-group_expand">
                                        <select style="width:100%;" name="gameTags" id="gameTags" class="form-control"
                                                multiple="multiple" data-placeholder="الوسوم" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                        </select>
                                    </div>
                                    <div class="form-group form-group_alt ">
                                        <textarea class="form-control" name="goals" placeholder="الاهداف" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                                    </div>
                                </form>
                            </div>
                            <!-- game  -->
                        </div>
                        <!-- end tab-content -->

                    </div>
                </div>

            </div>
            <!-- end modal-body -->

            <div class="model-footer">
                <div class="open-sources">
                    <i class="icon-unlock"></i>
                    <p>المحتوي كله علي موازي محتوي جماعي مفتوح للجميع</p>
                </div>
                <div>
                    <a href="#" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">إلغاء</a>
                    <a href="#" class="btn btn-primary create-post">إنشاء</a>
                </div>
            </div>

        </div>
    </div>
</div>