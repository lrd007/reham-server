@extends('layouts.vertical', ['title' => __('Coupon')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Coupon') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('coupon.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary waves-effect waves-light text-right modal-button" data-url="{{ route('coupon.create') }}" data-toggle="modal" >{{ __('Add New') }}</button>
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
    <script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
@endsection