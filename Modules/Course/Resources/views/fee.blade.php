
<div class="package-container" style="display: none;">
    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Package') }} <span class="text-danger">*</span></label>
                <select name="package[]" class="form-control" id="course" data-placeholder="{{ __('Select') }}" >
                    <option value="">{{ __('Select') }}</option>
                    @foreach($coursePackages as $coursePackage)
                        <option value="{{ $coursePackage->id }}" >{{ $coursePackage->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Fee') }} <span class="text-danger">*</span></label>
                <input type="text" name="fee[]" class="form-control" placeholder="{{ __('Fee') }}" value="{{ @$course->fee }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Sale Fee') }} <span class="text-danger">*</span></label>
                <input type="text" name="sale_fee[]" class="form-control" placeholder="{{ __('Sale Fee') }}" value="{{ @$course->sale_fee }}">
            </div>
        </div>
        <div class="col-md-3 text-right">
            <button type="button" class="btn btn-danger waves-effect waves-light remove-program mt-4">{{ __('Remove') }} </button>
        </div>
    </div>
</div>
<form action="{{ route('course.fee') }}" method="post">
    {{ csrf_field() }}
    @if(isset($course))
        <input type="hidden" name="course_id" value="{{ $course->id }}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Password') }} <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}" value="">
                <span>{{ __('Password Is:') }} admin</span>
            </div>
        </div>
    </div>
    <div id="packageContainer">
        @if(isset($course) && $course->courseFees->count())
            @foreach($course->courseFees as $key => $courseFee)                
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label >{{ __('Package') }} <span class="text-danger">*</span></label>
                            <select name="package[]" class="form-control" id="course" data-placeholder="{{ __('Select') }}" >
                                <option value="">{{ __('Select') }}</option>
                                @foreach($coursePackages as $coursePackage)
                                    <option value="{{ $coursePackage->id }}" @if($courseFee->course_package_id == $coursePackage->id) {{ 'selected' }} @endif>{{ $coursePackage->{'name' . withLocalization()} }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="course_fee_id[{{$key}}]" value="{{ @$courseFee->id }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label >{{ __('Fee') }} <span class="text-danger">*</span></label>
                            <input type="text" name="fee[]" class="form-control" placeholder="{{ __('Fee') }}" value="{{ @$courseFee->fee }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label >{{ __('Sale Fee') }} <span class="text-danger">*</span></label>
                            <input type="text" name="sale_fee[]" class="form-control" placeholder="{{ __('Sale Fee') }}" value="{{ @$courseFee->sale_fee }}">
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
                        @if($loop->first)
                            <button type="button" id="addPackage" class="btn btn-primary waves-effect waves-light mt-4">{{ __('Add More') }} </button>
                        @else
                            <button type="button" class="btn btn-danger waves-effect waves-light remove-program mt-4">{{ __('Remove') }} </button>                           
                        @endif
                    </div>
                </div>
            @endforeach
        @else        
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label >{{ __('Package') }} <span class="text-danger">*</span></label>
                        <select name="package[]" class="form-control" id="course" data-placeholder="{{ __('Select') }}" >
                            <option value="">{{ __('Select') }}</option>
                            @foreach($coursePackages as $coursePackage)
                                <option value="{{ $coursePackage->id }}" >{{ $coursePackage->{'name' . withLocalization()} }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label >{{ __('Fee') }} <span class="text-danger">*</span></label>
                        <input type="text" name="fee[]" class="form-control" placeholder="{{ __('Fee') }}" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label >{{ __('Sale Fee') }} <span class="text-danger">*</span></label>
                        <input type="text" name="sale_fee[]" class="form-control" placeholder="{{ __('Sale Fee') }}" value="">
                    </div>
                </div>
                <div class="col-md-3 text-right">
                    <button type="button" id="addPackage" class="btn btn-primary waves-effect waves-light mt-4">{{ __('Add More') }} </button>
                </div>
            </div>
        @endif
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-primary waves-effect waves-light global-save mt-4">{{ __('Save') }} </button>
    </div>
</form>