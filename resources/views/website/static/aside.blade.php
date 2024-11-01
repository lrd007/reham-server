<!-- ⭐⭐⭐⭐⭐ breadcrumb  ⭐⭐⭐⭐⭐-->
<div class="bottom__nav">
    <div class="breadcrumb__program d-flex align-items-center justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item home" >
                    <a href="{{ route('index') }}">
                        <i class="fa-solid fa-house-chimney"></i>
                        الرئيسية
                    </a>
                </li>

                <li class="breadcrumb-item d-flex align-items-center">
                    <i class="fa-sharp fa-solid fa-arrow-left-long __icon"></i>
                    <a href="{{ route('all_programs') }}" class="d-block0">
                        برامجي
                    </a>
                </li>

                @if ((request()->routeIs('get_started') ))
                    <li class="breadcrumb-item d-flex align-items-center">
                        <i class="fa-sharp fa-solid fa-arrow-left-long __icon"></i>
                        <a href="{{route('get_started')}}" class="d-block0">
                            ابدء من هنا
                        </a>
                    </li>
                @endif
                @if(isset($program_data))
                    <li class="breadcrumb-item d-flex align-items-center">
                        <i class="fa-sharp fa-solid fa-arrow-left-long __icon"></i>
                        <a href="{{route('single-program',['program_id' => $program_data->id])}}" class="d-block0">
                            {{ $program_data->name_ar }}
                        </a>
                    </li>
                @endif
                @if(isset($program_data,$course_data))
                    <li class="breadcrumb-item d-flex align-items-center">
                        <i class="fa-sharp fa-solid fa-arrow-left-long __icon"></i>
                        <a href="{{route('chapter-details',['program_id' => $program_data->id , 'course_id' => $course_data->id ])}}" class="d-block0">
                            {{ $course_data->name_ar }}
                        </a>
                    </li>
                @endif
                @if(isset($program_data,$course_data,$chapter_data))
                    <li class="breadcrumb-item d-flex align-items-center">
                        <i class="fa-sharp fa-solid fa-arrow-left-long __icon"></i>
                        <a href="{{route('lesson-details',['program_id' => $program_data->id , 'course_id' => $course_data->id, 'chapter_id' =>  $chapter_data->id])}}" class="d-block0">
                            {{ $chapter_data->name_ar }}
                        </a>
                    </li>
                @endif
            </ol>
        </nav>
        <div class="col-md-6 col-12 d-flex justify-content-md-end justify-content-center">
            <div class="progress__program text-center">
                <p>

                    @if(isset($percent))
                        <span>نسبة انجازك  {{ $percent }}%</span>
                    @elseif(isset($user) && $user->subscriber->SubscribtionPersent())
                        <span>نسبة انجازك   {{ $user->subscriber->SubscribtionPersent() }}%</span>
                    @else
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
<!-- 🚫🚫🚫🚫  breadcrumb 🚫🚫🚫🚫-->

<!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
<div class="layout-main">
    <div class="container-fluid">
        <div class="d-flex layout-row">
            <div class="side-open" id="sideMainOpen">
                <div class="icon">
                    <i class="fa-solid fa-list"></i>
                </div>
            </div>
            <div class="side-menu --close" id="sideMenu">
                <!-- ⭐⭐⭐⭐⭐ sidebar  ⭐⭐⭐⭐⭐-->
                <aside class="side__bar-main">
                    <div class="aside__top">
                        <div class="close-side" id="closeSideMain">
                            <div class="icon">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                        <form action="" class="aside__form">
                            <input type="search" class="__input" placeholder="ابحث">
                        </form>
                    </div>
                    <ul class="side__items__section">
                        <li class="side__item @if(request()->routeIs('index')) heading --heading-active @endif">
                            <a href="{{route('index')}}">
                                الرئيسية
                            </a>
                        </li>
                        <li class="side__item  @if(request()->routeIs('get_started')) heading --heading-active @endif">
                            <a href="{{ route('get_started') }}">
                                البداية
                            </a>
                        </li>
                        @include('website.static.programs_menu')
                        <li class="side__item @if(request()->routeIs('bonusmaterial.bonus')) heading --heading-active @endif">
                            <a href="{{ route('bonusmaterial.bonus') }}#extra">
                                المواد الاضافية
                            </a>
                        </li>

                    </ul>
                    <ul class="side__items__section">
                        {{--<li class="side__item heading">
                            <p class="heading">
                                الموارد
                            </p>
                        </li>--}}
                        <li class="side__item @if(request()->routeIs('calendar')) heading --heading-active @endif">
                            <a href="{{ route('calendar') }}">
                                الرزمانة
                            </a>
                        </li>
                        <li class="side__item  @if(request()->routeIs('faq')) heading --heading-active @endif">
                            <a href="{{ route('faq') }}">
                                الاسئلة الشائعة
                            </a>
                        </li>
                        <li class="side__item ">
                            <a href="../questionnaire/index.html">
                                اراء المشتركين
                            </a>
                        </li>
                    </ul>
                    <div class="aside__bottom">
                        <p class="heading">شاركنا قصتك الملهمة</p>
                        <a href="#">
                            اضغط هنا لمشاركة قصتك
                        </a>
                    </div>
                </aside>
                <!-- 🚫🚫🚫🚫 sidebar  🚫🚫🚫🚫-->
            </div>
