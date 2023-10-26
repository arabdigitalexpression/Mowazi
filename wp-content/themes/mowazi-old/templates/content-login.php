

<section class="d-flex align-items-center vh-100 bg-blue">
    <div class="container">
        <!-- page content   -->
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="sign-page-img">
                    <img src="<?php echo get_template_directory_uri() . '/images/welcome-login.svg';?>" alt="welcome image">
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="sign-window">
                    <h1>اهلاً بيك!</h1>

                    <p>لإنشاء حساب جديد ، يرجى ملء هذه المعلومات.</p>

                    <form id="formLogin" class="sign-window-form" data-bv-onsuccess="loginUser">
                        <div class="form-group">
                            <input type="text" class="form-control" aria-describedby="usernameHelp" placeholder="اسم المستخدم او البريد الإلكتروني او رقم الموبايل" name="username" data-bv-notempty="true"  data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                        </div>
                        <div class="form-group form-group-icon left_icon">
                            <input type="password" class="form-control" aria-describedby="passwordHelp" placeholder="كلمة المرور" name="password" data-bv-notempty="true" data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا">
                            <a class="viewPass" href="#">
                                <i class="icon-eye-regular"></i>
                            </a>
                        </div>
                        <!-- <a class="text-white" href="#forgetPass" data-toggle="modal">نسيت كلمه المرور؟</a> -->
                        <a class="text-white" href="<?php echo wp_lostpassword_url(); ?>">نسيت كلمه المرور؟</a>
                            <!-- Modal new group -->
                        <?php echo do_shortcode('[nextend_social_login]'); ?>
                        <button type="submit" class="btn btn-block btn-primary btn-lg">تسجيل الدخول</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- page content   -->
    </div>
</section>
<div class="modal fade new-content" id="forgetPass" tabindex="-1" role="dialog" aria-labelledby="forgetPass" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">نسيت كلمه المرور</h5>
            </div>
            <div class="modal-body">
                <form id="formRegeneratePass" autocomplete="off" data-bv-onsuccess="regeneratePass">
                    <div class="form-group">
                        <input type="email" class="form-control border-dark text-black-50" aria-describedby="email" placeholder="البريد الإلكتروني" name="email" data-bv-notempty="true"data-bv-notempty-message="هذا الحقل لا يمكن ان يكون فارغا" data-bv-emailaddress-message="ادخل عنوان بريد الكتروني صحيح">
                    </div>
                    <div class="form-group form-group_search mt-3">
                        <button type="submit" class="btn btn-primary">تغيير كلمه المرور</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .nsl-container-buttons{
        margin: 20px 0 30px;
    }
    .nsl-button{
        display: flex;
        padding: 5px;
        align-items: center;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    .nsl-button-svg-container{
        margin-left: 5px;
    }
    .nsl-container-buttons svg{
        width: 40px;
        height: 35px;
    }
</style>