
<section class="d-flex align-items-center vh-100 bg-blue">
    <div class="container container-padding">
        <!-- page content   -->
        <div class="row align-items-center">
            <div class="col-md-8"> 
                <div class="sign-page-img">
                    <img src="<?php echo get_template_directory_uri() . '/images/register-img.svg';?>" alt="welcome image">
                </div>
            </div>
            <div class="col-md-4"> 
                <div class="sign-window">
                    <h1>اهلاً بيك!</h1>
                    <p>لإنشاء حساب جديد ، يرجى ملء هذه المعلومات.</p>
                    <form id="formRegister" class="sign-window-form" autocomplete="off" data-bv-onsuccess="registerUser">
                        <!-- <div class="form-group registerName">
                            <input type="text" class="form-control" aria-describedby="name" placeholder="الاسم الأول" name="firstname" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                            <input type="text" class="form-control" aria-describedby="name" placeholder="اسم العائلة" name="lastname" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                        </div> -->
                        <div class="form-group">
                            <input type="text" class="form-control" aria-describedby="username" placeholder="اسم المستخدم" name="username" data-bv-notempty="true" data-bv-remote="true" data-bv-remote-name="username" data-bv-remote-type="POST" data-bv-remote-message="اسم المستخدم مسجل من قبل" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" aria-describedby="email" placeholder="البريد الإلكتروني" name="email" data-bv-notempty="true" data-bv-remote="true" data-bv-remote-name="emailnumber" data-bv-remote-type="POST" data-bv-remote-message="البريد الإلكتروني مسجل من قبل" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-bv-emailaddress-message="ادخل عنوان بريد الكتروني صحيح">
                        </div>
                       <!--  <div class="form-group">
                            <input type="tel" class="form-control" aria-describedby="number" placeholder="رقم الموبايل" name="number" data-bv-notempty="true" data-bv-digits="true" data-bv-stringlength="true" data-bv-stringlength-max="11" data-bv-stringlength-min="11" data-bv-regexp="true" data-bv-regexp-regexp="^[0][1][\d]*" data-bv-remote="true" data-bv-remote-name="emailnumber" data-bv-remote-type="POST" data-bv-remote-message="رقم الهاتف مسجل من قبل" data-bv-regexp-message="رقم الهاتف يجب ان يبدأ ب ٠١" data-bv-stringlength-message="رقم الهاتف مكون من ١١ رقم" data-bv-digits-message="ادخل ارقام فقط" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                        </div> -->
                        <div class="form-group form-group-icon left_icon">
                            <input type="password" class="form-control" aria-describedby="password" placeholder="كلمة المرور" name="password" autocomplete="new-password" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"  pattern="(?=.*\d)(?=.*[a-z]).{6,}$" data-bv-regexp-message="كلمه السر يجب أن تحتوي علي حرف او رقم واحد علي الأقل" minlength="6" data-bv-stringlength-message="كلمه السر يجب أن  لا تكون أقل من ٦ حروف و أرقام" data-bv-identical="true" data-bv-identical-field="confirm-password" data-bv-identical-message="كلمه السر غير متطابقه">
                            <a class="viewPass" href="#">
                                <i class="icon-eye-regular"></i>
                            </a>
                        </div>
                        <div class="form-group form-group-icon left_icon">
                            <input type="password" class="form-control" aria-describedby="password" placeholder="أعد إدخال كلمه المرور" name="confirmpassword" autocomplete="new-password" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا"  pattern="(?=.*\d)(?=.*[a-z]).{6,}$" data-bv-regexp-message="كلمه السر يجب أن تحتوي علي حرف او رقم واحد علي الأقل" minlength="6" data-bv-stringlength-message="كلمه السر يجب أن  لا تكون أقل من ٦ حروف و أرقام" data-bv-identical="true" data-bv-identical-field="password" data-bv-identical-message="كلمه السر غير متطابقه">
                            <a class="viewPass" href="#">
                                <i class="icon-eye-regular"></i>
                            </a>
                        </div>
                        <!-- <div class="form-group">
                            <div class="container">
                                <div class="row rounded border border-white">
                                    <input type="hidden" aria-describedby="birthdate" placeholder="يوم / شهر  / سنه " name="bdate" data-bv-excluded="false" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-bv-date="true" data-bv-date-format="DD/MM/YYYY" data-bv-date-message="يجب ادخال تاريخ الميلاد كامل">
                                    <div class="col-4">
                                        <select class="day-dropdown" name="day" dir="rtl" onchange="formDateString('formRegister')">
                                            <option selected disabled>يوم</option>
                                            <?php $day=1;
                                            while($day <= 31){ ?>
                                                <option value="<?php echo $day; ?>"><?php echo $day;  $day++; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="month-dropdown" name="month" dir="rtl" onchange="formDateString('formRegister')">
                                            <option selected disabled>شهر</option>
                                            <option value="1">يناير</option>
                                            <option value="2">فبراير</option>
                                            <option value="3">مارس</option>
                                            <option value="4">ابريل</option>
                                            <option value="5">مايو</option>
                                            <option value="6">يونيو</option>
                                            <option value="7">يوليو</option>
                                            <option value="8">أغسطس</option>
                                            <option value="9">سبتمبر</option>
                                            <option value="10">أكتوبر</option>
                                            <option value="11">نوفمبر</option>
                                            <option value="12">ديسمبر</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <select class="year-dropdown" name="year" dir="rtl" onchange="formDateString('formRegister')">
                                            <option selected disabled>سنه</option>
                                            <?php $minYear = 1950;
                                            $thisYear = date('Y');
                                            $maxYear = $thisYear - 21;
                                            while($minYear <= $maxYear){ ?>
                                                <option value='<?php echo $minYear;?>'><?php echo $minYear; $minYear++ ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <?php // echo do_shortcode('[nextend_social_login redirect="https://mowazi.org/"]'); ?>
                        <div class="form-group register-policy">
                            <input type="checkbox" class="" aria-describedby="policy" name="policy" data-bv-notempty="true" >
                            <label>برجاء مراجعة <a href="<?php echo get_permalink(3); ?>" target="_blank">الشروط والاحكام</a></label>
                        </div>
                        <button type="submit" class="btn btn-block btn-lg btn-primary">انشاء حساب جديد</button>
                        <?php echo do_shortcode('[nextend_social_login redirect="https://mowazi.org/"]'); ?>
                        <p class="text-muted">بالنقر على "إنشاء حساب جديد" ، فإنك توافق على <a class="text-muted" title="policy & terms" href="<?php echo get_permalink(3); ?>" data-page="3">البنود وسياسة البيانات الخاصة بنا</a></p>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of page content  -->
    </div>
</section>