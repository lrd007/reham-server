<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared.title-meta', ['title' => "Log In"])
    @include('layouts.shared.head-css')
    <style>
        input, button{
            border-radius: 20px !important;
            text-align: center;
        }

    </style>
</head>

<body style="background-image: url({{ asset('assets/images/Reham-Diva-10.png') }}); background-repeat:no-repeat; background-position: right; background-attachment: fixed;
background-size:contain; background-attachment: fixed;background-color:#ea8bb8;">
    <div class="account-pages mb-5" >    
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img src="{{ asset('assets/images/Reham_Diva-08-removebg-preview.png') }}" style="height:250px">
                </div>
            </div>           
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 50px 0px 50px 50px;">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="{{ route('user.login') }}" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <h2 style="margin-top: 18px;margin-left: 20px;font-family: cursive;color:#ea8bb8;">REHAM DIVA</h2>
                                        </span>
                                    </a>
                                    <a href="{{ route('user.login') }}" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <h2 style="margin-top: 18px;margin-left: 20px;font-family: cursive;color:#ea8bb8;">REHAM DIVA</h2>
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">1Enter your email address and password to access panel.
                                </p>
                            </div>
                            <form action="{{ route('user.login') }}" method="POST" novalidate>
                                @csrf
                                <div class="form-group mb-3">
                                    <input class="form-control  @if ($errors->has('email')) is-invalid @endif" name="email" type="email"
                                        id="emailaddress" required="" value="{{ old('email') }}"
                                        placeholder="Enter your email" />
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <a href="#" class="text-muted float-right"><small></small></a>
                                    <div class="input-group input-group-merge @if ($errors->has('password')) is-invalid @endif">
                                        <input class="form-control @if ($errors->has('password')) is-invalid @endif" name="password"
                                            type="password" required="" id="password"
                                            placeholder="Enter your password" />
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group mb-3 text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin"
                                            checked>
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-default btn-block" type="submit"> Forgot your password? </button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <!-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a href="#" class="text-white-50 ml-1">Forgot your password?</a></p>
                            <p class="text-white-50">Don't have an account? <a href="{{ route('user.register.step.one.get') }}"
                                    class="text-white ml-1"><b>Register</b></a></p>
                        </div>
                    </div> -->
                    <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    @include('layouts.shared.footer-alt')
    @include('layouts.shared.footer-script')
</body>

</html>
