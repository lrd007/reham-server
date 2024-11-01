@include('website.static.head')

@if (!(request()->routeIs('user.login') ) && !(request()->routeIs('signup')) )

@guest()

    <!-- ⭐⭐⭐⭐⭐ navbar  ⭐⭐⭐⭐⭐-->
    <nav class="navbar__standard">
        <div class="container">
            <div class="row justify-content-around align-items-center">
                <div class="col-4 cen-row">
                    <div class="nav__link">
                        <a href="{{route('user.login')}}" >
                            تسجيل الدخول
                        </a>
                    </div>
                </div>
                <div class="col-4 cen-row">
                    <div class=nav__logo">
                        <a href="{{route('index')}}" >
                            <img src="{{ asset('assets/dexter/src/images/logo-pink.png') }}" alt="logo" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-4 cen-row">
                    <div class="nav__link">
                        <a href="{{ route('technical_support') }}" >
                            الدعم الفني
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </nav>
    <!-- 🚫🚫🚫🚫 navbar  🚫🚫🚫🚫-->

@endguest

@auth()
    <!-- ⭐⭐⭐⭐⭐ navbar  ⭐⭐⭐⭐⭐-->
    <nav class="navbar__main">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-3 col-12 col-xs-3">
                    <div class="nav__logo ">
                        <a class="navbar-brand" href="{{route('index')}}">
                            <img src="{{  asset('assets/dexter/src/images/reham-logo-arabic-white.png') }}" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-12 col-xs-9 col-md-6 d-flex justify-content-center justify-content-md-end">
                    <ul class="nav__items d-flex list-unstyled justify-content-center  justify-content-md-end">
                        <li class="nav__item __icon">
                            <a href="{{route('notification')}}" class="nav__link">
                                <i class="fa-regular fa-bell"></i>
                                <span>{{Auth::user()->notifications->count()}}</span>
                            </a>
                        </li>
                        <li class="nav__item __icon">
                            <a href="{{route('cart')}}" class="nav__link">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>{{Auth::user()->wishlist('cart')->count()}}</span>
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('index') }}#programs" class="nav__link">
                                البرامج
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('profile') }}" class="nav__link">
                                حسابك
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('technical_support') }}" class="nav__link">
                                الدعم الفني
                            </a>
                        </li>
                        <li class="nav__item">
                            <a href="{{ route('user.logout') }}" class="nav__link">
                                تسجيل الخروج
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </nav>
    <!-- 🚫🚫🚫🚫 navbar  🚫🚫🚫🚫-->



    @unless (request()->is('course_details') || request()->is('forgot_password') )
        @auth
            @include('website.static.aside')
        @endauth
    @endunless


@endauth
@endif
