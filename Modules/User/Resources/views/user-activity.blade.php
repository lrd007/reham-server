@extends('layouts.vertical', ['title' => 'User Activity'])
@section('css')
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">User Activity</h4>
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
@section('script')
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
@endsection