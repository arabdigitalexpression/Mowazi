<?php
global $entry_id;

$post_type = get_post_type( $entry_id );
$color = str_replace( ' ', '', get_post_meta( $entry_id, 'mo_entry_color', true ) );
$target = get_post_meta( $entry_id, 'mo_entry_target', true );
$title = get_the_title( $entry_id );
$i=0;
$steps = get_post_meta( $entry_id, 'mo_entry_group', true );
?>
<div class="workshop_partition_content <?php echo $color; ?>" id="<?php echo $target; ?>" data-post="<?php echo $entry_id; ?>">
    <div class="header handle">
        <div>
            <a href="#"><i class="icon-drag"></i></a>
            <span><?php if ( $post_type == 'workshops' ) { echo $title; } else { echo 'نشاط'; } ?></span>
            <!-- <input class="workshop_partition_content--title" type="text" placeholder=<?php if ( $post_type == 'workshops' ) { echo $title; } else { echo 'نشاط'; } ?> value="<?php if ( $post_type == 'workshops' ) { echo $title; } else { echo 'نشاط'; } ?>"> -->
        </div>
        <div>
            <button onclick="toggleExpand(this)" class="expand-collapse-component"><i class="icon-notes"></i>expand/collapse item</button>
            <a href="#notesSidebar"><i class="icon-notes"></i></a>
            <a href="#commentsSidebar"><i class="icon-comment"></i></a>
            <a href="#materialSidebar"><i class="icon-material"></i></a>
            <a href="#attachesSidebar"><i class="icon-sources-alt"></i></a>       
            <a href="#" title="delete entry" class="delete-entry"><i class="icon-delete"></i></a>
        </div>
    </div>
    <div class="workshop-content">
        <div class="p-0">
            <div class="hyperlink">
                <div>  
                    <input type="text" name="hyperlink">
                    <button class="attach"><i class="icon-attach-alt"></i></button>
                </div>
            </div>
            <form data-bv-live="disabled">
                <?php
                if ( !empty( $steps ) ) {
                    $step_count = 0;
                    foreach ( $steps as $step ) {
                       $step_count++;
                       $step_title = $step_desc = $step_duration = $step_note = '';

                       if ( isset( $step['title'] ) ) {
                           $step_title = $step['title'];
                       }

                       if ( isset( $step['desc'] ) ) {
                           $step_desc = $step['desc'];
                       }

                       if ( isset( $step['duration'] ) ) {
                           $step_duration = $step['duration'];
                       }

                       if ( isset( $step['note'] ) ) {
                        $step_note = $step['note'];
                    }
                ?>
                <div class="row no-gutters">
                    <div class="col-md-1 d-flex justify-content-center align-items-center flex-column">
                        <?php if ( $step_count > 1 ) { ?>
                        <a href="#" title="delete row" class="delete-row"><i class="icon-delete"></i></a>
                        <?php } ?>
                        <a class="incMin" href="#"><i class="icon-plus"></i></a>
                        <div class="form-group">
                            <input type="text" class="form-control workshop-input workshop-input_number" maxlength="3" name="<?php echo 'time_' . $step_count . '_' . $target; ?>" value="<?php echo $step_duration; ?>" placeholder="0" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                        </div>
                        <a class="decMin" href="#"><i class="icon-minus"></i></a>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <textarea class="form-control workshop-input workshop-input_title" name="<?php echo 'title_' . $step_count . '_' . $target; ?>" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"><?php echo $step_title; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea class="form-control workshop-input workshop-input_content" name="<?php echo 'content_' . $step_count . '_' . $target; ?>" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" id="workshop-textarea_<?php echo $i; $i++; ?>"><?php echo $step_desc; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <textarea class="form-control workshop-input workshop-input_notes" name="<?php echo 'note_' . $step_count . '_' . $target; ?>"><?php echo $step_note; ?></textarea>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </form>

            <div class="row no-gutters default">
                <div class="col-md-1"><input class="form-control workshop-input workshop-input_number" placeholder="0"></div>
                <div class="col-md-3"><textarea class="form-control workshop-input workshop-input_title" placeholder="عنوان"></textarea></div>
                <div class="col-md-6"><textarea class="form-control workshop-input workshop-input_content" placeholder="تفاصيل" id="workshop-textarea_<?php echo $i; $i++; ?>" ></textarea></div>
                <div class="col-md-2"><textarea class="form-control workshop-input workshop-input_notes" placeholder="ملاحظات"></textarea></div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    function toggleExpand(elem){
        elem.parentElement.parentElement.parentElement.classList.toggle('expand-workshop-component');
    }
</script>