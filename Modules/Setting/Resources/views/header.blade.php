<form action="{{ route('course.fee') }}" method="post">
    {{ csrf_field() }}
    @if(isset($course))
        <input type="hidden" name="course_id" value="{{ $course->id }}">
    @endif
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Application Name') }} <span class="text-danger">*</span></label>
                <input type="text" name="app_name" class="form-control" placeholder="{{ __('App Name') }}" value="{{ env('APP_NAME') }}">
            </div>
        </div>        
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Logo') }} </label>
                <input type="file" name="logo" class="form-control" >
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>