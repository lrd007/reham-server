<form id="courseInfoForm" action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($course))
    {{ method_field('PUT') }}
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Name') }} AR<span class="text-danger">*</span></label>
                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$course->name_ar }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Name') }} EN<span class="text-danger">*</span></label>
                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$course->name_en }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Thumbnail') }} <span class="text-danger">*</span></label>
                <input type="file" name="thumbnail" placeholder="{{ __('Image') }}" class="form-control">
                @if(@$course->thumb_image)
                <a href="{{ url(uploads_images('course', null,true) . '/' . $course->thumb_image) }}" target="_blank">{{ $course->thumb_image }}</a>
                <input type="hidden" name="old_thumbnail" value="{{ $course->thumb_image }}">
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('File Type') }} <span class="text-danger">*</span></label>
                <select name="file_type" class="form-control" id="file_type_select" data-placeholder="{{ __('Select') }}">
                    <option value="">{{ __('Select') }}</option>
                    <option value="image" @if(isset($course) && $course->file_type == 'image') {{ 'selected' }} @endif >Image</option>
                    <option value="video" @if(isset($course) && $course->file_type == 'video') {{ 'selected' }} @endif >Video</option>
                    <option value="vimeo" @if(isset($course) && $course->file_type == 'vimeo') {{ 'selected' }} @endif >Vimeo</option>
                </select>
            </div>
        </div>
        <div class="col-md-4" id="image_or_video" @if(!isset($course->file_type) || $course->file_type == 'vimeo') style="display: none;" @endif>
            <div class="mb-3">
                <label>{{ __('File') }} <span class="text-danger">*</span></label>
                <input type="file" name="file" placeholder="{{ __('File') }}" class="form-control">
                @if(@$course->file)
                <a href="{{ url(uploads_images('course', null,true) . '/' . $course->file) }}" target="_blank">{{ $course->file }}</a>
                <input type="hidden" name="old_file" value="{{ $course->file }}">
                @endif
            </div>
        </div>
        <div class="col-md-4" id="vimeo_link" @if(!isset($course) || $course->file_type != 'vimeo') style="display: none;" @endif>
            <div class="mb-3">
                <label>{{ __('Vimeo Link') }}<span class="text-danger">*</span></label>
                <input type="text" name="vimeo_link" class="form-control" placeholder="{{ __('Vimeo Link') }}" value="{{ @$course->vimeo_link }}">
            </div>
        </div>
        <!-- <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Get Started Type') }} <span class="text-danger">*</span></label>
                <select name="get_started_type" class="form-control" id="get_started_type_select" data-placeholder="{{ __('Select') }}">
                    <option value="">{{ __('Select') }}</option>
                    <option value="video" @if(isset($course) && $course->get_started_type == 'video') {{ 'selected' }} @endif >Video</option>
                    <option value="vimeo" @if(isset($course) && $course->get_started_type == 'vimeo') {{ 'selected' }} @endif >Vimeo</option>
                </select>
            </div>
        </div>
        <div class="col-md-4" id="get_started_video" @if(!isset($course->get_started_type) || $course->get_started_type == 'vimeo') style="display: none;" @endif>
            <div class="mb-3">
                <label>{{ __('Get Started File') }} <span class="text-danger">*</span></label>
                <input type="file" name="get_started_video" placeholder="{{ __('File') }}" class="form-control">
                @if(@$course->get_started_video)
                <a href="{{ url(uploads_images('course', null,true) . '/' . $course->get_started_video) }}" target="_blank">{{ $course->get_started_video }}</a>
                <input type="hidden" name="old_file" value="{{ $course->get_started_video }}">
                @endif
            </div>
        </div>
        <div class="col-md-4" id="get_started_vimeo" @if(!isset($course) || $course->get_started_type != 'vimeo') style="display: none;" @endif>
            <div class="mb-3">
                <label>{{ __('Get Started Vimeo Link') }}<span class="text-danger">*</span></label>
                <input type="text" name="get_started_vimeo" class="form-control" placeholder="{{ __('Vimeo Link') }}" value="{{ @$course->get_started_vimeo }}">
            </div>
        </div> -->
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Tag') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" name="tag[]" data-placeholder="{{ __('Select') }}" multiple>
                    @foreach($tags as $key => $tag)
                    <option value="{{ $tag->id }}" @if(isset($course)) @foreach($course->tags as $courseTag) @if($courseTag->id == $tag->id) {{ 'selected' }} @endif @endforeach @endif>{{ $tag->{ 'name'. withLocalization() } }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Audio') }}</label>
                <input type="file" name="audio" class="form-control" accept="audio/*">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Program') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" name="program[]" data-placeholder="{{ __('Select') }}" multiple>
                    @foreach($programs as $key => $program)
                    <option value="{{ $program->id }}" @if(isset($course)) @foreach($course->programs as $courseProgram) @if($courseProgram->id == $program->id) {{ 'selected' }} @endif @endforeach @endif >{{ $program->{ 'name'. withLocalization() } }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>{{ __('Bonus Material') }} </label>
                <select class="form-control select2" name="bonus_material[]" data-placeholder="{{ __('Select') }}" multiple>
                    @foreach($bonusMaterials as $key => $bonusMaterial)
                    <option value="{{ $bonusMaterial->id }}" @if(isset($course) && in_array($bonusMaterial->id, $bonusMaterialIds)) {{ 'selected' }} @endif >{{ $bonusMaterial->{ 'name'. withLocalization() } }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label>{{ __('Description') }} AR</label>
                <div id="snow-editor-ar" style="height: 180px;">
                    {!! @$course->{'description_ar'} !!}
                </div>
                <textarea name="description_ar" id="descriptionBoxAr" style="display: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label>{{ __('Description') }} EN</label>
                <div id="snow-editor" style="height: 180px;">
                    {!! @$course->{'description_en'} !!}
                </div>
                <textarea name="description_en" id="descriptionBox" style="display: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 ">
            <div class="radio radio-warning form-check-inline ml-1">
                <input class="post-or-schedule" id="schedule_or_post" type="radio" value="1" name="post_or_schedule" @if(@$course->schedule) checked @endif>
                <label for="schedule_or_post"> {{ __('Schedule') }} </label>
            </div>
            <div class="radio radio-success form-check-inline">
                <input class="post-or-schedule" id="post_or_schedule" type="radio" value="0" name="post_or_schedule" @if(@!$course->schedule) checked @endif>
                <label for="post_or_schedule">{{ __('Post Now') }} </label>
            </div>
        </div>
    </div>

    <div class="row" style="{{ !@$course->schedule ? 'display: none;' : '' }}">

        <div class="col-md-3">
            <div class="form-group mt-2">
                <select name="duration_type" id="schedule" class="form-control select2" data-placeholder="{{ __('Select') }}">
                    <option value="Duration Type">Duration Type</option>
                    <option value="Week" @if(isset($course) && $course->duration_type == "Week") {{ 'selected' }} @endif >Week[s]</option>
                    <option value="Month" @if(isset($course) && $course->duration_type == "Month") {{ 'selected' }} @endif >Month[s]</option>
                    <option value="Year" @if(isset($course) && $course->duration_type == "Year") {{ 'selected' }} @endif >Year[s]</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="number" step="0.01" min="0" name="duration" class="form-control mt-2" placeholder="{{ __('Duration') }}" value="{{ @$course->duration }}" required />
            </div>
        </div>
        {{-- <div class="col-sm-6">
            <div class="form-group">
                <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$course->schedule }}" readonly="readonly">
            </div>
        </div> --}}
    </div>
    <div class="text-right">
        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>
