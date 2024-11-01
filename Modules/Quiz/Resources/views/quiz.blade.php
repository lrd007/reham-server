@extends('layouts.vertical', ['title' => __('Quiz')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Quiz') }}</h4>
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
                            <a href="#quiz-tab" data-toggle="tab" aria-expanded="true" class="nav-link">{{ __('Quiz') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="info-tab">
                            @include('quiz::general')
                        </div>
                        <div class="tab-pane" id="quiz-tab">
                            @include('quiz::question')
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('assets/libs/dragula/dragula.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/dragula.init.js')}}"></script>
    <script src="{{asset('assets/js/modules/quiz/quiz.js')}}"></script>
@endsection