@include('website.static.navbar')

@auth()
{{--

    <!-- ⭐⭐⭐⭐⭐ breadcrumb  ⭐⭐⭐⭐⭐-->
    <div class="bottom__nav">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-10 d-none d-md-block">
                    <div class="nav__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 ">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('all_programs') }}">برامجي</a></li>
                                <li class="breadcrumb-item"><a href="{{route('single-program',['program_id' => $program_data->id])}}">{{ $program_data->name_ar }}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('chapter-details',['program_id' => $program_data->id , 'course_id' => $course_data->id ])}}">{{ $course_data->name_ar }}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('lesson-details',['program_id' => $program_data->id , 'course_id' => $course_data->id, 'chapter_id' =>  $chapter_data->id])}}">{{ $chapter_data->name_ar }}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-2 col-12 d-flex justify-content-md-end justify-content-center">
                    <div class="progress__program text-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫  breadcrumb 🚫🚫🚫🚫-->
--}}



    @php
            $program_name = $program_data->name_ar;
            $course_name = $course_data->name_ar;
            $chapter_name = $chapter_data->name_ar;
            $lesson_name = $lesson_data->name_ar;
            $lesson_description = $lesson_data->description_ar;
    @endphp

    <!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
    <div class="layout-main">
        <div class="container-fluid">
            <div class="d-flex layout-row">
                <div class="side-menu --open" id="sideMenu">
                    <!-- ⭐⭐⭐⭐⭐ sidebar  ⭐⭐⭐⭐⭐-->
                    <aside class="side__bar-main">
                        <div class="aside__top">
                            <div class="close-side" id="closeSideMain">
                                <div class="icon">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </div>
                        </div>
                        <ul class="side__items__section ">
                            <li class="side__item --back section__lesson">
                                <a href="{{ route('get_started') }}">
                                    الرجوع لصفحة البداية
                                </a>
                            </li>
                            <li class="side__item heading section__lesson">
                                <a href="../getting-started/index.html">
                                    فصول البرنامج
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    01
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item --active section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    02
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    03
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    04
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    05
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    06
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    07
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    08
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    09
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    010
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                            <li class="side__item section__lesson d-flex align-items-center">
                                <span class="lesson__number">
                                    11
                                </span>
                                <a href="../questionnaire/index.html">
                                    اسم افتراضي
                                </a>
                            </li>
                        </ul>
                    </aside>
                    <!-- 🚫🚫🚫🚫 sidebar  🚫🚫🚫🚫-->
                </div>






                <div class="layout-main lesson__main">
                    <div class="container custom-container">
                        <div class="row">
                            <div class="col-12 cen-col">
                                <div class="header__video__box">
                                    <div class="video-container  cen-row">

                                        <iframe
                                            title="vimeo-player"
                                            src="{{ GetVimeoFrameLink($lesson_data->vimeo_url) }}"
                                            width="800px"
                                            height="550px"
                                            frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                    <div class="lesson__ctr">
                                        <div class="__top d-flex align-items-center justify-content-between">
                                            <button class="lesson__toggle">
                                                @if(isset($next_lesson))
                                                    <a href="{{ $next_lesson }}">
                                                        الدرس التالي
                                                    </a>
                                                @endif

                                            </button>
                                            @if(isset($previous_lesson))
                                                <button class="lesson__toggle">
                                                    <a href="{{ $previous_lesson }}">
                                                        الدرس السابق
                                                    </a>
                                                </button>
                                            @else

                                                <button class="lesson__toggle" disabled>
                                                    <a href="#">
                                                        الدرس السابق
                                                    </a>
                                                </button>
                                            @endif

                                            <div class="d-flex align-items-center">
                                                <div>
                                                    @php
                                                        $checked = ($lesson_data->is_completed) ? 'checked="checked"' :  '';
                                                    @endphp
                                                    <label class="container__label">
                                                        <input class="form-check-input" type="checkbox" value="" {{$checked}} id="flexCheckDefault">
                                                        <inpu type="hidden" class="flexCheckDefault" data-id="{{ $lesson_data->id }}"/>
                                                        <input type="checkbox" {{ $checked  }}>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                                <p class="heading">
                                                    ضع علامة مكتمل
                                                </p>
                                            </div>
                                            <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal">
                                                <a href="#" class="lesson__link d-block" disabled="disabled">
                                                    اذهب إلى الاختبار
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="lesson__data__card">
                                    <ul class="nav__data__items list-unstyled __items d-flex align-items-center">
                                        <li class="__item --active">
                                            نظرة عامة
                                        </li>
                                    </ul>
                                    <div class="lesson__content">
                                        <p class="lesson__body">
                                            {!!$lesson_description!!}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="lesson__data__card">
                                    <ul class="nav__data__items list-unstyled __items d-flex align-items-center">

                                        <li class="__item --active" >
                                            صوتي
                                        </li>

                                    </ul>
                                    <div class="lesson__content __audio">
                                        <div class="audio__ctr">
                                            <audio controls>
                                                <source src="{{ $lesson_data->audio }}" type="audio/ogg">
                                                <source src="{{ $lesson_data->audio }}" type="audio/mpeg">
                                            </audio>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="lesson__data__card">
                                    <ul class="nav__data__items list-unstyled __items d-flex align-items-center">
                                        <li class="__item --active">
                                            تحميل
                                        </li>
                                    </ul>
                                    <div class="lesson__content lesson__data__cards d-flex align-items-center justify-content-around">
                                        <div class="lesson__data  cen-col">
                                            <a href="#" class="data__box cen-col">
                                                <i class="fa-solid fa-arrow-down"></i>
                                                جميع الفايلات
                                            </a>
                                        </div>
                                        <div class="lesson__data cen-col ">
                                            <a href="{{ $lesson_data->document }}" download="" class="data__box cen-col">
                                                <i class="fa-regular fa-file-pdf"></i>
                                                نسخةطبق الاصل
                                            </a>
                                        </div>
                                        <div class="lesson__data --active cen-col">
                                            <a href="{{ $lesson_data->audio }}" download="" class="data__box cen-col">

                                                <i class="fa-solid fa-arrow-down"></i>
                                                صوتي
                                            </a>
                                        </div>
                                        <div class="lesson__data  cen-col">
                                            <a href="{{ $lesson_data->video }}" download="" class="data__box cen-col">
                                                <i class="fa-solid fa-arrow-down"></i>
                                                فيديو
                                            </a>
                                        </div>
                                    </div>
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
                                                        <p class="user__name ">تم تسجيل الدخول بواسطة  <span class="__name"> {{ \Illuminate\Support\Facades\Auth::user()->name }} </span> |</p>
                                                        <a href="{{ route('user.logout') }}" class="__logout">   تسجيل الخروج </a>
                                                    </div>
                                                    <div class="comment__form">
                                                        <form method="post" action="{{ route('add-lesson-comment',$lesson_data->id) }}" class="__form d-flex">
                                                            {{ csrf_field() }}
                                                            <div class="user__img">
                                                                @if(\Illuminate\Support\Facades\Auth::user()->subscriber)
                                                                    <img src="{{ asset(\Illuminate\Support\Facades\Auth::user()->subscriber->image) }}" class="__img" alt="user">
                                                                @else
                                                                    <img src="https://reham.com/assets/icons/profile-picture.svg" class="__img" alt="user">
                                                                @endif
                                                            </div>
                                                            <textarea name="comment" id="userComment" class="comment__area"   placeholder="انضم الى النقاشات" name="w3review" rows="4" ></textarea>
                                                            <div class="comment__submit d-flex justify-content-end">
                                                                <input type="submit" class="" value=" أضف تعليقاً" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comments">
                                        <div class="row">
                                            @foreach($lesson_data->comments as $comment)
                                            <div class="col-12">
                                                    <div class="commment__card d-flex">
                                                        <div class="commment__left d-flex flex-column align-items-center">
                                                            <div class="__img">
                                                                <img src="{{ isset($comment->user->subscriber->image) ? asset($comment->user->subscriber->image) :  asset('assets/icons/profile-picture.svg') }}" alt="user" class="img-fluid">
                                                            </div>
                                                            <p class="user__tag">مشترك</p>
                                                        </div>
                                                        <div class="commment__right">
                                                            <p class="comment__auth">{{ $comment->user->subscriber->full_name ?? 'Unknown' }}</p>
                                                            <p class="comment__body">
                                                                {{ $comment->comment }}
                                                            </p>
                                                            <div class="comment__down d-flex justify-content-between align-items-center">
                                                                <div class="comment__date">
                                                                    <i class="fa-regular fa-clock"></i>  :
                                                                    {{ \Carbon\Carbon::parse($comment->created_at)->format('d/m/Y -  H:i:s') }}
                                                                </div>
                                                                <div class="comments__btns d-flex justify-content-between align-items-center">
                                                                    <div class="comment__button cen-row">
                                                                        <i class="fa-regular fa-comment"></i>
                                                                        reply
                                                                    </div>
                                                                    <div class="comment__button cen-row">
                                                                        <i class="fa-regular fa-thumbs-up"></i>
                                                                        Like
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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


@endauth


@include('website.static.footer')

