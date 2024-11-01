@include('website.static.navbar')

@auth()

    <!-- ⭐⭐⭐⭐⭐ breadcrumb  ⭐⭐⭐⭐⭐-->
    <div class="bottom__nav">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6 d-none d-md-block">
                    <div class="nav__breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 ">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('all_programs') }}">برامجي</a></li>
                                <li class="breadcrumb-item"><a href="{{route('bonus-material',['program_id' => $program_data->id, 'bonus_id' => $bonus_data->id])}}">مواد إضافية </a></li>

                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-md-6 col-12 d-flex justify-content-md-end justify-content-center">
                    <div class="progress__program text-center">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 🚫🚫🚫🚫  breadcrumb 🚫🚫🚫🚫-->

    <!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
    <div class="layout-main">
        <div class="container-fluid">
            <div class="d-flex layout-row">
                <div class="layout-main getting-started-main">
                    <div class="container custom-container">
                        <div class="row">
                            @foreach($bonus_data->materials as $material)
                                <div class="col-12">
                                    <div class="lesson-card cen-col" >
                                        <header class="header  cen-col">

                                            <p class="sub__heading text-center">
                                                {!! $material->description_ar !!}
                                            </p>

                                        </header>
                                        <div class="video__container cen-row">

                                            <iframe
                                                title="vimeo-player"
                                                src="{{ GetVimeoFrameLink($material->file) }}"
                                                frameborder="0"
                                                width="800px"
                                                height="550px"
                                                allowfullscreen>
                                            </iframe>
                                        </div>


                                    </div>
                                </div>

                            @endforeach


                            <div class="col-12">
                                <div class="lesson-comments">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="header">
                                                <p class="heading text-center">
                                                    اتركي تعليقك
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
                                                        <form method="post" action="{{ route('add-bonus-comment',$bonus_data->id) }}" class="__form d-flex">
                                                            {{ csrf_field() }}

                                                            <div class="user__img">
                                                                @if(\Illuminate\Support\Facades\Auth::user()->subscriber)
                                                                    <img src="{{ asset(\Illuminate\Support\Facades\Auth::user()->subscriber->image) }}" class="__img" alt="user">
                                                                @else
                                                                    <img src="https://reham.com/assets/icons/profile-picture.svg" class="__img" alt="user">
                                                                @endif
                                                            </div>

                                                            <textarea name="comment" style="border: 1px solid #ffbdea;border-radius: 10px" rows="3" class="comment__area" placeholder="انضم الى النقاشات">
                                                            </textarea>
                                                            <div class="text-end mt-2">
                                                                <button type="submit" class="btn btn--border-white btn-lg px-5 w-auto  btn btn-primary-01"
                                                                        style="color: #fff;
    background-color: #eb8eba;
    padding: 8px 30px;
    font-size: 1.1rem;
    border-radius: 10px;
    font-weight: 700;"
                                                                >
                                                                    أضف تعليقاً
                                                                </button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="comments__status d-flex align-items-center justify-content-between">
                                                <div class="box__right  d-flex align-items-center">
                                                    <img  src="https://reham.com/assets/icons/profile-picture.svg" alt="tetsimoniales">
                                                    <img  src="https://reham.com/assets/icons/profile-picture.svg" alt="tetsimoniales">
                                                    <img  src="https://reham.com/assets/icons/profile-picture.svg" alt="tetsimoniales">
                                                    <img  src="https://reham.com/assets/icons/profile-picture.svg" alt="tetsimoniales">
                                                    <div class="comment__count">
                                                        {{ $bonus_data->comments->count() }}
                                                        <i class="fa-solid fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="box__left d-flex align-items-center">
                                                    <div class="comment__count">
                                                        {{ $bonus_data->comments->count() }}
                                                        <i class="fa-regular fa-comment"></i>
                                                    </div>
                                                    <div class="comment__count">
                                                        {{ $bonus_data->comments->count() }}
                                                        <i class="fa-solid fa-list"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comments">
                                        <div class="row">
                                            @foreach($bonus_data->comments as $comment)
                                                <div class="col-12">
                                                    <div class="commment__card d-flex">
                                                        <div class="commment__left d-flex flex-column align-items-center">
                                                            <div class="__img">
                                                                <img src="{{ isset($comment->user->subscriber->image) ? asset($comment->user->subscriber->image) :  asset('assets/icons/profile-picture.svg') }}" alt="user" class="img-fluid">
                                                            </div>
                                                            <p class="user__tag">Member</p>
                                                        </div>
                                                        <div class="commment__right">
                                                            <p class="comment__auth">{{ $comment->user->subscriber->full_name ?? 'Unknown' }} </p>
                                                            <p class="comment__body">
                                                                {{ $comment->comment }}
                                                            </p>
                                                            <div class="comment__down d-flex justify-content-between align-items-center">
                                                                <div class="comment__date">
                                                                    {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                                                </div>
                                                                <div class="replay__button cen-row">
                                                                    <i class="fa-regular fa-comment"></i>
                                                                    replay
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

