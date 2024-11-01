<form action="{{ route('site-configuration.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Introduction Video') }} </label>
                <input type="file" name="landing_page_intro_video" class="form-control">
                @if(setting('landing_page_intro_video'))
                <a href="{{ url(uploads_files('landing_page_intro', null,true) . '/' . setting('landing_page_intro_video')) }}" target="_blank">{{ setting('landing_page_intro_video') }}</a>
                @endif
            </div>
        </div>
        <div class="col-md-8  text-right">
            <a class="btn btn-primary waves-effect waves-light" target="_blank" href="{{ route('landing.preview') }}">{{ __('Preview') }}</a>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row ml-3">
        <div class="col-sm-12">
            <label>{{ __('Success Story Guidelines') }}</label>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Video EN') }} </label>
                <input type="file" name="success_story_video_en" class="form-control">
                @if(setting('success_story_video_en'))
                <a href="{{ url(uploads_files('site', null,true) . '/' . setting('success_story_video_en')) }}" target="_blank">{{ setting('success_story_video_en') }}</a>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Video AR') }} </label>
                <input type="file" name="success_story_video_ar" class="form-control">
                @if(setting('success_story_video_ar'))
                <a href="{{ url(uploads_files('site', null,true) . '/' . setting('success_story_video_ar')) }}" target="_blank">{{ setting('success_story_video_ar') }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Success Story Description') }} EN</label>
                <input type="text" name="success_story_description_en" class="form-control" placeholder="{{ __('Description') }}" value="{{ setting('success_story_description_en') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Success Story Description') }} AR</label>
                <input type="text" name="success_story_description_ar" class="form-control" placeholder="{{ __('Description') }}" value="{{ setting('success_story_description_ar') }}">
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Program') }}</label>
                <select class="form-control select2" name="landing_page_program[]" data-placeholder="{{ __('Select') }}" multiple>
                    <option value="">{{ __('Select') }}</option>
                    @foreach($programs as $key => $program)
                    <option value="{{ $program->id }}" @if(setting('landing_page_program') && in_array($program->id, setting('landing_page_program'))) {{ 'selected' }} @endif>{{ $program->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Special Courses') }}</label>
                <select class="form-control select2" name="landing_page_special_courses[]" data-placeholder="{{ __('Select') }}" multiple>
                    <option value="">{{ __('Select') }}</option>
                    @foreach($courses as $key => $course)
                    <option value="{{ $course->id }}" @if(setting('landing_page_special_courses') && in_array($course->id, setting('landing_page_special_courses'))) {{ 'selected' }} @endif>{{ $course->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Contact Type Heading') }} EN</label>
                <input type="text" name="landing_page_contact_heading_en" class="form-control" value="{{ setting('landing_page_contact_heading_en') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Contact Type Heading') }} AR</label>
                <input type="text" name="landing_page_contact_heading_ar" class="form-control" value="{{ setting('landing_page_contact_heading_ar') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Url') }} </label>
                <input type="url" name="landing_page_contact_image_url" class="form-control" value="{{ setting('landing_page_contact_image_url') }}">
            </div>
        </div>
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Contact Type') }} </label>
                <select class="form-control" name="landing_page_contact_type" id="contact_type">
                    <option value="image" @if(setting('landing_page_contact_type')=='image' ) {{ 'selected' }} @endif>{{ __('Image') }}</option>
                    <option value="video" @if(setting('landing_page_contact_type')=='video' ) {{ 'selected' }} @endif>{{ __('Video') }}</option>
                    <option value="description" @if(setting('landing_page_contact_type')=='description' ) {{ 'selected' }} @endif>{{ __('Description') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 image-container contact-type-input" style="display: {{ setting('landing_page_contact_type') == 'image' ? '' : 'none' }};">
            <div class="mb-3">
                <label>{{ __('Image') }} </label>
                <input type="file" name="landing_page_contact_image" class="form-control">
                @if(setting('landing_page_intro_video'))
                <a href="{{ url(uploads_files('landing_page', null,true) . '/' . setting('landing_page_contact_image')) }}" target="_blank">{{ setting('landing_page_contact_image') }}</a>
                @endif
            </div>
        </div>
        <div class="col-md-4 video-container contact-type-input" style="display: {{ setting('landing_page_contact_type') == 'video' ? '' : 'none' }};">
            <div class="mb-3">
                <label>{{ __('Video') }} </label>
                <input type="file" name="landing_page_contact_video" class="form-control">
            </div>
        </div>
        <div class="col-md-4 description-container contact-type-input" style="display: {{ setting('landing_page_contact_type') == 'description' ? '' : 'none' }};">
            <div class="mb-3">
                <label>{{ __('Description') }} EN </label>
                <textarea class="form-control" name="landing_page_contact_description_en" cols="30" rows="3">{{ setting('landing_page_contact_description_en') }}</textarea>
            </div>
        </div>
        <div class="col-md-4 description-container contact-type-input" style="display: {{ setting('landing_page_contact_type') == 'description' ? '' : 'none' }};">
            <div class="mb-3">
                <label>{{ __('Description') }} AR </label>
                <textarea class="form-control" name="landing_page_contact_description_ar" cols="30" rows="3">{{ setting('landing_page_contact_description_ar') }}</textarea>
            </div>
        </div>
    </div>
    <div class="row ml-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Payment Gateway') }} </label>
                <select class="form-control" name="landing_page_payment_gateway" id="payment_gateway">
                    <option value="myfatoorah" @if(setting('landing_page_payment_gateway')=='myfatoorah' ) {{ 'selected' }} @endif>{{ __('MyFatoorah') }}</option>
                    <option value="kfh" @if(setting('landing_page_payment_gateway')=='kfh' ) {{ 'selected' }} @endif>{{ __('KFH Bank') }}</option>
                    <!-- <option value="description" @if(setting('landing_page_payment_gateway')=='description' ) {{ 'selected' }} @endif>{{ __('Description') }}</option> -->
                </select>
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>