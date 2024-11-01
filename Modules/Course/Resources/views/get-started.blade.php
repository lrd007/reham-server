<div class="material-container" style="display: none;">
    <div class="row bg-light mt-2 pt-2">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                        <input type="text" name="title_ar[]" class="form-control" placeholder="{{ __('Title') }}" >
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                        <input type="text" name="title_en[]" class="form-control" placeholder="{{ __('Title') }}" >
                    </div>
                </div>
                <div class="col-sm-4">
                    <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                    <select name="type[]" class="form-control video-or-vimeo-type" data-placeholder="{{ __('Select') }}">
                        <option value="video" selected>{{ __('Video') }}</option>
                        <option value="vimeo" >{{ __('Vimeo') }}</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                        <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" >
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                        <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" >
                    </div>
                </div>
                <div class="col-sm-4 video-type-input">
                    <div class="form-group">
                        <label>{{ __('File') }} <span class="text-danger">*</span></label>
                        <input type="file" name="file[]" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4 vimeo-type-input" style="display: none;">
                    <div class="form-group">
                        <label>{{ __('Vimeo') }}<span class="text-danger">*</span></label>
                        <input type="text" name="vimeo[]" class="form-control" placeholder="{{ __('Vimeo') }}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-right">
                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light mt-4 remove-material mb-2" >{{ __('Remove') }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
            <form id="materialForm" action="{{ route('course.get-started') }}" method="post">
                {{ csrf_field() }}
                @if(isset($course))
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                @endif
                <div id="materialContainer">
                    @if(isset($course) && $course->getStartedFiles->count())
                        @foreach($course->getStartedFiles as $getStartedFile)
                            <div class="row bg-light mt-2 pt-2">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                                <input type="text" name="title_ar[]" class="form-control" placeholder="{{ __('Title') }}" value="{{ $getStartedFile->title_ar }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                                <input type="text" name="title_en[]" class="form-control" placeholder="{{ __('Title') }}" value="{{ $getStartedFile->title_en }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                                            <select name="type[]" class="form-control video-or-vimeo-type" data-placeholder="{{ __('Select') }}">
                                                <option value="video" @if($getStartedFile->type == 0) {{ 'selected' }} @endif>{{ __('Video') }}</option>
                                                <option value="vimeo" @if($getStartedFile->type == 1) {{ 'selected' }} @endif>{{ __('Vimeo') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                                <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" value="{{ $getStartedFile->description_ar }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                                <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" value="{{ $getStartedFile->description_en }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4 video-type-input" style="@if($getStartedFile->type == 1) display: none; @endif">
                                            <div class="form-group">
                                                <label>{{ __('File') }} <span class="text-danger">*</span></label>
                                                <input type="file" name="file[]" class="form-control">
                                                @if(@$getStartedFile->file)
                                                    <a href="{{ url(uploads_files('get_started_material', null,true) . '/' . $getStartedFile->file) }}" target="_blank">{{ $getStartedFile->file }}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-4 vimeo-type-input" style="@if($getStartedFile->type == 0) display: none; @endif">
                                            <div class="form-group">
                                                <label>{{ __('Vimeo') }}<span class="text-danger">*</span></label>
                                                <input type="text" name="vimeo[]" class="form-control" placeholder="{{ __('Vimeo') }}" value="{{ $getStartedFile->file }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="text-right">
                                                @if($loop->first)
                                                    <button type="button" id="addMaterial" class="btn btn-sm btn-primary waves-effect waves-light mt-4 mb-2">{{ __('Add More') }} </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-danger waves-effect waves-light mt-4 remove-material">{{ __('Remove') }} </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row bg-light pt-2">
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>{{ __('Title') }} AR<span class="text-danger">*</span></label>
                                            <input type="text" name="title_ar[]" class="form-control" placeholder="{{ __('Title') }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>{{ __('Title') }} EN<span class="text-danger">*</span></label>
                                            <input type="text" name="title_en[]" class="form-control" placeholder="{{ __('Title') }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                                        <select name="type[]" class="form-control video-or-vimeo-type" data-placeholder="{{ __('Select') }}">
                                            <option value="video" selected>{{ __('Video') }}</option>
                                            <option value="vimeo" >{{ __('Vimeo') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>{{ __('Description') }} AR<span class="text-danger">*</span></label>
                                            <input type="text" name="description_ar[]" class="form-control" placeholder="{{ __('Description') }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>{{ __('Description') }} EN<span class="text-danger">*</span></label>
                                            <input type="text" name="description_en[]" class="form-control" placeholder="{{ __('Description') }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4 video-type-input">
                                        <div class="form-group">
                                            <label>{{ __('File') }} <span class="text-danger">*</span></label>
                                            <input type="file" name="file[]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 vimeo-type-input" style="display: none;">
                                        <div class="form-group">
                                            <label>{{ __('Vimeo') }}<span class="text-danger">*</span></label>
                                            <input type="text" name="vimeo[]" class="form-control" placeholder="{{ __('Vimeo') }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="text-right">
                                    <button type="button" id="addMaterial" class="btn btn-sm btn-primary waves-effect waves-light mt-4 mb-2">{{ __('Add More') }} </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="text-right">
                    <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>