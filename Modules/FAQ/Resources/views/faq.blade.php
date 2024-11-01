@extends('layouts.vertical', ['title' => __('FAQ')])

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
                    <h4 class="page-title">{{ __('FAQ') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form id="faqForm" action="{{ $action }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($faq))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Question') }} AR<span class="text-danger">*</span></label>
                                    <input type="text" name="question_ar" class="form-control" placeholder="{{ __('Question') }}" value="{{ @$faq->question_ar }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Question') }} EN<span class="text-danger">*</span></label>
                                    <input type="text" name="question_en" class="form-control" placeholder="{{ __('Question') }}" value="{{ @$faq->question_en }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Answer') }} AR <span class="text-danger">*</span></label>
                                    <div id="snow-editor-ar" style="height: 180px;">
                                        {!! @$faq->answer_ar !!}
                                    </div>
                                    <textarea name="answer_ar" id="descriptionBoxAr" style="display: none;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label >{{ __('Answer') }} EN <span class="text-danger">*</span></label>
                                    <div id="snow-editor" style="height: 180px;">
                                        {!! @$faq->answer_en !!}
                                    </div>
                                    <textarea name="answer_en" id="descriptionBox" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-sm-6 ">
                                <div class="radio radio-success form-check-inline ml-1">
                                    <input type="radio" value="0" class="faq-type" name="type" @if(isset($faq) && $faq->type == 0 || !isset($faq)) checked @endif>
                                    <label> {{ __('General') }} </label>
                                </div>
                                <div class="radio radio-success form-check-inline">
                                    <input type="radio" value="1" class="faq-type" name="type" @if(isset($faq) && $faq->type == 1) checked @endif>
                                    <label>{{ __('Legal') }} </label>
                                </div>
                            </div>
                            <div class="col-md-6 general-category" style="@if(isset($faq) && $faq->type == 1) display:none; @endif">
                                <div class="mb-3">
                                    <label >{{ __('Category') }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="general_category[]" data-placeholder="{{ __('Select') }}" multiple>
                                        @foreach($generalCategory as $key => $category)
                                            <option value="{{ $category->id }}" @if(isset($faq) && in_array($category->id, $faqCategoryIds)) {{ 'selected' }} @endif >{{ $category->{ 'name'. withLocalization() } }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 legal-category" style="@if(isset($faq) && $faq->type == 0) display:none; @elseif(!isset($faq)) display:none; @endif">
                                <div class="mb-3">
                                    <label >{{ __('Category') }} <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="legal_category[]" data-placeholder="{{ __('Select') }}" multiple>
                                        @foreach($legalCategory as $key => $category)
                                            <option value="{{ $category->id }}" @if(isset($faq) && in_array($category->id, $faqCategoryIds)) {{ 'selected' }} @endif >{{ $category->{ 'name'. withLocalization() } }}</option>
                                        @endforeach
                                    </select>
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
    <script>
        $(document).on("click", ".faq-type", function(){
            $val = $(this).val();
            $(".general-category, .legal-category").hide();
            $val == 1 ? $(".legal-category").show() : $(".general-category").show();
        });        
    </script>
@endsection