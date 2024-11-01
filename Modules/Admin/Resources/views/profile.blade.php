
@extends('layouts.vertical', ['title' => __('My Profile')])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('My Profile') }}</h4>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="registerWizard">
                        <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                            <li class="nav-item" data-target-form="#accountForm">
                                <a href="#first" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <span class="d-none d-sm-inline">{{ __('Profile') }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-0 b-0 pt-0">
                            <div class="tab-pane active" id="first">
                                <form action="{{ $action }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('Name') }}</label><span class="text-danger">*</span>
                                                <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$admin->name }}" required />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('Email') }}</label><span class="text-danger">*</span>
                                                <input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ @$admin->email }}" required />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3 mt-3">
                                        <li class="nav-item" data-target-form="#accountForm">
                                            <a href="#first" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                                <span class="d-none d-sm-inline">{{ __('Update Password') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('Current Password') }}</label>
                                                <input type="password" name="current_password" class="form-control" placeholder="{{ __('Current Password') }}" required />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('New Password') }}</label>
                                                <input type="password" name="password" class="form-control" placeholder="{{ __('New Password') }}" required />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <button type="button" class="global-save btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
@endsection
