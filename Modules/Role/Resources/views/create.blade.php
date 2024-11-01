@extends('layouts.vertical', ['title' => 'Role'])

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Add Role</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        @include('role::form')
                    </div>
                </div>
            </div>            
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/pages/role/role.js')}}"></script>
@endsection