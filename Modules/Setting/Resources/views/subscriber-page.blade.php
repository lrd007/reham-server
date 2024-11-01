<form action="{{ route('site-configuration.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Header Type') }} </label>
                <select class="form-control" name="subscriber_page_header_type" id="subscriber_header_type">
                    <option value="video" @if(setting('subscriber_page_header_type') == 'video') {{ 'selected' }} @endif>{{ __('Video') }}</option>
                    <option value="description" @if(setting('subscriber_page_header_type') == 'slider') {{ 'selected' }} @endif>{{ __('Slider') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Video') }} </label>
                <input type="file" name="subscriber_page_header_video" class="form-control" >
                @if(setting('subscriber_page_header_video'))
                    <a href="{{ url(uploads_files('subscriber_page_header', null,true) . '/' . setting('subscriber_page_header_video')) }}" target="_blank">{{ setting('subscriber_page_header_video') }}</a>
                @endif
            </div>
        </div>
        <div class="col-md-4  text-right">
            <a class="btn btn-primary waves-effect waves-light" target="_blank" href="{{ route('subscriber-page.preview') }}">{{ __('Preview') }}</a>
        </div>
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Program') }}</label>
                <select class="form-control select2" name="subscriber_page_program[]" data-placeholder="{{ __('Select') }}" multiple>
                    <option value="" >{{ __('Select') }}</option>
                    @foreach($programs as $key => $program)
                        <option value="{{ $program->id }}" @if(setting('subscriber_page_program') && in_array($program->id, setting('subscriber_page_program'))) {{ 'selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="mb-3">
                <label >{{ __('Courses') }}</label>
                <select class="form-control select2" name="subscriber_page_courses[]" data-placeholder="{{ __('Select') }}" multiple>
                    <option value="" >{{ __('Select') }}</option>
                    @foreach($courses as $key => $course)
                        <option value="{{ $course->id }}" @if(setting('subscriber_page_courses') && in_array($course->id, setting('subscriber_page_courses'))) {{ 'selected' }} @endif>{{ $course->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Event Type Heading') }} EN</label>
                <input type="text" name="subscriber_page_event_heading_en" class="form-control" value="{{ setting('subscriber_page_event_heading_en') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Event Type Heading') }} AR</label>
                <input type="text" name="subscriber_page_event_heading_ar" class="form-control" value="{{ setting('subscriber_page_event_heading_ar') }}">
            </div>
        </div>
    </div>
    <div class="row ml-3">        
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Event Type') }} </label>
                <select class="form-control" name="subscriber_page_event_type" id="subscriber_event_type">
                    <option value="image" @if(setting('subscriber_page_event_type') == 'image') {{ 'selected' }} @endif>{{ __('Image') }}</option>
                    <option value="video" @if(setting('subscriber_page_event_type') == 'video') {{ 'selected' }} @endif>{{ __('Video') }}</option>
                    <option value="description" @if(setting('subscriber_page_event_type') == 'description') {{ 'selected' }} @endif>{{ __('Description') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 image-container contact-type-input" style="display: {{ setting('subscriber_page_event_type') == 'image' ? '' : 'none' }};">
            <div class="mb-3">
                <label >{{ __('Image') }} </label>
                <input type="file" name="subscriber_page_event_image" class="form-control" >
                @if(setting('subscriber_page_event_image'))
                    <a href="{{ url(uploads_files('subscriber_page', null,true) . '/' . setting('subscriber_page_event_image')) }}" target="_blank">{{ setting('subscriber_page_event_image') }}</a>
                @endif
            </div>
        </div>        
        <div class="col-md-4 video-container contact-type-input" style="display: {{ setting('subscriber_page_event_type') == 'video' ? '' : 'none' }};">
            <div class="mb-3">
                <label >{{ __('Video') }} </label>
                <input type="file" name="subscriber_page_event_video" class="form-control" >
            </div>
        </div>
        <div class="col-md-4 description-container contact-type-input" style="display: {{ setting('subscriber_page_event_type') == 'description' ? '' : 'none' }};">
            <div class="mb-3">
                <label >{{ __('Description') }} EN </label>
                <textarea class="form-control" name="subscriber_page_event_description_en" cols="30" rows="3">{{ setting('subscriber_page_event_description_en') }}</textarea>
            </div>
        </div>
        <div class="col-md-4 description-container contact-type-input" style="display: {{ setting('subscriber_page_event_type') == 'description' ? '' : 'none' }};">
            <div class="mb-3">
                <label >{{ __('Description') }} AR </label>
                <textarea class="form-control" name="subscriber_page_event_description_ar" cols="30" rows="3">{{ setting('subscriber_page_event_description_ar') }}</textarea>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>