@extends('layouts.vertical', ['title' => __('Course')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Course') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <ul class="nav nav-tabs nav-bordered">
                        <li class="nav-item">
                            <a href="#info-tab" data-toggle="tab" aria-expanded="false" class="nav-link active">{{ __('Info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#fee-tab" data-toggle="tab" aria-expanded="true" class="nav-link">{{ __('Fee') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#coupon-tab" data-toggle="tab" aria-expanded="false" class="nav-link">{{ __('Coupon') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#get-started-tab" data-toggle="tab" aria-expanded="false" class="nav-link">{{ __('Get Started') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="info-tab">
                            @include('course::general')
                        </div>
                        <div class="tab-pane" id="fee-tab">
                            @include('course::fee')
                        </div>
                        <div class="tab-pane " id="coupon-tab">
                            @include('course::coupon')
                        </div>
                        <div class="tab-pane " id="get-started-tab">
                            @include('course::get-started')
                        </div>                        
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>

    <!-- Page js-->
    <script src="{{asset('assets/js/modules/course/course.js')}}"></script>
@endsection