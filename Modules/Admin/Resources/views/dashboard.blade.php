@extends('layouts.vertical', ['title' => __('Dashboard')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/selectize/selectize.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('de6b58b8671fceb32c44', {
            cluster: 'ap2'
        });

        var privateChannel = pusher.subscribe("my-channel");
        privateChannel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
  </script>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Dashboard') }}</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        <input type="hidden" id="token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-5">
                            <!-- <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <i class="mdi mdi-account-tie font-22 avatar-title text-warning"></i>
                            </div> -->
                            <img class="img-fluid" src="{{ asset('assets/images/reham-favicon.png') }}" width="60px" height="60px"/>
                        </div>
                        <div class="col-7">
                            <div class="text-right">
                                <h3 class="mt-1"><span>{{ __('Admin') }}</span></h3>
                                <a href="{{ route('admin-user.index') }}" class="text-muted mb-1 text-truncate">{{ __('View All') }}</a>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->

            <div class="col-md-3">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-5">
                            <!-- <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="mdi mdi-account-tie font-22 avatar-title text-primary"></i>
                            </div> -->
                            <img class="img-fluid" src="{{ asset('assets/images/reham-favicon.png') }}" width="60px" height="60px"/>
                        </div>
                        <div class="col-7">
                            <div class="text-right">
                                <h3 class="text-dark mt-1"><span>{{ __('Subscribers') }}</span></h3>
                                <a href="{{ route('subscriber.index') }}" class="text-muted mb-1 text-truncate">{{ __('View All') }}</a>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
        
    </div> <!-- container -->
@endsection

@section('script')
    <!-- Plugins js-->
@endsection
