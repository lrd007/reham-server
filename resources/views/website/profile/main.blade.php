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
                                        <li class="nav__item ">
                                            <a href="{{ route('updatePassword') }}">
                                                تغيير كلمة المرور
                                            </a>
                                        </li>
                                        <li class="nav__item --active">
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
                                       {{-- <li class="nav__item">
                                            <a href="{{ route('com') }}">
                                                تعليقات
                                            </a>
                                        </li>--}}
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9 col-12">
                                <div class="card__container change__photo">
                                    <form  class="submit__profile" action="{{ route('update_profile_image') }}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert">
                                                    <p class="heading">
                                                        تغير الصورة الشخصية:
                                                    </p>
                                                    <p class="__text">
                                                        لتبسيط الأمور ، نستخدم (الصور الرمزية المعترف بها عالميًا). لتعيين صورة ملفك الشخصي ، كل ما عليك فعله هو إنشاء حساب مجاني مع. سيرشدونك إلى كيفية تحميل صورتك.
                                                    </p>
                                                    <p class="__text">
                                                        بمجرد التحميل ، ستظهر صورتك تلقائيًا ليس فقط داخل هذه البوابة ولكن أيضًا تقريبًا في كل موقع ويب يعمل بنظام ولديك معلومات تسجيل دخول على الإنترنت
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input__container __submit">
                                                    <input class="form-control" type="file" name="profile" placeholder="chosse image" accept="image/png, image/gif, image/jpeg" required />
                                                    <input type="submit"  value="تغييرالصورة" class="__input ">
                                                </div>
                                            </div>
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
    <!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->

@endauth


@include('website.static.footer')
