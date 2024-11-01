@extends('layouts.vertical', ['title' => __('Affiliate')])

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
                <h4 class="page-title">{{ __('Affiliate') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <form id="blogForm" action="{{ $action }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($affiliate))
                    {{ method_field('PUT') }}
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Name') }} AR<span class="text-danger">*</span></label>
                                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name Arabic') }}" value="{{ @$affiliate->name_ar }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Name') }} EN<span class="text-danger">*</span></label>
                                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name English') }}" value="{{ @$affiliate->name_en }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Program') }} <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="program_id" data-placeholder="{{ __('Select') }}">
                                    @foreach($programs as $key => $program)
                                    <option value="{{ $program->id }}" @if(isset($affiliate) && $affiliate->program_id == $program->id) {{ 'Selected' }} @endif >{{ $program->{'name' . withLocalization()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Commission Type') }} <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="type" data-placeholder="{{ __('Select') }}">
                                    <option value="fixed" @if(isset($affiliate) && $affiliate->type == 'fixed') {{ 'Selected' }} @endif >{{__('Fixed')}}</option>
                                    <option value="percentage" @if(isset($affiliate) && $affiliate->type == 'percentage') {{ 'Selected' }} @endif >{{__('Percentage')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Value') }}<span class="text-danger">*</span></label>
                                <input type="text" name="value" class="form-control" placeholder="{{ __('Value') }}" value="{{ @$affiliate->value }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Payment Link') }}<span class="text-danger">*</span></label>
                                <input type="text" name="payment_link" class="form-control" placeholder="{{ __('Payment Link') }}" value="{{ @$affiliate->payment_link }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="start_date" class="form-control" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$affiliate->start_date }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="end_date" class="form-control" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$affiliate->end_date }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Contract') }} <span class="text-danger">*</span></label>
                                <input type="file" name="contract" placeholder="{{ __('Contract') }}" class="form-control">
                                @if(@$affiliate->contract)
                                <a href="{{ url(uploads_images('affiliate', null,true) . '/' . $affiliate->contract) }}" target="_blank">{{ $affiliate->contract }}</a>
                                <input type="hidden" name="old_contract" value="{{ $affiliate->contract }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Invoice') }} <span class="text-danger">*</span></label>
                                <input type="file" name="invoice" placeholder="{{ __('Invoice') }}" class="form-control">
                                @if(@$affiliate->invoice)
                                <a href="{{ url(uploads_images('affiliate', null,true) . '/' . $affiliate->invoice) }}" target="_blank">{{ $affiliate->invoice }}</a>
                                <input type="hidden" name="old_invoice" value="{{ $affiliate->invoice }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Image') }} <span class="text-danger">*</span></label>
                                <input type="file" name="image" placeholder="{{ __('Image') }}" class="form-control">
                                @if(@$affiliate->image)
                                <a href="{{ url(uploads_images('affiliate', null,true) . '/' . $affiliate->image) }}" target="_blank">{{ $affiliate->image }}</a>
                                <input type="hidden" name="old_image" value="{{ $affiliate->image }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>{{ __('Bonus Material') }} <span class="text-danger">*</span></label>
                                <input type="file" name="bonus_material" placeholder="{{ __('Bonus Material') }}" class="form-control">
                                @if(@$affiliate->bonus_material)
                                <a href="{{ url(uploads_images('affiliate', null,true) . '/' . $affiliate->bonus_material) }}" target="_blank">{{ $affiliate->bonus_material }}</a>
                                <input type="hidden" name="old_bonus_material" value="{{ $affiliate->bonus_material }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 ">
                            <div class="radio radio-warning form-check-inline ml-1">
                                <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$affiliate->schedule) checked @endif>
                                <label> {{ __('Schedule') }} </label>
                            </div>
                            <div class="radio radio-success form-check-inline">
                                <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$affiliate->schedule) checked @endif>
                                <label>{{ __('Post Now') }} </label>
                            </div>
                        </div>
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