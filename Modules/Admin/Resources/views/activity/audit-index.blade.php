@extends('layouts.vertical', ['title' => 'Audit Log'])
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Audit Log</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.shared/data-table')
                </div>
            </div>
        </div>
        
    </div>
@endsection