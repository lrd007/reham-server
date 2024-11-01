<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($subscriberProgram))
        {{ method_field('PUT') }}        
    @endif

    @if(isset($subscriber) && $subscriber)
        <input type="hidden" name="user_id" value="{{ $subscriber }}">
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">{{ __('Program') }} <span class="text-danger">*</span></label>
                <select name="program" class="form-control select2" id="program" data-placeholder="{{ __('Select') }}" >
                    <option value="">{{ __('Select') }}</option>
                    @foreach($programs as $key => $program)
                        <option value="{{ $program->id }}" @if(isset($subscriberProgram) && $subscriberProgram->program_id == $program->id) {{ 'selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>        
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">{{ __('Course') }} <span class="text-danger">*</span></label>
                <select name="course" class="form-control select2" id="course" data-placeholder="{{ __('Select') }}" >
                    @foreach($courses as $key => $course)
                        <option value="{{ $course->id }}" @if(isset($subscriberProgram) && $subscriberProgram->course_id == $course->id) {{ 'selected' }} @endif>{{ $course->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>        
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Start Date') }}</label>
                <input type="text" name="start_date" class="form-control" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$subscriberProgram->start_date }}">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('End Date') }}</label>
                <input type="text" name="end_date" class="form-control" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$subscriberProgram->end_date }}">
            </div>
        </div>
    </div>

    <div class="text-right">
        <button type="button" class="save-button btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
    </div>
</form>