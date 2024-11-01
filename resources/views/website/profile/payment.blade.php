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
                                        <li class="nav__item">
                                            <a href="{{ route('profile') }}">
                                                الصورة الشخصية
                                            </a>
                                        </li>
                                        <li class="nav__item  --active">
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
                                <div class="card__container user__bills">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="header">
                                                <p class="heading">
                                                    برامجك مع ريهام هاوس
                                                </p>
                                                <p class="sub__heading">
                                                    يمكنك مراجعة سجلات مراجعة الشراء الخاصة بك ادناه
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <table class="table__bills">
                                                <tr>
                                                    <th>
                                                        <div class="t__h">
                                                            اسم البرنامج
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="t__h">
                                                            تعريف الاشتراك
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="t__h">
                                                            حالة البرنامج
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="t__h">
                                                            التجديد
                                                        </div>
                                                    </th>
                                                </tr>
                                                {{--<tr class="t__r">
                                                    <td>
                                                        <div class="t__d program__name">
                                                            اسم افتراضي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            3 شهور
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            منتهي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            <button class="renew__btn">
                                                                <a href="#">
                                                                    طلب التجديد
                                                                </a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="t__r">
                                                    <td>
                                                        <div class="t__d program__name">
                                                            اسم افتراضي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            3 شهور
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            منتهي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            <button class="renew__btn">
                                                                <a href="#">
                                                                    طلب التجديد
                                                                </a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="t__r">
                                                    <td>
                                                        <div class="t__d program__name">
                                                            اسم افتراضي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            3 شهور
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            منتهي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            <button class="renew__btn">
                                                                <a href="#">
                                                                    طلب التجديد
                                                                </a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="t__r">
                                                    <td>
                                                        <div class="t__d program__name">
                                                            اسم افتراضي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            3 شهور
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            فاعلة
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            <button class="renew__btn">
                                                                <a href="#">
                                                                    طلب التجديد
                                                                </a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="t__r">
                                                    <td>
                                                        <div class="t__d program__name">
                                                            اسم افتراضي
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            3 شهور
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            فاعلة
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="t__d">
                                                            <button class="renew__btn">
                                                                <a href="#">
                                                                    طلب التجديد
                                                                </a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>--}}
                                            </table>
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
