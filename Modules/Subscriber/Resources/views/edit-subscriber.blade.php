@extends('layouts.vertical', ['title' => __('Subscriber')])

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
                    <h4 class="page-title">{{ __('Subscriber') }}</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5">
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
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label >{{ __('Fee Receipt') }} </label>
                                    <input type="file" name="receipt" class="form-control" />
                                    @if(@$subscriber->fee_receipt)
                                        <a href="{{ url(uploads_files('fee_receipt', null,true) . '/' . $subscriber->fee_receipt) }}" target="_blank">{{ $subscriber->fee_receipt }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="card-box">
                    @can('subscriber.create')
                        <div class="row d-flex flex-row-reverse mb-2">
                            <div class="col-auto">                                
                                <button type="button" class="btn btn-primary waves-effect waves-light text-right modal-button" data-url="{{ route('subscriber.program.create', $subscriber->id) }}" data-toggle="modal" >{{ __('Add New') }}</button>
                            </div>
                        </div>
                        <hr>
                    @endcan
                    @include('layouts.shared/data-table')
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
        $(document).on('change', "#program", function () {
            $id = $(this).val();
            $("#course").prop('disabled', true);
            $.ajax({
                type: 'GET',
                url: $baseUrl + '/course-by-program-ids?program_ids=' + $id,
                dataType: 'json',
                success: function (response) {

                    $row = '<option value=""></option>';
                    $teachers = '';
                    if (response.status = 'success') {
                        if (response.courses) {
                            $.each(response.courses, function (index, course) {
                                $row += '<option value="' + course.id + '">' + course.name + '</option >';
                            });
                        }

                        $("#course").html($row), $("#course").prop('disabled', false);
                    }
                },
                error: function (error) {
                    errorHandler(error);
                }
            });
        });
    </script>
@endsection