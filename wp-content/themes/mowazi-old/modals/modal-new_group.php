<!-- Modal new group -->
<div class="modal fade new-content new-group" id="newGroup" tabindex="-1" role="dialog" aria-labelledby="newGroup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">مجموعة جديدة</h5>
            </div>
            <div class="modal-body">
                
                <form id="formNewGroup" data-bv-onsuccess="createGroup">

                    <div class="new-content_info">
                        <div class="bg-primary">
                            <span><i class="icon-info"></i></span>
                            <p>عندما تنشئ مجموعة جديدة تساعد الجميع على مواصلة التعلم والخبرة. عليك أن تبقي العمل الجيد مستمرًا وأن تهتم بالجميع.</p>
                        </div>

                        <div>
                            <div>
                                <i class="icon-upload-photo"></i>
                                ارفع صورة
                            </div>

                            <div class="avatar bg-secondary" data-avatar=""></div>
                        </div>
                    </div>

                    <div class="form-group form-group_alt alt-model">
                        <label for="title">عنوان المجموعة</label>
                        <input type="text" class="form-control" name="title" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                    </div>

                    <div class="form-group form-group_alt alt-model">
                        <label for="desc">وصف المجموعة</label>
                        <textarea class="form-control" name="desc" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"></textarea>
                    </div>

                    <div class="form-group form-group_alt form-group-member alt-model">
                        <label for="members">قائمة الأعضاء</label>
                        <select style="width:100%;" name="members" class="form-control bg-white" multiple="multiple" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-placeholder="إدراج أسماء أو عناوين البريد الإلكتروني">
                        </select>
                        <i class="icon-icon-users"></i>
                    </div>

                    <div class="form-group form-group_alt form-group-member alt-model">
                        <label for="admins">قائمة المسؤولين</label>
                        <select style="width:100%;" name="admins" class="form-control bg-white" multiple="multiple" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-placeholder="إدراج أسماء أو عناوين البريد الإلكتروني">
                        </select>
                        <i class="icon-admin"></i>
                    </div>

                    <div class="model-footer">
                        <div class="open-sources">
                            <i class="icon-unlock"></i>
                            <p>مجموعات موازي كلها تكون عامة</p>
                        </div>
                        <div>
                            <a href="#" class="btn btn-outline-dark" data-dismiss="modal" aria-label="Close">إلغاء</a>
                            <button type="submit" class="btn btn-primary create-group">إنشاء</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>