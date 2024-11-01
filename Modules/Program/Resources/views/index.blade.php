@extends('layouts.vertical', ['title' => __('Program')])
@section('css')
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .navigation:hover {
            color: #ea8bb8 !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Program') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('program.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <a class="btn btn-primary waves-effect waves-light text-right" href="{{ route('program.create') }}" >{{ __('Add New') }}</a>
                            </div>
                        </div>
                        <hr>
                    @endcan
                    @include('layouts.shared/data-table')
                </div>
            </div>
        </div>
        
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
@endsection