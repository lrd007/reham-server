@extends('layouts.vertical', ['title' => __('Chapter')])

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
                    <h4 class="page-title">{{ __('Chapter') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form id="chapterInfoForm" action="{{ $action }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($chapter))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Name') }} AR<span class="text-danger">*</span></label>
                                    <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$chapter->name_ar }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Name') }} EN<span class="text-danger">*</span></label>
                                    <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$chapter->name_en }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label >{{ __('Course') }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="course" data-placeholder="{{ __('Select') }}">
                                        @foreach($courses as $key => $course)
                                            <option value="{{ $course->id }}" @if(isset($chapter) && $chapter->course_id == $course->id) {{ 'Selected' }} @endif >{{ $course->{'name' . withLocalization()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label >{{ __('Thumbnail') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="thumbnail" placeholder="{{ __('Image') }}" class="form-control">
                                    @if(@$chapter->thumb_image)
                                        <a href="{{ url(uploads_images('chapter', null,true) . '/' . $chapter->thumb_image) }}" target="_blank">{{ $chapter->thumb_image }}</a>
                                        <input type="hidden" name="old_thumbnail" value="{{ $chapter->thumb_image }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label >{{ __('Bonus Material') }} </label>
                                    <select class="form-control select2" name="bonus_material[]" data-placeholder="{{ __('Select') }}" multiple>
                                        @foreach($bonusMaterials as $key => $bonusMaterial)
                                            <option value="{{ $bonusMaterial->id }}" @if(isset($chapter) && in_array($bonusMaterial->id, $bonusMaterialIds)) {{ 'selected' }} @endif >{{ $bonusMaterial->{ 'name'. withLocalization() } }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Description') }} AR</label>
                                    <div id="snow-editor-ar" style="height: 180px;">
                                        {!! @$chapter->description_ar !!}
                                    </div>
                                    <textarea name="description_ar" id="descriptionBoxAr" style="display: none;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Description') }} EN</label>
                                    <div id="snow-editor" style="height: 180px;">
                                        {!! @$chapter->description_en !!}
                                    </div>
                                    <textarea name="description_en" id="descriptionBox" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Duration') }} <small>in minutes</small></label>
                                    <input type="number" name="duration" class="form-control" placeholder="{{ __('Duration in minutes') }}" value="{{ @$chapter->duration }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 ">
                                <div class="radio radio-warning form-check-inline ml-1">
                                    <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$chapter->duration_no) checked @endif>
                                    <label> {{ __('Schedule') }} </label>
                                </div>
                                <div class="radio radio-success form-check-inline">
                                    <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$chapter->duration_no) checked @endif>
                                    <label>{{ __('Post Now') }} </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="{{ !@$chapter->duration_no ? 'display: none;' : '' }}">
                            <div class="col-md-3">
                                <div class="form-group mt-2">
                                    <select name="duration_type" id="schedule" class="form-control select2" data-placeholder="{{ __('Select') }}">
                                        <option value="Duration Type">Duration Type</option>
                                        <option value="Week" @if(isset($chapter) && $chapter->duration_type == "Week") {{ 'selected' }} @endif >Week[s]</option>
                                        <option value="Month" @if(isset($chapter) && $chapter->duration_type == "Month") {{ 'selected' }} @endif >Month[s]</option>
                                        <option value="Year" @if(isset($chapter) && $chapter->duration_type == "Year") {{ 'selected' }} @endif >Year[s]</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" step="0.01" min="0" name="duration_no" class="form-control mt-2" placeholder="{{ __('Duration') }}" value="{{ @$chapter->duration_no }}" required />
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$chapter->schedule }}" readonly="readonly">
                                </div>
                            </div> --}}
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
