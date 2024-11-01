<form id="lessonInfoForm" action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($lesson))
        {{ method_field('PUT') }}
    @endif
    <div class="row">
        <input type="hidden" id="type" name="type" value="{{ @$lesson->type == 'vimeo' ? 'vimeo' : 'video' }}">
        
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Name') }} AR <span class="text-danger">*</span></label>
                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$lesson->name_ar }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Name') }} EN <span class="text-danger">*</span></label>
                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$lesson->name_en }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Course') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" id="course" name="course" data-placeholder="{{ __('Select') }}">
                    <option value="">{{ __('Select') }}</option>
                    @foreach($courses as $key => $course)
                        <option value="{{ $course->id }}" @if(isset($lesson) && $lesson->course_id == $course->id) {{ 'selected' }} @endif >{{ $course->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Chapter') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" id="chapter" name="chapter" data-placeholder="{{ __('Select') }}">
                    <option value="">{{ __('Select') }}</option>
                    @foreach($chapters as $key => $chapter)
                        <option value="{{ $chapter->id }}" @if(isset($lesson) && $lesson->chapter_id == $chapter->id) {{ 'selected' }} @endif >{{ $chapter->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Thumbnail') }} <span class="text-danger">*</span></label>
                <input type="file" name="thumbnail" placeholder="{{ __('Image') }}" class="form-control">
                @if(@$lesson->thumb_image)
                    <a href="{{ url(uploads_images('lesson', null,true) . '/' . $lesson->thumb_image) }}" target="_blank">{{ $lesson->thumb_image }}</a>
                    <input type="hidden" name="old_thumbnail" value="{{ $lesson->thumb_image }}">
                @endif
            </div>
        </div>

        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Document') }}</label>
                <input type="file" name="document" placeholder="{{ __('Document') }}" class="form-control">
                @if(@$lesson->document)
                    <a href="{{ url(uploads_files('lesson', null,true) . '/' . $lesson->document) }}" target="_blank">{{ $lesson->document }}</a>
                    <input type="hidden" name="old_document" value="{{ $lesson->document }}">
                @endif
            </div>
        </div>
        <div class="col-md-3 video-input" id="video" @if(isset($lesson) && $lesson->type != 'video')  style="display: none;" @endif>
            <div class="mb-3">
                <label >{{ __('Video') }} <span class="text-danger">*</span></label>
                <input type="file" name="video" placeholder="{{ __('Video') }}" class="form-control">
                @if(@$lesson->video)
                    <a href="{{ url(uploads_files('lesson', null,true) . '/' . $lesson->video) }}" target="_blank">{{ $lesson->video }}</a>
                    <input type="hidden" name="old_video" value="{{ $lesson->video }}">
                @endif
            </div>
        </div>
        <div class="col-md-3 vimeo-input" @if(!isset($lesson) || $lesson->type == 'video')  style="display: none;" @endif>
            <div class="mb-3">
                <label >{{ __('Audio') }}</label>
                <input type="file" name="audio" placeholder="{{ __('Audio') }}" class="form-control">
                @if(@$lesson->audio)
                    <a href="{{ url(uploads_files('lesson', null,true) . '/' . $lesson->audio) }}" target="_blank">{{ $lesson->audio }}</a>
                    <input type="hidden" name="old_audio" value="{{ $lesson->audio }}">
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label >{{ __('Bonus Material') }} </label>
                <select class="form-control select2" name="bonus_material[]" data-placeholder="{{ __('Select') }}" multiple>
                    @foreach($bonusMaterials as $key => $bonusMaterial)
                        <option value="{{ $bonusMaterial->id }}" @if(isset($chapter) && in_array($bonusMaterial->id, $bonusMaterialIds)) {{ 'selected' }} @endif >{{ $bonusMaterial->{ 'name'. withLocalization() } }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 vimeo-input" @if(!isset($lesson) || $lesson->type == 'video')  style="display: none;" @endif>
            <div class="mb-3">
                <label >{{ __('Embeded Code') }} <span class="text-danger">*</span></label>
                <textarea placeholder="{{ __('Embeded Code') }}" class="form-control" name="embeded_code" rows="4">{{ @$lesson->vimeo_embeded_code }}</textarea>
            </div>
        </div>
        <div class="col-md-4 vimeo-input" @if(!isset($lesson) || $lesson->type == 'video')  style="display: none;" @endif>
            <div class="mb-3">
                <label >{{ __('Vimeo Url') }} <span class="text-danger">*</span></label>
                <input type="text" name="vimeo_url" placeholder="{{ __('Vimeo Url') }}" class="form-control" value="{{ @$lesson->vimeo_url }}" >
            </div>
        </div>        
        <div class="col-md-4 vimeo-input" @if(!isset($lesson) || $lesson->type == 'video')  style="display: none;" @endif>
            <div class="mb-3">
                <label >{{ __('Duration') }} <span class="text-danger">*</span></label>
                <input type="text" id="duration" name="duration" placeholder="{{ __('Duration') }}" class="form-control" value="{{ @$lesson->type == 'vimeo' ? @$lesson->duration : '' }}" >
            </div>
        </div>
        @if(isset($lesson) && $lesson->type == 'video')
            <div class="col-md-3 video-input" >
                <div class="mb-3">
                    <label >{{ __('Duration') }}</label>
                    <input type="text" placeholder="{{ __('Duration') }}" class="form-control" value="{{ @$lesson->type == 'video' ? @$lesson->duration : '' }}" disabled>
                </div>
            </div>
        @endif
        <div class="col-md-4">
            <div class="custom-control custom-checkbox mb-4">
                <input type="checkbox" class="custom-control-input" id="checkbox-signin" name="is_comment_allowed" @if(!isset($lesson) || $lesson->is_comment_allowed) {{ 'checked' }} @endif>
                <label class="custom-control-label" for="checkbox-signin"> {{ __('Allow Comment') }}</label>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="mb-3">
                <label >{{ __('Description') }} AR</label>
                <div id="snow-editor-ar" style="height: 180px;">
                    {!! @$lesson->description_ar !!}
                </div>
                <textarea name="description_ar" id="descriptionBoxAr" style="display: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label >{{ __('Description') }} EN</label>
                <div id="snow-editor" style="height: 180px;">
                    {!! @$lesson->description_en !!}
                </div>
                <textarea name="description_en" id="descriptionBox" style="display: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 ">
            <div class="radio radio-warning form-check-inline ml-1">
                <input class="post-or-schedule" type="radio" value="1" name="post_or_schedule" @if(@$program->schedule) checked @endif>
                <label> {{ __('Schedule') }} </label>
            </div>
            <div class="radio radio-success form-check-inline">
                <input class="post-or-schedule" type="radio" value="0" name="post_or_schedule" @if(@!$program->schedule) checked @endif>
                <label>{{ __('Post Now') }} </label>
            </div>
        </div>
    </div>

    <div class="row" style="{{ !@$lesson->schedule ? 'display: none;' : '' }}">
        <div class="col-sm-6">
            <div class="form-group">
                <input type="text" id="schedule" class="form-control date-time mt-2" name="schedule" placeholder="{{ __('Date and Time') }}" value="{{ @$lesson->schedule }}" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>


















