<html>
    <head>
        @include('layouts.shared/title-meta', ['title' => 'Reham'])
        @include('layouts.shared/head-css')
        <style>
            .footer{
                color: #ffffff;
                left: 0;
                background-color: #ea8bb8;
                position: unset;
            }
        </style>
    </head>
    <body>
        <div class="navbar-custom" style="position: inherit;">
            <input type="hidden" id="baseUrl" value="http://127.0.0.1:8000">
            <input type="hidden" id="local" value="en">
            <div class="container-fluid">
                <div class="logo-box">
                    <a href="#" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="http://127.0.0.1:8000/assets/images/logo-light.png" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="http://127.0.0.1:8000/assets/images/logo-light.png" alt="" height="30">
                        </span>
                    </a>
                    <a href="#" class="logo logo-light text-center">
                        <span class="logo-sm">
                            @if(!empty(setting('site_logo')))
                                <img src="{{ url(uploads_files('site', null,true) . '/' . setting('site_logo')) }}" alt="" height="55">
                            @else
                                <img src="{{ url('/assets/images/Mini-Logo.jpg') }}" alt="" height="55">
                            @endif
                        </span>
                        <span class="logo-lg">
                            @if(!empty(setting('site_logo')))
                                <img src="{{ url(uploads_files('site', null,true) . '/' . setting('site_logo')) }}" alt="" height="60">
                            @else
                                <img src="{{ url('/assets/images/admin-logo.png') }}" alt="" height="60">
                            @endif                            
                        </span>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="container">
            <h3 class="mt-4 mb-4">{{ __('Suggested Courses') }}</h3>

            <div class="row">
                @foreach($courses as $course)
                    <div class="col-sm-4">
                        <div class="card card-body text-center" style="background-color: #ea8bb8;">
                            <h5 class="card-title">{{ $course->{'name' . withLocalization()} }}</h5>

                            <p class="card-text">
                                <img src="{{ url(uploads_images('course', null,true) . '/' . $course->thumb_image) }}" alt="" height="150px">
                            </p>
                            <p class="card-text">
                                <button class="btn btn-default waves-effect waves-light" style="border-radius: 50px;border: 1px solid white;">{{ __('View') }}</button>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4 text-center">
                    <!-- Content -->
                        @if(!empty(setting('site_logo')))
                            <img src="{{ url(uploads_files('site', null,true) . '/' . setting('site_logo')) }}" class="mb-2" alt="" height="150">                        
                        @else
                            <img src="{{ url('/assets/images/admin-logo.png') }}" alt="" height="60">
                        @endif                      
                        <p>
                            {{ setting('footer_about' . withLocalization()) }}
                        </p>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                                <h6 class="text-white font-weight-bold mb-4">
                                    {{ __('Usefull Links') }}
                                </h6>
                                <p>
                                    <a href="#!" class="text-reset">{{ __('Program') }}</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">{{ __('Login') }}</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">{{ __('Registration') }}</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                                <h6 class="text-white font-weight-bold mb-4">
                                {{ __('About Us') }}
                                </h6>
                                <p>
                                    <a href="#!" class="text-reset">{{ __('About') }}</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">{{ __('FAQs') }}</a>
                                </p>
                                <p>
                                    <a href="#!" class="text-reset">{{ __('Legal') }}</a>
                                </p>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                                <h6 class="text-white font-weight-bold mb-4">
                                    {{ __('Contact') }}
                                </h6>
                                <p>
                                    <i class="fas fa-envelope me-3"></i>
                                    {{ setting('footer_contact_email') }}
                                </p>
                                <p><i class="fas fa-phone me-3"></i> {{ setting('footer_contact_phone_no') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <hr class="mt-0">
                            </div>
                            <div class="col-sm-12 text-center">
                                @if(!empty(setting('footer_facebook_url')))
                                    <a href="{{ setting('footer_facebook_url') }}" class="m-2 text-reset" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif

                                @if(!empty(setting('footer_twitter_url')))
                                    <a href="{{ setting('footer_twitter_url') }}" class="m-2 text-reset" target="_blank"><i class="fab fa-twitter"></i></a>
                                @endif

                                @if(!empty(setting('footer_intagram_url')))
                                    <a href="{{ setting('footer_intagram_url') }}" class="m-2 text-reset" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif

                                @if(!empty(setting('footer_pinterest_url')))
                                    <a href="{{ setting('footer_pinterest_url') }}" class="m-2 text-reset" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                                @endif

                                @if(!empty(setting('footer_google_plus_url')))
                                    <a href="{{ setting('footer_google_plus_url') }}" class="m-2 text-reset" target="_blank"><i class="fab fa-google"></i></a>
                                @endif

                                @if(!empty(setting('footer_linkedin_url')))
                                    <a href="{{ setting('footer_linkedin_url') }}" class="m-2 text-reset" target="_blank"><i class="fab fa-linkedin"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>