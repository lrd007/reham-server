
@extends('layouts.vertical', ['title' => __('Course')])

@section('css')
    <!-- Plugins css -->
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">                
                    @can('course.create')
                        <div class="row d-flex flex-row-reverse mb-2">                            
                            <div class="col-auto">
                                <button class="btn btn-secondary modal-button" type="button" data-url="{{ route('course.list.filter') }}" data-toggle="modal">{{ __('Filter') }}</button>
                                <a class="btn btn-primary waves-effect waves-light text-right" href="{{ route('course.create') }}" >{{ __('Add New') }}</a>
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
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
@endsection