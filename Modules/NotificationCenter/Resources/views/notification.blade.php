@extends('layouts.vertical', ['title' => __('Notification Center') ])

@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">{{ __('Notification Center') }}</h4>
                </div>
            </div>
        </div>

        <form action="{{ $action }}" method="post">
            {{ csrf_field() }}
            @php
                $medium = isset($notification) ? $notification->media->pluck('medium_id')->toArray() : [];
            @endphp
            @if(isset($notification))
                {{ method_field('PUT') }}
            @endif
            <input type="hidden" id="statusField" name="status" value="{{ @$notification->status ?: 0 }}" >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="mb-2">{{ __('Send To') }} <span class="text-danger">*</span></label>
                                    <br>
                                    <div class="radio radio-secondary form-check-inline ml-1">
                                        <input class="send-to-radio" type="radio" value="0" name="send_to" @if(isset($notification) && $notification->send_to == 0) checked @elseif(!isset($notification)) checked @endif>
                                        <label > {{ __('User') }} </label>
                                    </div>
                                    <div class="radio radio-secondary form-check-inline">
                                        <input class="send-to-radio" type="radio" value="1" name="send_to" @if(isset($notification) && $notification->send_to == 1) checked @endif>
                                        <label > {{ __('Group') }} </label>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Medium') }} </label><span  class="text-danger">*</span>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" style="margin-left: 5px;" type="checkbox" name="medium[]" value="0" @if(isset($notification) && in_array(0, $medium)) checked @endif)>
                                            <label class="form-check-label" for="inlineCheckbox1">{{ __('Email') }}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" style="margin-left: 5px;" type="checkbox" name="medium[]" value="1" @if(isset($notification)) @if(in_array(1, $medium)) checked @endif @else checked @endif>
                                            <label class="form-check-label" for="inlineCheckbox3">{{ __('Web') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Title') }} </label><span  class="text-danger">*</span>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ @$notification->title }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3" style="height: 66px;">
                                    <label class="form-label"><input type="checkbox" id="schedule" name="is_schedule" style="position: absolute;top: 3.4px;" @if(isset($notification) && $notification->status == 2) checked @endif> <span style="margin-left: 22px;margin-right:20px">{{ __('Time') }}</span> </label>
                                    <input type="text" id="schedule-datetime" name="schedule" class="form-control" placeholder="Date and Time" value="{{  isset($notification) && $notification->status == 2 ? $notification->schedule : '' }}" @if(!isset($notification) || $notification->status != 2) disabled @endif>
                                </div>

                            </div>

                            <!-- For Individual -->

                            <div class="row user-container" style="display: {{ @$notification->send_to == 0 ? '' : 'none' }}">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">{{ __('Subscriber') }} </label><span  class="text-danger">*</span>
                                    <select name="subscriber[]" id="subscriber" class="form-control" data-placeholder="{{ __('Enter Email') }}" multiple>
                                        @if(isset($notification) && $notification->send_to == 0)
                                            @foreach($notification->users as $user)
                                                <option value="{{$user->id}}" selected>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- For Individual End -->

                            <!-- For Group -->
                            <div class="row group-container" style="display: {{ @$notification->send_to == 1 ? '' : 'none' }}">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">{{ __('Program') }} <span class="text-danger">*</span></label>
                                    <select name="program[]" class="form-control select2" id="program" data-placeholder="{{ __('Select') }}" multiple>
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach($programs as $key => $program)
                                            <option value="{{ $program->id }}" @if(isset($notificationProgramIds) && in_array($program->id, $notificationProgramIds)) {{ 'Selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">{{ __('Course') }} </label>
                                    <select name="course[]" class="form-control select2" id="course" data-placeholder="{{ __('Select') }}" multiple>
                                        @foreach($courses as $key => $course)
                                            <option value="{{ $course->id }}" @if(isset($notificationCourseIds) && in_array($course->id, $notificationCourseIds)) {{ 'Selected' }} @endif>{{ $course->{'name' . withLocalization()} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label class="form-label">{{ __('Message') }} <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control">{{ @$notification->message }}</textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                @can('notification_center.send')
                                    <button type="button" id="sendNotification" class="btn btn-info waves-effect waves-light" @if(isset($notification) && $notification->status == 2) disabled title="{{ __('You can not send it now as it is schedule, For send now unset time.') }}" @endif>{{ __('Send') }}</button>
                                @endcan
                                <button type="button" id="saveNotification" class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </form>
    </div>
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
@endsection

@section('script-bottom')
    <script src="{{asset('assets/js/modules/notification/notification.min.js')}}"></script>
@endsection