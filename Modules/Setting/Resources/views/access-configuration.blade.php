@extends('layouts.vertical', ['title' => 'Access Configuration'])

@section('css')
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Access Configuration</h4>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-3">
                                <div class="avatar-md bg-info rounded">
                                    <i class="fe-cpu avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-end">
                                    <h3 class="text-dark mt-0 mb-1">Admin User</h3>
                                    <p class="text-muted mb-1"><a href="#">View</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-3">
                                <div class="avatar-md bg-success rounded">
                                    <i class="fe-aperture avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-end">
                                    <h3 class="text-dark mt-0 mb-1">Permission</h3>
                                    <p class="text-muted mb-1"><a href="#">View</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-3">
                                <div class="avatar-md bg-warning rounded">
                                    <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-end">
                                    <h3 class="text-dark mt-0 mb-1">Role</h3>
                                    <p class="text-muted mb-1"><a href="#">View</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-3">
                                <div class="avatar-md bg-secondary rounded">
                                    <i class="fe-layers avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="text-end">
                                    <h3 class="text-dark mt-0 mb-1">User Activity</h3>
                                    <p class="text-muted mb-1"><a href="#">View</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
@endsection