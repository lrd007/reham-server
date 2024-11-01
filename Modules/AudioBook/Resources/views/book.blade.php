@extends('layouts.vertical', ['title' => __('Audio Book')])

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
                    <h4 class="page-title">{{ __('Audio Book') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form id="audiobookForm" action="{{ $action }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($audiobook))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Name') }} AR<span class="text-danger">*</span></label>
                                    <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$audiobook->name_ar }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Name') }} EN<span class="text-danger">*</span></label>
                                    <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$audiobook->name_en }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Author') }} AR<span class="text-danger">*</span></label>
                                    <input type="text" name="author_ar" class="form-control" placeholder="{{ __('Author') }}" value="{{ @$audiobook->author_ar }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Author') }} EN<span class="text-danger">*</span></label>
                                    <input type="text" name="author_en" class="form-control" placeholder="{{ __('Author') }}" value="{{ @$audiobook->author_en }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Chapter') }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="chapter" name="chapter" data-placeholder="{{ __('Select') }}">
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach($chapters as $key => $chapter)
                                            <option value="{{ $chapter->id }}" @if(isset($audiobook) && $audiobook->chapter_id == $chapter->id) {{ 'selected' }} @endif >{{ $chapter->{'name' . withLocalization()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('File') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="file" placeholder="{{ __('File') }}" class="form-control">
                                    @if(@$audiobook->file)
                                        <a href="{{ url(uploads_files('audiobook', null,true) . '/' . $audiobook->file) }}" target="_blank">{{ $audiobook->file }}</a>
                                        <input type="hidden" name="old_file" value="{{ $audiobook->file }}">
                                    @endif
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-sm-6 ">
                                <div class="radio radio-warning form-check-inline ml-1">
                                    <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$audiobook->schedule) checked @endif>
                                    <label> {{ __('Schedule') }} </label>
                                </div>
                                <div class="radio radio-success form-check-inline">
                                    <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$audiobook->schedule) checked @endif>
                                    <label>{{ __('Post Now') }} </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="is_playable" value="1" @if(isset($audiobook) && $audiobook->is_playable == 1) checked @endif)>
                                    <label class="form-check-label" for="inlineCheckbox1">{{ __('Playable') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="is_downloadable" value="1" @if(isset($audiobook) && $audiobook->is_downloadable == 1) checked @endif)>
                                    <label class="form-check-label" for="inlineCheckbox2">{{ __('Downloadable') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="{{ !@$audiobook->schedule ? 'display: none;' : '' }}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$audiobook->schedule }}" readonly="readonly">
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