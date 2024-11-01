<?php echo $__env->make('website.static.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if(auth()->guard()->check()): ?>
    <!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
    <div class="layout-main">
        <div class="container-fluid">
            <div class="d-flex layout-row">
                <div class="layout-main getting-started-main">
                    <div class="container custom-container">
                        <div class="row">
                            <div class="col-12">
                                <div class="lesson-card cen-col" >
                                    <header class="header  cen-col">
                                        <h2 class="heading text-center">
                                            مبروك اشتراكك عرفينا بنفسك
                                        </h2>
                                        <p class="sub__heading text-center">
                                            مبرووك اشتراكك في منهج رهام ديفا ننوي لك رحلة رائعة معنا دعينا نبدأ عرفينا بنفسك
                                        </p>

                                    </header>
                                    <div class="video__container cen-row">
                                        <iframe
                                            title="vimeo-player"
                                            src="https://player.vimeo.com/video/760742775?h=3168f6aec0"
                                            frameborder="0"
                                            width="800px"
                                            height="550px"
                                            allowfullscreen>
                                        </iframe>
                                    </div>


                                </div>
                            </div>

                            <div class="col-12">
                                <div class="lesson-card cen-col" >
                                    <header class="header  cen-col">
                                        <h2 class="heading text-center">
                                            خريطة منهج رهام ديفا

                                        </h2>
                                        <p class="sub__heading text-center">
                                            جولة مع خريطة منهج رهام ديفا للأنوثة وحب الذات


                                        </p>

                                    </header>
                                    <div class="video__container cen-row">
                                        <iframe
                                            title="vimeo-player"
                                            src="https://player.vimeo.com/video/760744975?h=3168f6aec0"
                                            frameborder="0"
                                            width="800px"
                                            height="550px"
                                            allowfullscreen>
                                        </iframe>
                                    </div>


                                </div>
                            </div>

                            <div class="col-12">
                                <div class="lesson-card cen-col" >
                                    <header class="header  cen-col">
                                        <h2 class="heading text-center">
                                            الأدوات التعليمية في الرحلة
                                        </h2>
                                        <p class="sub__heading text-center">
                                            تعرفي على الأدوات التعليمية التي ستكون معك في الرحلة
                                        </p>

                                    </header>
                                    <div class="video__container cen-row">
                                        <iframe
                                            title="vimeo-player"
                                            src="https://player.vimeo.com/video/760746377?h=c5c976e06"
                                            frameborder="0"
                                            width="800px"
                                            height="550px"
                                            allowfullscreen>
                                        </iframe>
                                    </div>


                                </div>
                            </div>


                            <div class="col-12">
                                <div class="lesson-card cen-col" >
                                    <header class="header  cen-col">
                                        <h2 class="heading text-center">
                                            مقترحات لإنجاح تجربتك                                        </h2>
                                        <p class="sub__heading text-center">
                                            هنا مقترحات لمساعدتك في إنجاح تجربتك مع منهج رهام ديفا
                                        </p>

                                    </header>
                                    <div class="video__container cen-row">
                                        <iframe
                                            title="vimeo-player"
                                            src="https://player.vimeo.com/video/760743544?h=3168f6aec0"
                                            frameborder="0"
                                            width="800px"
                                            height="550px"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="lesson-card cen-col" >
                                    <a href="<?php echo e(route('chapter-details',['program_id' => 2 , 'course_id' => 1 ])); ?>" class="d-block lesson__link text-center">
                                       أبدئي من هنا
                                    </a>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="lesson-comments">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="header">
                                                <p class="heading text-center">
                                                    عرفنا على نفسك و شاركنا ارائك بالتعليقات
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="user-comment">
                                                <div class="user__box d-flex flex-column">
                                                    <div class="user__comment__top d-flex align-items-center" >
                                                        <i class="fa-solid fa-gear __icon"></i>
                                                        <p class="user__name ">تم تسجيل الدخول بواسطة  <span class="__name"> <?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?> </span> |</p>
                                                        <a href="<?php echo e(route('user.logout')); ?>" class="__logout">   تسجيل الخروج </a>
                                                    </div>
                                                    <div class="comment__form">
                                                        <form action="" class="__form d-flex">
                                                            <div class="user__img">
                                                                <?php if(\Illuminate\Support\Facades\Auth::user()->subscriber): ?>
                                                                    <img src="<?php echo e(asset(\Illuminate\Support\Facades\Auth::user()->subscriber->image)); ?>" class="__img" alt="user">
                                                                <?php else: ?>
                                                                    <img src="https://reham.com/assets/icons/profile-picture.svg" class="__img" alt="user">
                                                                <?php endif; ?>
                                                            </div>
                                                            <textarea  rows="3" class="comment__area" placeholder="انضم الى النقاشات">
                                                            </textarea>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="comments__status d-flex align-items-center justify-content-between">
                                                <div class="box__right  d-flex align-items-center">
                                                    <img  src="../src/images/testimonilaes.jpg" alt="tetsimoniales">
                                                    <img  src="../src/images/testimonilaes.jpg" alt="tetsimoniales">
                                                    <img  src="../src/images/testimonilaes.jpg" alt="tetsimoniales">
                                                    <img  src="../src/images/testimonilaes.jpg" alt="tetsimoniales">
                                                    <div class="comment__count">
                                                        751
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="box__left d-flex align-items-center">
                                                    <div class="comment__count">
                                                        751
                                                        <i class="fa-regular fa-comment"></i>
                                                    </div>
                                                    <div class="comment__count">
                                                        751
                                                        <i class="fa-solid fa-list"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comments">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="commment__card d-flex">
                                                    <div class="commment__left d-flex flex-column align-items-center">
                                                        <div class="__img">
                                                            <img src="../src/images/testimonilaes.jpg" alt="user" class="img-fluid">
                                                        </div>
                                                        <p class="user__tag">Member</p>
                                                    </div>
                                                    <div class="commment__right">
                                                        <p class="comment__auth">اسم افتراضي</p>
                                                        <p class="comment__body">
                                                            لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور

                                                            أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد

                                                            أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس

                                                            أيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت
                                                        </p>
                                                        <div class="comment__down d-flex justify-content-between align-items-center">
                                                            <div class="comment__date">
                                                                7 days ago
                                                            </div>
                                                            <div class="replay__button cen-row">
                                                                <i class="fa-regular fa-comment"></i>
                                                                replay
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="commment__card d-flex">
                                                    <div class="commment__left d-flex flex-column align-items-center">
                                                        <div class="__img">
                                                            <img src="../src/images/testimonilaes.jpg" alt="user" class="img-fluid">
                                                        </div>
                                                        <p class="user__tag">Member</p>
                                                    </div>
                                                    <div class="commment__right">
                                                        <p class="comment__auth">اسم افتراضي</p>
                                                        <p class="comment__body">
                                                            لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور

                                                            أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد

                                                            أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس

                                                            أيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت
                                                        </p>
                                                        <div class="comment__down d-flex justify-content-between align-items-center">
                                                            <div class="comment__date">
                                                                7 days ago
                                                            </div>
                                                            <div class="replay__button cen-row">
                                                                <i class="fa-regular fa-comment"></i>
                                                                replay
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="commment__card d-flex">
                                                    <div class="commment__left d-flex flex-column align-items-center">
                                                        <div class="__img">
                                                            <img src="../src/images/testimonilaes.jpg" alt="user" class="img-fluid">
                                                        </div>
                                                        <p class="user__tag">Member</p>
                                                    </div>
                                                    <div class="commment__right">
                                                        <p class="comment__auth">اسم افتراضي</p>
                                                        <p class="comment__body">
                                                            لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور

                                                            أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد

                                                            أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس

                                                            أيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت
                                                        </p>
                                                        <div class="comment__down d-flex justify-content-between align-items-center">
                                                            <div class="comment__date">
                                                                7 days ago
                                                            </div>
                                                            <div class="replay__button cen-row">
                                                                <i class="fa-regular fa-comment"></i>
                                                                replay
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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


<?php endif; ?>


<?php echo $__env->make('website.static.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH D:\Work Space\Reham\server\resources\views/website/program/get_started.blade.php ENDPATH**/ ?>