<?php echo $__env->make('website.static.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(!(request()->routeIs('user.login') ) && !(request()->routeIs('signup')) ): ?>

<?php if(auth()->guard()->guest()): ?>

    <!-- ⭐⭐⭐⭐⭐ navbar  ⭐⭐⭐⭐⭐-->
    <nav class="navbar__standard">
        <div class="container">
            <div class="row justify-content-around align-items-center">
                <div class="col-4 cen-row">
                    <div class="nav__link">
                        <a href="<?php echo e(route('user.login')); ?>" >
                            تسجيل الدخول
                        </a>
                    </div>
                </div>
                <div class="col-4 cen-row">
                    <div class=nav__logo">
                        <a href="<?php echo e(route('index')); ?>" >
                            <img src="<?php echo e(asset('assets/dexter/src/images/logo-pink.png')); ?>" alt="logo" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-4 cen-row">
                    <div class="nav__link">
                        <a href="<?php echo e(route('technical_support')); ?>" >
                            الدعم الفني
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </nav>
    <!-- 🚫🚫🚫🚫 navbar  🚫🚫🚫🚫-->

<?php endif; ?>

<?php if(auth()->guard()->check()): ?>
    <!-- ⭐⭐⭐⭐⭐ navbar  ⭐⭐⭐⭐⭐-->
    <nav class="navbar__main">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-3 col-12 col-xs-3">
                    <div class="nav__logo ">
                        <a class="navbar-brand" href="<?php echo e(route('index')); ?>">
                            <img src="<?php echo e(asset('assets/dexter/src/images/reham-logo-arabic-white.png')); ?>" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-12 col-xs-9 col-md-6 d-flex justify-content-center justify-content-md-end">
                    <ul class="nav__items d-flex list-unstyled justify-content-center  justify-content-md-end">
                        <li class="nav__item __icon">
                            <a href="<?php echo e(route('notification')); ?>" class="nav__link">
                                <i class="fa-regular fa-bell"></i>
                                <span><?php echo e(Auth::user()->notifications->count()); ?></span>
                            </a>
                        </li>
                        <li class="nav__item __icon">
                            <a href="<?php echo e(route('cart')); ?>" class="nav__link">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span><?php echo e(Auth::user()->wishlist('cart')->count()); ?></span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('index')); ?>#programs" class="nav__link">
                                البرامج
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('profile')); ?>" class="nav__link">
                                حسابك
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('technical_support')); ?>" class="nav__link">
                                الدعم الفني
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo e(route('user.logout')); ?>" class="nav__link">
                                تسجيل الخروج
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </nav>
    <!-- 🚫🚫🚫🚫 navbar  🚫🚫🚫🚫-->



    <?php if (! (request()->is('course_details') || request()->is('forgot_password') )): ?>
        <?php if(auth()->guard()->check()): ?>
            <?php echo $__env->make('website.static.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endif; ?>


<?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\Work Space\Reham\server\resources\views/website/static/navbar.blade.php ENDPATH**/ ?>