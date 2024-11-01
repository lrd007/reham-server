
@extends('layouts.vertical', ['title' => __('Notification Center')])
@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Notification Center') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('notification.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <a class="btn btn-primary waves-effect waves-light text-right" href="{{ route('notificationcenter.create') }}" >{{ __('Add New') }}</a>
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
    <script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
@endsection
@section('script-bottom')
    <script src="{{asset('assets/js/modules/notification/notification.min.js')}}"></script>
@endsection