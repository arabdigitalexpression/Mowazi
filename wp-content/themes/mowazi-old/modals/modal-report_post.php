<!-- Modal -->
<div class="modal fade reason-model" id="reportPost" tabindex="-1" role="dialog" aria-labelledby="reportPost" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title">
                    <span class="bg-white">
                        <i class="icon-flag"></i>
                    </span>
                    أبلغ عن المحتوي</h5>
                
            </div>
            <div class="modal-body">
                <form id="formReport" data-id="" data-bv-onsuccess="reportPost">
                    <div class="form-group form-group_alt">
                        <select name="reasons" style="width: 100%" data-placeholder="سبب التقرير؟" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                            <option></option>
                            <?php foreach (mo_generate_delete_reasons() as $reason => $reason_label) { ?>
                            <option value="<?php echo $reason; ?>"><?php echo $reason_label; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group form-group_alt">
                        <textarea class="form-control" name="notes" cols="50" rows="4" placeholder="ملاحظات" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">إلغاء</button>
                        <button class="btn bg-secondary text-white " type="submit">أبلغ</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>