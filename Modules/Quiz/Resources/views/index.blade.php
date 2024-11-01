@extends('layouts.vertical', ['title' => __('Quiz')])
@section('css')
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('quiz.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Export') }}</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a href="{{route('quiz.export.excel')}}" class="dropdown-item"><img src="{{ asset('assets/images/excel.png') }}" height="20px"> {{ __('Excel') }}</a>
                                        <a href="{{route('quiz.export.pdf')}}" class="dropdown-item"><img src="{{ asset('assets/images/pdf.png') }}" height="20px"> {{ __('PDF') }}</a>
                                    </div>
                                </div>
                                <a class="btn btn-primary waves-effect waves-light text-right" href="{{ route('quiz.create') }}" >{{ __('Add New') }}</a>
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

    <script>
        $(document).on("click", ".post-or-schedule", function(){
            $val = $(this).val();
            $val == 1 ? $("#schedule").closest('.row').show() : $("#schedule").closest('.row').hide();
        });
    </script>
@endsection