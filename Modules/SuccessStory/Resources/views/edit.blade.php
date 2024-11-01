@extends('layouts.vertical', ['title' => __('Success Story')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Success Story') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form id="chapterInfoForm" action="{{ $action }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($successstory))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Title') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$successstory->title }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Comment') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="comment" class="form-control" placeholder="{{ __('Comment') }}" value="{{ @$successstory->comment }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label >{{ __('Video') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="file" placeholder="{{ __('Image') }}" class="form-control">
                                    @if(@$successstory->file)
                                        <a href="{{ url(uploads_files('success_story', null,true) . '/' . $successstory->file) }}" target="_blank">{{ $successstory->file }}</a>
                                        <input type="hidden" name="old_file" value="{{ $successstory->file }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-6 ">
                                <div class="radio radio-warning form-check-inline ml-1">
                                    <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$chapter->schedule) checked @endif>
                                    <label> {{ __('Schedule') }} </label>
                                </div>
                                <div class="radio radio-success form-check-inline">
                                    <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$chapter->schedule) checked @endif>
                                    <label>{{ __('Post Now') }} </label>
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="row" style="{{ !@$chapter->schedule ? 'display: none;' : '' }}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$chapter->schedule }}" readonly="readonly">
                                </div>
                            </div>
                        </div> -->
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