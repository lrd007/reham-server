@include('website.static.navbar')



<!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
<div class="layout-main register__main">
    <div class="container-fluid">
        <div class="d-flex layout-row">
            <div class="layout-main">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="login__main">
                                <div class="col-12">
                                    <div class="img__top cen-row">
                                        <img src="{{ asset('assets/dexter/src/images/reham-logo-arabic-white.png') }}" class="img-fluid" alt="logo" width="180">
                                    </div>
                                </div>
                                <div class="col-12 d-md-flex align-items-center justify-content-center">
                                    <form action="{{ route('user.login') }}" method="POST" class="__form @if ($errors->has('email') || $errors->has('password')))--warning @endif d-flex flex-column align-items-center">
                                        @csrf
                                        <div class="form__header">
                                            <p class="heading">
                                                يسرنا إنضمامك معنا
                                            </p>
                                            <p class="sub__heading">
                                                أنتِ على بعد خطوة واحده من بدء أجمل تجربة في حياتك
                                            </p>
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right @if ($errors->has('email'))) --warrning @endif "></i>
                                                <input type="email"  name="email" placeholder="البريد الإلكتروني" class="__input @if ($errors->has('email')) is-invalid @endif" required/>
                                                <i class="fa-solid fa-envelope __icon-left"></i>
                                            </div>
                                            @if ($errors->has('email'))
                                                <div class="warrning__message">
                                                    <p>
                                                        يرجى إدخال بريد إلكتروني صحيح
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right @if ($errors->has('password'))) --warrning @endif "></i>
                                                <input type="password" name="password" placeholder="كلمة السر" class="__input @if ($errors->has('password'))) is-invalid @endif" required/>
                                                <i class="fa-solid fa-key __icon-left"></i>
                                            </div>

                                            @if ($errors->has('password'))
                                                <div class="warrning__message">
                                                    <p class="message">يرجى إدخال  سر صحيحة</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="link__down">
                                            <a href="{{route('forgot_password')}}" class="">
                                                نسيت كلمة السر ؟
                                            </a>
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-right-to-bracket __icon-submit"></i>
                                                <input type="submit" value="تسجيل الدخول" class="__input _submit"/>
                                            </div>
                                        </div>
                                        <div class="form__down d-flex align-items-center">
                                            <p>ليس لديك حساب؟</p>
                                            <a href="{{route('signup')}}" class="link">
                                                سجل هنا
                                            </a>
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
</div>
<!-- 🚫🚫🚫🚫  layout 🚫🚫🚫🚫-->

@include('website.static.footer')
