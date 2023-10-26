<?php
global $post_id;
global $user_id;

$post_title = get_the_title( $post_id );
$post_title = str_replace( 'Private: ', '', $post_title );
$post_title = str_replace( 'خاص: ', '', $post_title );

$post_participants = get_post_meta( $post_id, 'mo_workshop_activity_participants', true );
$post_max_participants = get_post_meta( $post_id, 'mo_workshop_activity_max_participants', true );
$post_age = get_post_meta( $post_id, 'mo_workshop_activity_age', true );
$post_duration_hrs = get_post_meta( $post_id, 'mo_workshop_activity_duration_hrs', true );
$post_duration = get_post_meta( $post_id, 'mo_workshop_activity_duration', true );
$post_location = get_post_meta( $post_id, 'mo_workshop_location', true );
$post_goals = get_post_meta( $post_id, 'mo_workshop_goals', true );
$post_collaborators = get_post_meta( $post_id, 'mo_workshop_collaborators', true );
$post_sharewith = get_post_meta( $post_id, 'mo_workshop_shared_with', true );
$user_groups = get_user_meta( $user_id, 'user_groups', true );
$post_tags = wp_get_post_tags( $post_id, array(
    'taxonomy'  =>  'tags',
    'fields'    =>  'id=>name'
) );

$post_type = get_post_type( $post_id );
?>
 <!-- Modal new group -->
 <div class="modal fade new-content new-workshop" id="editWorkShop" tabindex="-1" role="dialog" aria-labelledby="editWorkShop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

        <div class="modal-header">
                <h5 class="modal-title">محتوي جديد</h5>
            </div>

            <div class="modal-body">
                <form id="formPublishWorkshop" data-bv-onsuccess="publishWorkshop" data-post="<?php echo $post_id; ?>">

                    <div class="form-group form-group_alt">
                        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>" placeholder="العنوان" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                    </div>

                    <div class="form-group form-group_alt form-group_select2Ajax form-group_expand">
                        <select style="width:100%;" name="tags" id="tags" class="form-control"
                                multiple="multiple" data-placeholder="الوسوم" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                <?php
                                if ( !empty( $post_tags ) ) {
                                    foreach ( $post_tags as $post_tag_id => $post_tag_name ) {
                                ?>
                                <option value="<?php echo $post_tag_id; ?>" data-name="<?php echo $post_tag_name; ?>" selected><?php echo $post_tag_name; ?></option>
                                <?php } } ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 <?php if($post_type == 'articles') { echo 'd-none';} ?>" >
                            <div class="form-group form-group_alt">
                                <label for="participants">عدد المشاركين</label>
                                <div class="participantsContainer">
                                    <div class="participantsContainer-content">
                                        <div class="form-group_post">
                                            <i class="icon-icon-users"></i>
                                            <select style="width: 100%;" name="participants" data-placeholder="الحد الأدنى" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                <option></option>
                                                <?php foreach ( mo_generate_participants_range() as $key => $value ) { ?>
                                                <option value="<?php echo $key; ?>" <?php if ( $key == $post_participants ) { echo 'selected'; } ?>><?php echo $value; ?></option>
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
                                               <option value="<?php echo $key; ?>" <?php if ( $key == $post_max_participants ) { echo 'selected'; } ?>><?php echo $value; ?></option>
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
                                        <option value="<?php echo $key; ?>" <?php if ( $key == $post_age ) { echo 'selected'; } ?>><?php echo $value; ?></option>
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
                                                <option value="<?php echo $key; ?>" <?php if ( $key == $post_duration_hrs ) { echo 'selected'; } ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="durationContainer-content">
                                        <div class="form-group_post">
                                            <i class="icon-icon-clock"></i>
                                            <select style="width: 100%;" name="durationMin" data-placeholder="دقائق" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                                                <option></option>
                                                <?php foreach ( mo_generate_duration_range() as $key => $value ) { ?>
                                                <option value="<?php echo $key; ?>" <?php if ( $key == $post_duration ) { echo 'selected'; } ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="form-group form-group_alt ">
                        <input type="text" class="form-control" name="location" value="<?php echo $post_location; ?>" placeholder="المكان" data-bv-notempty="false" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                    </div>
                    
                    <!-- hiding option to add goals while creating articles -->
                    <?php if($post_type != 'articles'): ?>
                    <div class="form-group form-group_alt ">
                        <textarea class="form-control" name="goals" placeholder="الاهداف" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"><?php echo $post_goals; ?></textarea>
                    </div>
                    <?php endif;?>
                    <!-- hiding option to add goals while creating articles -->


                    <div class="form-group form-group_alt form-group-member">
                        <label for="collaborators">قائمة الشركاء في المشروع</label>
                        <select style="width:100%;" name="collaborators" class="form-control bg-white" multiple="multiple" data-placeholder="إدراج أسماء أو عناوين البريد الإلكتروني">
                            <?php
                            if ( !empty( $post_collaborators ) ) {
                                foreach ($post_collaborators as $collaborator) {
                                    $collaborator_first_name = get_user_meta( $collaborator, 'first_name', true );
                                    $collaborator_last_name = get_user_meta( $collaborator, 'last_name', true );
                                    $collaborator_fullname = $collaborator_first_name . ' ' . $collaborator_last_name;
                                    $collaborator_profile_avatar = wp_get_attachment_image_url( get_user_meta( $collaborator, 'user_img_id', 1 ), 'avatar-xxs' );

                                    if ( !$collaborator_profile_avatar ) {
                                        $collaborator_profile_avatar = get_template_directory_uri() . '/images/logo-sm.svg';
                                    }
                            ?>
                            <option value="<?php echo $collaborator; ?>" data-name="<?php echo $collaborator_fullname; ?>" data-url="<?php echo $collaborator_profile_avatar; ?>" selected></option>
                            <?php } } ?>
                        </select>
                        <i class="icon-icon-users"></i>
                    </div>

                    <div class="form-group form-group_alt form-group_alt_full">
                        <label for="sharewith">مشاركة المحتوي مع</label>
                        <select style="width:100%;" name="sharewith" class="form-control bg-white" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-placeholder="الجميع او مجموعة">
                            <option></option>
                            <option value="all" <?php if ( !empty( $post_sharewith ) && $post_sharewith == 'all' ) { echo 'selected'; } ?>>الجميع</option>
                            <?php
                            if ( !empty( $user_groups ) ) {
                                foreach ($user_groups as $group_id) {
                            ?>
                            <option value="<?php echo $group_id; ?>" <?php if ( !empty( $post_sharewith ) && $post_sharewith == $group_id ) { echo 'selected'; } ?>><?php echo get_the_title( $group_id ); ?></option>
                            <?php } } ?>
                        </select>
                        <i class="icon-unlock"></i>
                    </div>

                    <div class="model-footer">
                        <div>
                            <i class="icon-copyright"></i>
                            <p>
                            المحتوي المنشور لابد ان يطابق <a href="<?php echo get_permalink(3); ?>" style="text-decoration: underline;" target="_blank">الشروط والاحكام</a>
                            </p>
                        </div>
                        <div>
                            <a href="#" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">إلغاء</a>
                            <button type="submit" class="btn btn-primary publish-workshop">نشر</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>