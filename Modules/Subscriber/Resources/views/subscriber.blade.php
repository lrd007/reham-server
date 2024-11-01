@extends('layouts.vertical', ['title' => __('Subscriber')])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Subscriber') }}</h4>
                </div>
            </div>
        </div>

        <div class="program-container" style="display: none;">
            <div class="row bg-light mt-2 pt-2">
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Program') }} <span class="text-danger">*</span></label>
                                <select name="program[]" class="form-control select2 program" id="program" data-placeholder="{{ __('Select') }}" >
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach($programs as $key => $program)
                                        <option value="{{ $program->id }}" @if(isset($subscriberProgram) && $subscriberProgram->program_id == $program->id) {{ 'selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Course') }} <span class="text-danger">*</span></label>
                                <select name="course[]" class="form-control select2 course" id="course" data-placeholder="{{ __('Select') }}" >
                                    <option value="">{{ __('Select') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Package') }} <span class="text-danger">*</span></label>
                                <select name="package[]" class="form-control select2 package" id="package" data-placeholder="{{ __('Select') }}" >
                                    <option value="">{{ __('Select') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="start_date[]" class="form-control start-date" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$subscriberProgram->start_date }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                <input type="text" name="end_date[]" class="form-control end-date" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$subscriberProgram->end_date }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label >{{ __('Fee Receipt') }}</label>
                            <input type="file" name="receipt[]" class="form-control" />
                            @if(@$subscriber->receipt)
                                <a href="{{ url(uploads_files('fee_receipt', null,true) . '/' . $subscriber->receipt) }}" target="_blank">{{ $subscriber->receipt }}</a>
                                <input type="hidden" name="old_receipt" value="{{ $subscriber->receipt }}">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-right">
                                <button type="button" class="btn btn-sm btn-danger waves-effect waves-light mt-4 remove-program mb-2" >{{ __('Remove') }} </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <form id="subscriberForm" action="{{ $action }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($subscriber))
                            {{ method_field('PUT') }}
                            <input type="hidden" name="user_id" value="{{ $subscriber->user_id }}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('First Name') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" placeholder="{{ __('First Name') }}" value="{{ @$subscriber->first_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Last Name') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" placeholder="{{ __('Last Name') }}" value="{{ @$subscriber->last_name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Email') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ @$subscriber->user->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Mobile No') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_no" class="form-control" placeholder="{{ __('Mobile No') }}" value="{{ @$subscriber->mobile_no }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Country') }}</label>
                                    <select class="form-control select2" name="country" data-placeholder="{{ __('Select') }}" >
                                        @foreach($countries as $key => $country)
                                            <option value="{{ $country->id }}" @if(isset($subscriber) && $subscriber->country_id == $country->id) {{ 'selected' }} @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="programContainer">
                            @if(isset($subscriber) && $subscriber->subscribePrograms->count())
                                @foreach($subscriber->subscribePrograms as $key => $subscribeProgram)
                                    <div class="row bg-light mt-2 pt-2">
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('Program') }} <span class="text-danger">*</span></label>
                                                        <select name="program[]" class="form-control select2 program" id="program" data-placeholder="{{ __('Select') }}" >
                                                            <option value="">{{ __('Select') }}</option>
                                                            @foreach($programs as $program)
                                                                <option value="{{ $program->id }}" @if(isset($subscribeProgram) && $subscribeProgram->program_id == $program->id) {{ 'selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="subscriber_program_id[{{$key}}]" value="{{ $subscribeProgram->id }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('Course') }} <span class="text-danger">*</span></label>
                                                        <select name="course[]" class="form-control select2 course" id="course" data-placeholder="{{ __('Select') }}" >
                                                            <option value="">{{ __('Select') }}</option>
                                                            @foreach($subscribeProgram->programCourse($subscribeProgram->program_id) as $course)
                                                                <option value="{{ $course->id }}"  @if(isset($subscribeProgram) && $subscribeProgram->course_id == $course->id)) {{ 'selected' }} @endif>{{ $course->{'name' . withLocalization()} }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('Package') }} <span class="text-danger">*</span> </label>
                                                        <select name="package[]" class="form-control select2 package" id="package" data-placeholder="{{ __('Select') }}" >
                                                            <option value="">{{ __('Select') }}</option>
                                                            @if(isset($subscribeProgram->course->courseFees))
                                                                @foreach($subscribeProgram->course->courseFees as $courseFee)
                                                                    <option value="{{ $courseFee->id }}" data-days="{{ $courseFee->coursePackage->days }}" @if(isset($subscribeProgram) && $subscribeProgram->course_fee_id == $courseFee->id) {{ 'selected' }} @endif>{{ @$courseFee->coursePackage->{'name' . withLocalization()} }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="start_date[]" class="form-control start-date" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$subscribeProgram->start_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="end_date[]" class="form-control end-date" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$subscribeProgram->end_date }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label >{{ __('Fee Receipt') }}</label>
                                                    <input type="file" name="receipt[]" class="form-control" />
                                                    @if(@$subscribeProgram->receipt)
                                                        <a href="{{ url(uploads_files('fee_receipt', null,true) . '/' . $subscribeProgram->receipt) }}" target="_blank">{{ $subscribeProgram->receipt }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="text-right">
                                                        @if($loop->first)
                                                            <button type="button" id="addProgram" class="btn btn-sm btn-primary waves-effect waves-light mt-4 mb-2">{{ __('Add More') }} </button>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-danger waves-effect waves-light mt-4 remove-program">{{ __('Remove') }} </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 text-right" style="height: 60px;margin-top: 50px;">
                                                    <label >{{ __('Fee') }} : {{ $subscribeProgram->fee }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('Notes') }} <span class="text-danger">*</span></label>
                                                <input type="text" name="notes" class="form-control" placeholder="{{ __('End Date') }}" value="{{ @$subscribeProgram->notes }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row bg-light pt-2">
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Program') }} <span class="text-danger">*</span> </label>
                                                    <select name="program[]" class="form-control select2 program" id="program" data-placeholder="{{ __('Select') }}" >
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($programs as $key => $program)
                                                            <option value="{{ $program->id }}" >{{ $program->{'name' . withLocalization()} }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Course') }} <span class="text-danger">*</span> </label>
                                                    <select name="course[]" class="form-control select2 course" id="course" data-placeholder="{{ __('Select') }}" >
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($courses as $key => $course)
                                                            <option value="{{ $course->id }}" >{{ $course->{'name' . withLocalization()} }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Package') }} <span class="text-danger">*</span> </label>
                                                    <select name="package[]" class="form-control select2 package" id="package" data-placeholder="{{ __('Select') }}" >
                                                        <option value="">{{ __('Select') }}</option>
                                                        @foreach($courses as $key => $course)
                                                            <option value="{{ $course->id }}" >{{ $course->{'name' . withLocalization()} }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="start_date[]" class="form-control start-date" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="end_date[]" class="form-control end-date" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label >{{ __('Fee Receipt') }}</label>
                                                <input type="file" name="receipt[]" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="text-right">
                                            <button type="button" id="addProgram" class="btn btn-sm btn-primary waves-effect waves-light mt-4 mb-2">{{ __('Add More') }} </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
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
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/subscriber/subscriber.min.js')}}"></script>
@endsection
