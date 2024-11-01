@include('website.static.navbar')



<!-- ⭐⭐⭐⭐⭐ layout  ⭐⭐⭐⭐⭐-->
<div class="layout-main register__main">
    <div class="container-fluid">
        <div class="d-flex layout-row">
            <div class="layout-main">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="img__top cen-row">
                                        <img src="{{ asset('assets/dexter/src/images/reham-logo-arabic-white.png') }}" class="img-fluid" alt="logo" width="180">
                                    </div>
                                </div>
                                <div class="col-12 d-md-flex align-items-center justify-content-center">
                                    <form  action="{{ route('signup.post') }}" method="post" class="__form @if (count($errors) > 0)--warning @endif d-flex flex-column justify-content-center align-items-center">
                                        @csrf
                                        <div class="form__header">
                                            <p class="heading">
                                                تسجيل جديد
                                            </p>
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <input type="text"  placeholder="الإسم الأول" class="__input" name="first_name" required/>
                                                <i class="fa-regular fa-circle-user __icon-left"></i>
                                            </div>
                                            @if ($errors->has('first_name'))
                                            <div class="warrning__message">
                                                <p class="message">
                                                    الاسم الأول مطلوب
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <input type="text" placeholder="الإسم الأخير" class="__input" name="last_name" required/>
                                                <i class="fa-regular fa-circle-user __icon-left"></i>
                                            </div>
                                            @if ($errors->has('last_name'))
                                            <div class="warrning__message">
                                                <p class="message">
                                                    الإسم الأخير مطلوب
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <select name="country_id" class="__input" aria-label="Default select example" id="Country"
                                                style="background-color: #f3f3f3;
  text-align: right;
  border-radius: 50px;
  padding: 15px 70px;
  border: 2px solid #eb8eba;
  width: 100%;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
  font-size: 1.4rem;"
                                                 required>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="fa-regular fa-flag __icon-left"></i>
                                            </div>
                                            @if ($errors->has('country_id'))
                                            <div class="warrning__message">
                                                <p class="message">
                                                    اسم الدولة مطلوب
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <input type="phone" placeholder="الهاتف" class="__input" name="mobile_number" required/>
                                                <i class="fa-solid fa-phone  __icon-left"></i>
                                            </div>
                                            @if ($errors->has('mobile_number'))
                                            <div class="warrning__message">
                                                <p class="message">
                                                    اسم الهاتف مطلوب
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <input type="email" name="email" placeholder="البريد الإلكتروني" class="__input" required/>
                                                <i class="fa-solid fa-envelope __icon-left"></i>
                                            </div>
                                            @if ($errors->has('email'))
                                            <div class="warrning__message">
                                                <p>
                                                    البريد الالكتروني مطلوب
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <input type="email" name="email_confirm" placeholder="البريد الإلكتروني" class="__input" required/>
                                                <i class="fa-solid fa-envelope __icon-left"></i>
                                            </div>
                                            @if ($errors->has('email_confirm'))
                                            <div class="warrning__message">
                                                <p>
                                                    يرجي تاكيد البريد الالكتروني
                                                </p>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-circle-exclamation __icon-right --warrning"></i>
                                                <input name="password" type="password" minlength="8" placeholder="كلمة السر" class="__input" required/>
                                                <i class="fa-solid fa-key __icon-left"></i>
                                            </div>
                                            @if ($errors->has('password'))
                                            <div class="warrning__message">
                                                <p class="message">
                                                    كلمة السر مطلوبة
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="input__field">
                                            <div class="input__container">
                                                <i class="fa-solid fa-right-to-bracket __icon-submit"></i>
                                                <input type="submit" value="تسجيل" class="__input _submit --gray"/>
                                            </div>
                                        </div>
                                        <div class="form__down d-flex align-items-center">
                                            <p>هل لديك حساب فعال؟</p>
                                            <a href="{{ route('user.login') }}" class="link">
                                                تسجيل الدخول
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
