<form action="{{ route('site-configuration.store') }}" method="post">
    {{ csrf_field() }}
    @if(isset($course))
        <input type="hidden" name="course_id" value="{{ $course->id }}">
    @endif
    <div class="row ml-3">
        <div class="col-sm-12">
            <label >{{ __('General') }}</label>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Logo') }} </label>
                <input type="file" name="site_logo" class="form-control" >
                @if(setting('site_logo'))
                    <a href="{{ url(uploads_files('site', null,true) . '/' . setting('site_logo')) }}" target="_blank">{{ setting('site_logo') }}</a>
                @endif
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row ml-3">
        <div class="col-sm-12">
            <label >{{ __('About Us') }}</label>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('About Us Image') }} </label>
                <input type="file" name="about_us_image" class="form-control" >
                @if(setting('about_us_image'))
                    <a href="{{ url(uploads_files('site', null,true) . '/' . setting('about_us_image')) }}" target="_blank">{{ setting('about_us_image') }}</a>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('About Description') }} EN</label>
                <input type="text" name="footer_about_en" class="form-control" placeholder="{{ __('About') }}" value="{{ setting('footer_about_en') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('About Description') }} AR</label>
                <input type="text" name="footer_about_ar" class="form-control" placeholder="{{ __('About') }}" value="{{ setting('footer_about_ar') }}">
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row ml-3">
        <div class="col-sm-12">
            <label >{{ __('Contact') }}</label>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Email') }}</label>
                <input type="text" name="footer_contact_email" class="form-control" placeholder="{{ __('Email') }}" value="{{ setting('footer_contact_email') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Phone No') }}</label>
                <input type="text" name="footer_contact_phone_no" class="form-control" placeholder="{{ __('Phone No') }}" value="{{ setting('footer_contact_phone_no') }}">
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row ml-3">
        <div class="col-sm-12">
            <label >{{ __('Social Media') }}</label>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Facebook') }}</label>
                <input type="url" name="footer_facebook_url" class="form-control" placeholder="{{ __('Url') }}" value="{{ setting('footer_facebook_url') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Twitter') }}</label>
                <input type="url" name="footer_twitter_url" class="form-control" placeholder="{{ __('Url') }}" value="{{ setting('footer_twitter_url') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Instagram') }}</label>
                <input type="url" name="footer_intagram_url" class="form-control" placeholder="{{ __('Url') }}" value="{{ setting('footer_intagram_url') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Pinterest') }}</label>
                <input type="url" name="footer_pinterest_url" class="form-control" placeholder="{{ __('Url') }}" value="{{ setting('footer_pinterest_url') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Google Plus') }}</label>
                <input type="url" name="footer_google_plus_url" class="form-control" placeholder="{{ __('Url') }}" value="{{ setting('footer_google_plus_url') }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label >{{ __('Linkedin') }}</label>
                <input type="url" name="footer_linkedin_url" class="form-control" placeholder="{{ __('Url') }}" value="{{ setting('footer_linkedin_url') }}">
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>