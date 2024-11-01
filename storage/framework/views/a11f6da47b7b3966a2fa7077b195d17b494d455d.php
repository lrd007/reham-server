<?php echo $__env->make('website.static.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
<div class="layout-main register__main">
    <div class="container-fluid">
        <div class="d-flex layout-row">
            <div class="layout-main">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="login__main">
                                <div class="col-12">
                                    <div class="img__top cen-row">
                                        <img src="<?php echo e(asset('assets/dexter/src/images/reham-logo-arabic-white.png')); ?>" class="img-fluid" alt="logo" width="180">
                                    </div>
                                </div>
                                <div class="col-12 d-md-flex align-items-center justify-content-center">
                                    <form action="<?php echo e(route('user.login')); ?>" method="POST" class="__form <?php if($errors->has('email') || $errors->has('password')): ?>)--warning <?php endif; ?> d-flex flex-column align-items-center">
                                        <?php echo csrf_field(); ?>
                                        <div class="form__header">
                                            <p class="heading">
                                                يسرنا إنضمامك معنا
                                            </p>
                                            <p class="sub__heading">
                                                أنتِ على بعد خطوة واحده من بدء أجمل تجربة في حياتك
                                            </p>
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right <?php if($errors->has('email')): ?>) --warrning <?php endif; ?> "></i>
                                                <input type="email"  name="email" placeholder="البريد الإلكتروني" class="__input <?php if($errors->has('email')): ?> is-invalid <?php endif; ?>" required/>
                                                <i class="fa-solid fa-envelope __icon-left"></i>
                                            </div>
                                            <?php if($errors->has('email')): ?>
                                                <div class="warrning__message">
                                                    <p>
                                                        يرجى إدخال بريد إلكتروني صحيح
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right <?php if($errors->has('password')): ?>) --warrning <?php endif; ?> "></i>
                                                <input type="password" name="password" placeholder="كلمة السر" class="__input <?php if($errors->has('password')): ?>) is-invalid <?php endif; ?>" required/>
                                                <i class="fa-solid fa-key __icon-left"></i>
                                            </div>

                                            <?php if($errors->has('password')): ?>
                                                <div class="warrning__message">
                                                    <p class="message">يرجى إدخال  سر صحيحة</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="link__down">
                                            <a href="<?php echo e(route('forgot_password')); ?>" class="">
                                                نسيت كلمة السر ؟
                                            </a>
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-right-to-bracket __icon-submit"></i>
                                                <input type="submit" value="تسجيل الدخول" class="__input _submit"/>
                                            </div>
                                        </div>
                                        <div class="form__down d-flex align-items-center">
                                            <p>ليس لديك حساب؟</p>
                                            <a href="<?php echo e(route('signup')); ?>" class="link">
                                                سجل هنا
                                            </a>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->

<?php echo $__env->make('website.static.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\Work Space\Reham\server\resources\views/website/Auth/login.blade.php ENDPATH**/ ?>