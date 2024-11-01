@include('website.static.navbar')

@auth()

    <!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
    <div class="layout-main  sections-main">
        <div class="container-fluid">
            <div class="d-flex layout-row">
                <div class="layout-main profile__main">
                    <div class="container custom-container">
                        <div class="row">
                            <div class="col-12">
                                <header class="section-heading">
                                    <h3 class="heading text-center">
                                        الملف الشخصي
                                    </h3>
                                    <p class="sub__heading text-center">
                                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                    </p>
                                    <p class="sub__heading text-center">
                                        {{ \Illuminate\Support\Facades\Auth::user()->email }}
                                    </p>
                                </header>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="img__card">
                                    @if(\Illuminate\Support\Facades\Auth::user()->subscriber)
                                        <img src="{{ asset(\Illuminate\Support\Facades\Auth::user()->subscriber->image) }}" class="img-fluid" alt="">
                                    @else
                                        <img src="https://reham.com/assets/icons/profile-picture.svg" class="img-fluid" alt="">
                                    @endif
                                </div>
                                <div class="nav__card">
                                    <ul class="list-unstyled nav__items cen-col">
                                        <li class="nav__item --active">
                                            <a href="{{ route('updatePassword') }}">
                                                تغيير كلمة المرور
                                            </a>
                                        </li>
                                        <li class="nav__item ">
                                            <a href="{{ route('profile') }}">
                                                الصورة الشخصية
                                            </a>
                                        </li>
                                        <li class="nav__item">
                                            <a href="{{ route('payment') }}">
                                                بطاقة ائتمان
                                            </a>
                                        </li>
                                        <li class="nav__item">
                                            <a href="{{ route('all_programs') }}">
                                                برامجك
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9 col-12">
                                <div class="card__container change__password">
                                    <form action="{{ route('update_password') }}" method="post" class="submit__profile">
                                        @csrf
                                        @if(session('error'))
                                            {{ session('error') }}
                                            @endif
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input__container">
                                                    <label class="d-block label__top">
                                                        تغيير كلمة المرور
                                                    </label>
                                                    <div class="input__container">
                                                        <input type="password" name="current_password" required minlength="8" placeholder="كلمة المرور الحالية" class="__input">
                                                    </div>
                                                    <br />
                                                    <input type="password" name="new_password" required minlength="8" placeholder="كلمة المرور الجديدة" class="__input">
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="input__container">
                                                    <input type="password" name="new_password_confirmation" required minlength="8" placeholder="اعد كلمة المرور الجديدة" class="__input">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input__container __submit">
                                                    <input type="submit" value="تغيير كلمة المرور" class="__input ">
                                                </div>
                                            </div>
                                            </div>
                                    </form>
                                    <div class="alert__bottom">
                                        <p class="__text">
                                            الرجاء ملاحظة: بتغييركلمة المرور الحالية ، فإنك تقوم بتغيير معلومات تسجيل الدخول والبريد الإلكتروني الرئيسي لجهة الاتصال. ستحتاج إلى تسجيل الخروج والعودة مرة أخرى بعد إجراء هذا التغيير .
                                        </p>
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
