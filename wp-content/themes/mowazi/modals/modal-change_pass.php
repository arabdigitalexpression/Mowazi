<?php // silent ?>
<div class="modal fade new-content" id="changePass" tabindex="-1" role="dialog" aria-labelledby="changePass" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تغيير كلمه المرور</h5>
            </div>
            <form id="changePassForm" action="">
                <div class="modal-body">
                    <div class="form-group form-group_setting">
                        <label>كلمة المرور</label>
                        <input type="password" name="typePass" class="form-control" aria-describedby="password" placeholder="كلمة المرور" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"  pattern="(?=.*\d)(?=.*[a-z]).{6,}$" data-bv-regexp-message="كلمه السر يجب أن تحتوي علي حرف او رقم واحد" minlength="6" data-bv-stringlength-message="كلمه السر يجب أن  لا تكون أقل من ٦ حروف و أرقام" data-bv-identical="true" data-bv-identical-field="retypePass" data-bv-identical-message="كلمه السر غير متطابقه">
                    </div>
                    <div class="form-group form-group_setting">
                        <label> اعد كتابه كلمة المرور</label>
                        <input type="password" name="retypePass" class="form-control" aria-describedby="password" placeholder="أعد إدخال كلمه المرور" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"  pattern="(?=.*\d)(?=.*[a-z]).{6,}$" data-bv-regexp-message="كلمه السر يجب أن تحتوي علي حرف او رقم واحد" minlength="6" data-bv-stringlength-message="كلمه السر يجب أن  لا تكون أقل من ٦ حروف و أرقام" data-bv-identical="true" data-bv-identical-field="typePass" data-bv-identical-message="كلمه السر غير متطابقه">
                    </div>
                </div>
                <div class="model-footer justify-content-end">
                    <div>
                        <a href="#" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">إلغاء</a>
                        <button type="submit" class="btn btn-secondary">تغيير</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>