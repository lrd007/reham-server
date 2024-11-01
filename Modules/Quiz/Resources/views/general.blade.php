<form id="courseInfoForm" action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($quiz))
        {{ method_field('PUT') }}
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Name') }} AR<span class="text-danger">*</span></label>
                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$quiz->name_ar }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Name') }} EN<span class="text-danger">*</span></label>
                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$quiz->name_en }}">
            </div>
        </div>
        <div class="col-md-4 text-right">
            @if(isset($quiz))
                <div class="mb-3">
                    <label >{{ __('Total Marks') }} :  {{ $quiz->totalMarks() }}</label>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Course') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" id="course" name="course" data-placeholder="{{ __('Select') }}">
                    <option value="">{{ __('Select') }}</option>
                    @foreach($courses as $key => $course)
                        <option value="{{ $course->id }}" @if(isset($quiz) && $quiz->course_id == $course->id) {{ 'selected' }} @endif>{{ $course->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Chapter') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" id="chapter" name="chapter" data-placeholder="{{ __('Select') }}">
                    @foreach($chapters as $key => $chapter)
                        <option value="{{ $chapter->id }}" @if(isset($quiz) && $quiz->chapter_id == $chapter->id) {{ 'selected' }} @endif>{{ $chapter->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Lesson') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" id="lesson" name="lesson" data-placeholder="{{ __('Select') }}">
                    @foreach($lessons as $key => $lesson)
                        <option value="{{ $lesson->id }}" @if(isset($quiz) && $quiz->lesson_id == $lesson->id) {{ 'selected' }} @endif>{{ $lesson->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 ">
            <div class="radio radio-warning form-check-inline ml-1">
                <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$quiz->schedule) checked @endif>
                <label> {{ __('Schedule') }} </label>
            </div>
            <div class="radio radio-success form-check-inline">
                <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$quiz->schedule) checked @endif>
                <label>{{ __('Post Now') }} </label>
            </div>
        </div>
    </div>

    <div class="row" style="{{ !@$quiz->schedule ? 'display: none;' : '' }}">
        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$quiz->schedule }}" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>