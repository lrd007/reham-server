<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($program))
        {{ method_field('PUT') }}
    @endif
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Name') }} AR</label><span class="text-danger">*</span>
                <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$program->name_ar }}" required />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Name') }} EN</label><span class="text-danger">*</span>
                <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$program->name_en }}" required />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Caption') }} AR</label><span class="text-danger">*</span>
                <input type="text" name="caption_ar" class="form-control" placeholder="{{ __('Caption') }}" value="{{ @$program->caption_ar }}" required />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Caption') }} EN</label><span class="text-danger">*</span>
                <input type="text" name="caption_en" class="form-control" placeholder="{{ __('Caption') }}" value="{{ @$program->caption_en }}" required />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label >{{ __('Vimeo Url') }} <span class="text-danger">*</span></label>
                <input type="text" name="vimeo" placeholder="{{ __('Vimeo Url') }}" class="form-control" value="{{ @$program->vimeo }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label >{{ __('Thumbnail') }} <span class="text-danger">*</span></label>
                <input type="file" name="thumbnail" placeholder="{{ __('Thumbnail') }}" class="form-control">
                @if(@$program->thumb_image)
                    <a href="{{ url(uploads_images('program', null,true) . '/' . $program->thumb_image) }}" target="_blank">{{ $program->thumb_image }}</a>
                    <input type="hidden" name="old_thumbnail" value="{{ $program->thumb_image }}">
                @endif
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Duration Type') }}</label>
                <select name="duration_type" class="form-control select2" data-placeholder="{{ __('Select') }}">
                    <option value="Select">Select</option>
                    <option value="Week" @if(isset($program) && $program->duration_type == "Week") {{ 'selected' }} @endif >Week[s]</option>
                    <option value="Month" @if(isset($program) && $program->duration_type == "Month") {{ 'selected' }} @endif >Month[s]</option>
                    <option value="Year" @if(isset($program) && $program->duration_type == "Year") {{ 'selected' }} @endif >Year[s]</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Duration') }}</label><span class="text-danger">*</span>
                <input type="number" step="0.01" min="0" name="duration" class="form-control" placeholder="{{ __('Duration') }}" value="{{ @$program->duration }}" required />
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label>{{ __('Description') }} AR</label>
                <div id="snow-editor-ar" style="height: 180px;">
                    {!! @$program->{'description_ar'} !!}
                </div>
                <textarea name="description_ar" id="descriptionBoxAr" style="display: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label>{{ __('Description') }} EN</label>
                <div id="snow-editor" style="height: 180px;">
                    {!! @$program->{'description_en'} !!}
                </div>
                <textarea name="description_en" id="descriptionBox" style="display: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label>{{ __('Description') }} 2 AR</label>
                <div id="snow-editor-ar-2" style="height: 180px;">
                    {!! @$program->{'description_ar_2'} !!}
                </div>
                <textarea name="description_ar_2" id="descriptionBoxAr2" style="display: none;"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label>{{ __('Description') }} 2 EN</label>
                <div id="snow-editor-2" style="height: 180px;">
                    {!! @$program->{'description_en_2'} !!}
                </div>
                <textarea name="description_en_2" id="descriptionBox2" style="display: none;"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">{{ __('Course') }}</label>
                <select name="courses[]" class="form-control select2" data-placeholder="{{ __('Select') }}" multiple>
                    @foreach($courses as $key => $course)
                        <option value="{{ $course->id }}" @if(isset($program)) @foreach($program->courses as $programCourse) @if($programCourse->id == $course->id) {{ 'selected' }} @endif  @endforeach @endif>{{ $course->{'name' . withLocalization()} }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <div class="mb-3">
                    <label >{{ __('Warranty Days') }} </label>
                    <input type="number" min="0" step="1" name="warranty" placeholder="{{ __('13 Days') }}"  class="form-control" value="{{ @$program->warranty }}">
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="radio radio-warning form-check-inline ml-1 mt-2 mb-2">
                <input type="radio" value="0" class="program-type" name="type" @if(isset($faqCategory) && $faqCategory->type == 0 || !isset($faqCategory)) checked @endif>
                <label> {{ __('Regular') }} </label>
            </div>
            <div class="radio radio-success form-check-inline">
                <input type="radio" value="1" class="program-type" name="type" @if(@isset($faqCategory) && $faqCategory->type == 1) checked @endif>
                <label>{{ __('Special') }} </label>
            </div>
        </div>
    </div>

    <div class="row offer-date" style="display: none;">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('Start Date') }}</label>
                <input type="text" name="start_date" class="form-control" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$program->start_date }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">{{ __('End Date') }}</label>
                <input type="text" name="end_date" class="form-control" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$program->end_date }}">
            </div>
        </div>
    </div>

    <div class="text-right">
        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
    </div>
</form>
