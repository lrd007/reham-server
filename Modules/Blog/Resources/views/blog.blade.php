@extends('layouts.vertical', ['title' => __('Blog')])

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
                    <h4 class="page-title">{{ __('Blog') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form id="blogForm" action="{{ $action }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($blog))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                    <input type="text" name="title_ar" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$blog->title_ar }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                    <input type="text" name="title_en" class="form-control" placeholder="{{ __('Title') }}" value="{{ @$blog->title_en }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Tag') }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="tag[]" data-placeholder="{{ __('Select') }}" multiple>
                                        @foreach($tags as $key => $tag)
                                            <option value="{{ $tag->id }}" @if(isset($blog)) @foreach($blog->tags as $blogTag) @if($blogTag->id == $tag->id) {{ 'selected' }} @endif  @endforeach @endif>{{ $tag->{ 'name'. withLocalization() } }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Thumbnail') }} <span class="text-danger">*</span></label>
                                    <input type="file" name="thumbnail" placeholder="{{ __('Image') }}" class="form-control">
                                    @if(@$blog->thumb_image)
                                        <a href="{{ url(uploads_images('blog', null,true) . '/' . $blog->thumb_image) }}" target="_blank">{{ $blog->thumb_image }}</a>
                                        <input type="hidden" name="old_thumbnail" value="{{ $blog->thumb_image }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Description') }} AR</label>
                                    <div id="snow-editor-ar" style="height: 180px;">
                                        {!! @$blog->description_ar !!}
                                    </div>
                                    <textarea name="description_ar" id="descriptionBoxAr" style="display: none;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Description') }} EN</label>
                                    <div id="snow-editor" style="height: 180px;">
                                        {!! @$blog->description_en !!}
                                    </div>
                                    <textarea name="description_en" id="descriptionBox" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 ">
                                <div class="radio radio-warning form-check-inline ml-1">
                                    <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$blog->schedule) checked @endif>
                                    <label> {{ __('Schedule') }} </label>
                                </div>
                                <div class="radio radio-success form-check-inline">
                                    <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$blog->schedule) checked @endif>
                                    <label>{{ __('Post Now') }} </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="{{ !@$blog->schedule ? 'display: none;' : '' }}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$blog->schedule }}" readonly="readonly">
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