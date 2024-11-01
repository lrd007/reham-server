@extends('layouts.vertical', ['title' => __('Event')])

@section('css')
<!-- Plugins css -->
<link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ __('Event') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <form id="blogForm" action="{{ $action }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($event))
                    {{ method_field('PUT') }}
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                <input type="text" name="title_ar" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$event->title_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                <input type="text" name="title_en" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$event->title_en }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Description') }} AR<span class="text-danger"></span></label>
                                <input type="text" name="description_ar" class="form-control" placeholder="{{ __('Description') }}" value="{{ @$event->description_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Description') }} EN<span class="text-danger"></span></label>
                                <input type="text" name="description_en" class="form-control" placeholder="{{ __('Description') }}" value="{{ @$event->description_en }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Link') }}<span class="text-danger"></span></label>
                                <input type="text" name="link" class="form-control" placeholder="{{ __('Link') }}" value="{{ @$event->link }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="start_date" class="form-control" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$event->start_date }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Image') }} <span class="text-danger"></span></label>
                                <input type="file" name="image" placeholder="{{ __('Image') }}" class="form-control">
                                @if(@$event->image)
                                <a href="{{ url(uploads_images('event', null,true) . '/' . $event->image) }}" target="_blank">{{ $event->image }}</a>
                                <input type="hidden" name="old_image" value="{{ $event->image }}">
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6 ">
                            <div class="radio radio-warning form-check-inline ml-1">
                                <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$event->schedule) checked @endif>
                                <label> {{ __('Schedule') }} </label>
                            </div>
                            <div class="radio radio-success form-check-inline">
                                <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$event->schedule) checked @endif>
                                <label>{{ __('Post Now') }} </label>
                            </div>
                        </div>
                        @if(Route::currentRouteName() == 'event.create')
                         <div class="col-sm-6 ">
                            <div class="">
                                <input type="checkbox" id="send_emails" name="send_emails" value="1">
                                <label class="" for="customSwitch">{{ __('Mail to all active subscriber') }}</label>
                            </div>
                        </div> 
                        @endif
                        <!-- <div class="col-sm-6 ">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="status" class="custom-control-input status-switch" id="customSwitch" @if(@$affiliate->status==1) checked @endif>
                                <label class="custom-control-label" for="customSwitch">{{ __('Active') }}</label>
                            </div>
                        </div> -->
                        <!-- <div class="custom-control custom-switch">
                            <input type="checkbox" name="status" class="custom-control-input status-switch" id="customSwitch'. $id .'" '. $isChecked .'>
                            <label class="custom-control-label" for="customSwitch'. $id .'">'. isActive($isDeleted, true) .'</label>
                        </div> -->
                    </div>

                    <div class="row" style="{{ !@$event->schedule ? 'display: none;' : '' }}">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$event->schedule }}" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Plugins js-->
<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>

<!-- Page js-->
<script src="{{asset('assets/js/modules/course/course.js')}}"></script>
@endsection