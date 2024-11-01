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
        <div class="navbar-custom">
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

        <div style="width: 100%;background-color: #ea8bb8;">
            <div class="container text-center">
                <video class="mt-5 mb-5" width="600" height="350" controls>
                    <source src="{{ url(uploads_files('landing_page_intro', null,true) . '/' . setting('landing_page_intro_video')) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @if(setting('subscriber_page_header_type') == 'video')
                    
                @elseif(setting('subscriber_page_header_type') == 'slider')

                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block img-fluid" src="assets/images/small/img-1.jpg" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="assets/images/small/img-2.jpg" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block img-fluid" src="assets/images/small/img-3.jpg" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="container">
            <h3 class="mt-4 mb-4">{{ __('Program') }}</h3>

            <div class="row">
                @foreach($programs as $program)
                    <div class="col-sm-4">
                        <div class="card card-body text-center">
                            <h5 class="card-title">{{ $program->{'name' . withLocalization()} }}</h5>

                            <p class="card-text">
                                <img src="{{ url(uploads_images('program', null,true) . '/' . $program->thumb_image) }}" alt="" height="150px">
                            </p>
                            <p class="card-text">
                                <button class="btn btn-primary waves-effect waves-light" style="border-radius: 50px;">{{ __('View') }}</button>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container">
            <h3 class="mt-4 mb-4">{{ __('Top Courses') }}</h3>

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

        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mt-4">{{ setting('subscriber_page_event_heading' . withLocalization()) }}</h3>
                    @if(setting('subscriber_page_event_type') == 'image' && !empty(setting('subscriber_page_event_image')))
                        @if(setting('subscriber_page_event_image_url'))
                            <a href="{{ url(setting('subscriber_page_event_image_url')) }}" target="_blank">
                                <img src="{{ url(uploads_files('landing_page', null,true) . '/' . setting('subscriber_page_event_image')) }}" alt="" height="300px">
                            </a>
                        @else                        
                            <img src="{{ url(uploads_files('landing_page', null,true) . '/' . setting('subscriber_page_event_image')) }}" alt="" height="300px">
                        @endif
                    @elseif(setting('subscriber_page_event_type') == 'video' && !empty(setting('subscriber_page_event_video')))
                        <video class="mb-5" width="450" height="250" controls>
                            <source src="{{ url(uploads_files('landing_page', null,true) . '/' . setting('subscriber_page_event_video')) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        {!! setting('subscriber_page_event_description' . withLocalization()) !!}
                        @if(!empty(setting('subscriber_page_event_image_url')))
                            <a href="{{ url(setting('subscriber_page_event_image_url')) }}" target="_blank">{{ __('Please click here for more details') }}</a>
                        @endif
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="card card-body text-center mt-4 mb-4" style="background-color: #ea8bb8;">
                        <h4 class="card-title">{{ __('Event') }}</h4>
                        <p class="card-text">
                            <button class="btn btn-default waves-effect waves-light" style="border-radius: 50px;border: 1px solid white;">{{ __('Save Date') }}</button>
                        </p>
                    </div>
                </div>
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