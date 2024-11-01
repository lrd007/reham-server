<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center">
            <img src="" alt="user-img" title="" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul id="side-menu">
                <li style="background: #f5f6f8;">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_dashboard.view')): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="mdi mdi-view-dashboard text-primary"></i><span> <?php echo e(__('Dashboard')); ?> </span></a>
                    <?php endif; ?>
                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('subscriber.view')): ?>
                <li><a href="<?php echo e(route('subscriber.index')); ?>"><i class="mdi mdi-account-multiple text-success"></i><span> <?php echo e(__('Subscribers')); ?> </span></a></li>
                <?php endif; ?>

                <li>
                    <a href="#sidebarProgram" data-toggle="collapse">
                        <i class="mdi mdi-view-column text-secondary"></i>
                        <span> <?php echo e(__('Program')); ?> </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarProgram">
                        <ul class="nav-second-level">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('program.view')): ?>
                                <li><a href="<?php echo e(route('program.index')); ?>"><?php echo e(__('Program')); ?></a></li>
                                <li><a href="<?php echo e(route('program.section.index')); ?>"><?php echo e(__('Section')); ?></a></li>
                            <?php endif; ?>                            
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarSettings" data-toggle="collapse">
                        <i class="mdi mdi-book-open-page-variant text-info"></i>
                        <span> <?php echo e(__('Course')); ?> </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings">
                        <ul class="nav-second-level">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course.view')): ?>
                            <li><a href="<?php echo e(route('course.index')); ?>"><?php echo e(__('Courses')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('chapter.view')): ?>
                            <li><a href="<?php echo e(route('chapter.index')); ?>"><?php echo e(__('Chapter')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson.view')): ?>
                            <li><a href="<?php echo e(route('lesson.index')); ?>"><?php echo e(__('Lesson')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bonus_material.view')): ?>
                            <li><a href="<?php echo e(route('bonusmaterial.index')); ?>"><?php echo e(__('Bonus')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tag.view')): ?>
                            <li><a href="<?php echo e(route('tag.index')); ?>"><?php echo e(__('Tag')); ?></a></li>
                            <?php endif; ?> 
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_package.view')): ?>
                            <li><a href="<?php echo e(route('coursepackage.index')); ?>"><?php echo e(__('Duration')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon.view')): ?>
                            <li><a href="<?php echo e(route('coupon.index')); ?>"><?php echo e(__('Coupon')); ?></a></li>
                            <?php endif; ?> 
                        </ul>
                    </div>
                </li>

                
                <li><a href="<?php echo e(route('event.index')); ?>"><i class="mdi mdi-calendar text-danger"></i><span> <?php echo e(__('Event')); ?> </span></a></li>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('quiz.view')): ?>
                <li><a href="<?php echo e(route('quiz.index')); ?>"><i class="mdi mdi-head-question-outline text-danger"></i><span> <?php echo e(__('Quiz')); ?> </span></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('blog.view')): ?>
                <li><a href="<?php echo e(route('blog.index')); ?>"><i class="mdi mdi-book" style="color: #ea8bb8;"></i><span> <?php echo e(__('Blog')); ?> </span></a></li>
                <?php endif; ?>

                <li>
                    <a href="#sidebarSettings1" data-toggle="collapse">
                        <i class="mdi mdi-key text-warning"></i>
                        <span> <?php echo e(__('Access')); ?> </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings1">
                        <ul class="nav-second-level">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin_user.view')): ?>
                            <li><a href="<?php echo e(route('admin-user.index')); ?>"><?php echo e(__('Admin User')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('audit_log.view')): ?>
                            <li><a href="<?php echo e(route('audit-log.activity')); ?>"><?php echo e(__('Audit Log')); ?></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role.view')): ?>
                            <li><a href="<?php echo e(route('role.index')); ?>"><?php echo e(__('Role')); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('affiliate.view')): ?>
                <li><a href="<?php echo e(route('affiliate.index')); ?>"><i class="mdi mdi-account-group" style="color: lime;"></i><span> <?php echo e(__('Affiliates')); ?> </span></a></li>
                <?php endif; ?>

                <li>
                    <a href="#sidebarSettings2" data-toggle="collapse">
                        <i class="mdi mdi-frequently-asked-questions" style="color: deeppink;"></i>
                        <span> <?php echo e(__('FAQ')); ?> </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings2">
                        <ul class="nav-second-level">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category.view')): ?>
                            <li><a href="<?php echo e(route('category.index')); ?>"><span> <?php echo e(__('Category')); ?> </span></a></li>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('faq.view')): ?>
                            <li><a href="<?php echo e(route('faq.index')); ?>"><span> <?php echo e(__('FAQ')); ?> </span></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('comment.view')): ?>
                <li><a href="<?php echo e(route('comment.index')); ?>"><i class="mdi mdi-comment-edit text-muted"></i><span> <?php echo e(__('Comment')); ?> </span></a></li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('story.view')): ?>
                <li><a href="<?php echo e(route('successstory.index')); ?>"><i class="mdi mdi-receipt" style="color: #19745f;"></i><span> <?php echo e(__('Stories')); ?> </span></a></li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('audiobook.view')): ?>
                <li><a href="<?php echo e(route('audiobook.index')); ?>"><i class="mdi mdi-playlist-music" style="color: #010fbb;"></i><span> <?php echo e(__('Book')); ?> </span></a></li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('notification.view')): ?>
                <li><a href="<?php echo e(route('notificationcenter.index')); ?>"><i class="mdi mdi-bell" style="color: #ff5200;"></i><span> <?php echo e(__('Notification')); ?> </span></a></li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment.view')): ?>
                <li><a href="<?php echo e(route('payment.index')); ?>"><i class="mdi mdi-barcode-scan" style="color: #000000;"></i><span> <?php echo e(__('Reports')); ?> </span></a></li>
                <?php endif; ?>
                <!-- <li><a href="#"><i class="mdi mdi-chart-areaspline" style="color: #bd8bea;"></i><span> <?php echo e(__('Reports')); ?> </span></a></li>
                <li><a href="#"><i class="mdi mdi-cast-education" style="color: brown;"></i><span> <?php echo e(__('Streaming')); ?> </span></a></li>
                <li><a href="#"><i class="mdi mdi-phone" style="color: #5584cd;"></i><span> <?php echo e(__('Web Call')); ?> </span></a></li> -->
								<li>
										<a href="<?php echo e(route('empty-Wishlist')); ?>">
										<i class="mdi mdi-delete-forever" style="color: red;"></i>
										<span> <?php echo e(__('Clear Wishlist')); ?> </span>
										</a>
								</li> 
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End --><?php /**PATH D:\Work Space\Reham\server\resources\views/layouts/shared/left-sidebar.blade.php ENDPATH**/ ?>