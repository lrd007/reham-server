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
                    @can('admin_dashboard.view')
                    <a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-view-dashboard text-primary"></i><span> {{ __('Dashboard') }} </span></a>
                    @endcan
                </li>

                @can('subscriber.view')
                <li><a href="{{ route('subscriber.index') }}"><i class="mdi mdi-account-multiple text-success"></i><span> {{ __('Subscribers') }} </span></a></li>
                @endcan

                <li>
                    <a href="#sidebarProgram" data-toggle="collapse">
                        <i class="mdi mdi-view-column text-secondary"></i>
                        <span> {{ __('Program') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarProgram">
                        <ul class="nav-second-level">
                            @can('program.view')
                                <li><a href="{{ route('program.index') }}">{{ __('Program') }}</a></li>
                                <li><a href="{{ route('program.section.index') }}">{{ __('Section') }}</a></li>
                            @endcan                            
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarSettings" data-toggle="collapse">
                        <i class="mdi mdi-book-open-page-variant text-info"></i>
                        <span> {{ __('Course') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings">
                        <ul class="nav-second-level">
                            @can('course.view')
                            <li><a href="{{ route('course.index') }}">{{ __('Courses') }}</a></li>
                            @endcan
                            @can('chapter.view')
                            <li><a href="{{ route('chapter.index') }}">{{ __('Chapter') }}</a></li>
                            @endcan
                            @can('lesson.view')
                            <li><a href="{{ route('lesson.index') }}">{{ __('Lesson') }}</a></li>
                            @endcan
                            @can('bonus_material.view')
                            <li><a href="{{ route('bonusmaterial.index') }}">{{ __('Bonus') }}</a></li>
                            @endcan
                            @can('tag.view')
                            <li><a href="{{ route('tag.index') }}">{{ __('Tag') }}</a></li>
                            @endcan 
                            @can('course_package.view')
                            <li><a href="{{ route('coursepackage.index') }}">{{ __('Duration') }}</a></li>
                            @endcan
                            @can('coupon.view')
                            <li><a href="{{ route('coupon.index') }}">{{ __('Coupon') }}</a></li>
                            @endcan 
                        </ul>
                    </div>
                </li>

                
                <li><a href="{{ route('event.index') }}"><i class="mdi mdi-calendar text-danger"></i><span> {{ __('Event') }} </span></a></li>
                
                @can('quiz.view')
                <li><a href="{{ route('quiz.index') }}"><i class="mdi mdi-head-question-outline text-danger"></i><span> {{ __('Quiz') }} </span></a></li>
                @endcan

                @can('blog.view')
                <li><a href="{{ route('blog.index') }}"><i class="mdi mdi-book" style="color: #ea8bb8;"></i><span> {{ __('Blog') }} </span></a></li>
                @endcan

                <li>
                    <a href="#sidebarSettings1" data-toggle="collapse">
                        <i class="mdi mdi-key text-warning"></i>
                        <span> {{ __('Access') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings1">
                        <ul class="nav-second-level">
                            @can('admin_user.view')
                            <li><a href="{{ route('admin-user.index') }}">{{ __('Admin User') }}</a></li>
                            @endcan
                            @can('audit_log.view')
                            <li><a href="{{ route('audit-log.activity') }}">{{ __('Audit Log') }}</a></li>
                            @endcan
                            @can('role.view')
                            <li><a href="{{ route('role.index') }}">{{ __('Role') }}</a></li>
                            @endcan
                        </ul>
                    </div>
                </li>

                @can('affiliate.view')
                <li><a href="{{ route('affiliate.index') }}"><i class="mdi mdi-account-group" style="color: lime;"></i><span> {{ __('Affiliates') }} </span></a></li>
                @endcan

                <li>
                    <a href="#sidebarSettings2" data-toggle="collapse">
                        <i class="mdi mdi-frequently-asked-questions" style="color: deeppink;"></i>
                        <span> {{ __('FAQ') }} </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarSettings2">
                        <ul class="nav-second-level">
                            @can('category.view')
                            <li><a href="{{ route('category.index') }}"><span> {{ __('Category') }} </span></a></li>
                            @endcan
                            @can('faq.view')
                            <li><a href="{{ route('faq.index') }}"><span> {{ __('FAQ') }} </span></a></li>
                            @endcan
                        </ul>
                    </div>
                </li>

                @can('comment.view')
                <li><a href="{{ route('comment.index') }}"><i class="mdi mdi-comment-edit text-muted"></i><span> {{ __('Comment') }} </span></a></li>
                @endcan
                @can('story.view')
                <li><a href="{{ route('successstory.index') }}"><i class="mdi mdi-receipt" style="color: #19745f;"></i><span> {{ __('Stories') }} </span></a></li>
                @endcan

                @can('audiobook.view')
                <li><a href="{{ route('audiobook.index') }}"><i class="mdi mdi-playlist-music" style="color: #010fbb;"></i><span> {{ __('Book') }} </span></a></li>
                @endcan
                @can('notification.view')
                <li><a href="{{ route('notificationcenter.index') }}"><i class="mdi mdi-bell" style="color: #ff5200;"></i><span> {{ __('Notification') }} </span></a></li>
                @endcan
                @can('payment.view')
                <li><a href="{{ route('payment.index') }}"><i class="mdi mdi-barcode-scan" style="color: #000000;"></i><span> {{ __('Reports') }} </span></a></li>
                @endcan
                <!-- <li><a href="#"><i class="mdi mdi-chart-areaspline" style="color: #bd8bea;"></i><span> {{ __('Reports') }} </span></a></li>
                <li><a href="#"><i class="mdi mdi-cast-education" style="color: brown;"></i><span> {{ __('Streaming') }} </span></a></li>
                <li><a href="#"><i class="mdi mdi-phone" style="color: #5584cd;"></i><span> {{ __('Web Call') }} </span></a></li> -->
								<li>
										<a href="{{ route('empty-Wishlist')}}">
										<i class="mdi mdi-delete-forever" style="color: red;"></i>
										<span> {{ __('Clear Wishlist') }} </span>
										</a>
								</li> 
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->