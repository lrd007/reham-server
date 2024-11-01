@extends('frontend.layouts.master')
@section('content')
<!--Login Body-->
<Section class="LoginBody py-3 text-center " id="LoginBody">
  <img src="frontend/images/logo.svg" alt="logo" class="logo">
  <img src="frontend/images/LoginBg.svg" alt="LoginBg">
  <div class="container-fluid">
    <div class="row ">
      <div class="col-12  d-flex  justify-content-center">
        <div class="LoginForm RightBottomCorner  ">
          <h4 class="ms-4"><b> Glad To See You! </b></h4>

          <p class="ms-4">You’re one password away from creating
            <br>
            something amazing
          </p>
          <form action="{{ route('user.login') }}" method="POST" novalidate class="mt-4 text-center">
            @csrf
            <div class="mb-4  position-relative">
              <i class="fa-regular fa-envelope"></i>
              <input name="email" type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>
              @if ($errors->has('email'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="mb-3 position-relative">
              <img src="frontend/images/password Icon.svg" alt="password Icon">

              <input name="password" type="password" class="form-control password  @if ($errors->has('password')) is-invalid @endif" id="exampleInputPassword1" placeholder="Password" required>
              <i class="fa-solid fa-eye float-end Showpass"></i>
              @if ($errors->has('password'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
            <p class="float-end my-3"><a href="ForgotPassword.html"><b>Forget Password <i class="fa-solid fa-question"></i></b></a></p>
            <button type="submit" class="btn btn-primary  position-relative ">Login <i class="fa-solid fa-right-to-bracket"></i></button>
          </form>
          <p class=" text-center mt-3" id="LoginOrRegister">You don't Have an accout? <span><a href="{{route('signup')}}">Register</a></span></p>

        </div>
      </div>
    </div>
  </div>
</Section>

<!--End Login Body-->
@endsection
