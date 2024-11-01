@extends('layouts.vertical', ['title' => __('Payment')])


@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Payment') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex flex-row-reverse mb-2">
                        <div class="col-auto">
                            <button class="btn btn-secondary modal-button" type="button" data-url="{{ route('payment.enrollment.filter') }}" data-toggle="modal">{{ __('Filter') }}</button>
                                <div class="btn-group" role="group">
                                    <button id="exportButton" type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Export') }}</button>
                                    <div class="dropdown-menu" id="exportButtonDrop">
                                        <a data-href="{{ route('payment-list.enrollment.excel') }}" class="dropdown-item"><img src="{{ asset('images/csv.png') }}" height="20px"> {{ __('CSV') }} </a>
                                        <a data-href="{{ route('payment-list.enrollment.pdf') }}" class="dropdown-item"><img src="{{ asset('assets/images/pdf.png') }}" height="20px"> {{ __('PDF') }} </a>
                                    </div>
                                </div>
                        </div>
                    </div>
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