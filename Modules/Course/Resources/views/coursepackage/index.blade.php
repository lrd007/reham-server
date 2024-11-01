@extends('layouts.vertical', ['title' => __('Course Package')])

@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Course Package') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('course_package.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary waves-effect waves-light text-right modal-button" data-url="{{ route('coursepackage.create') }}" data-toggle="modal" >{{ __('Add New') }}</button>
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