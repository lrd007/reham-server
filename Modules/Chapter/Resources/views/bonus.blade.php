
<form action="{{ route('chapter.bonus.date') }}" method="post">
    {{ csrf_field() }}
    @if(isset($chapter))
        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                <input type="text" name="start_date" class="form-control" placeholder="{{ __('Start Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$chapter->bonus_start_date }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">{{ __('End Date') }} <span class="text-danger">*</span></label>
                <input type="text" name="end_date" class="form-control" placeholder="{{ __('End Date') }}" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$chapter->bonus_end_date }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-right">
                <button type="button" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
            </div>
        </div>
    </div>    
</form>
<hr>

<form action="{{ route('chapter.bonus') }}" class="dropzone" id="bonusMaterialDropzone">
    {{ csrf_field() }}
    @if(isset($chapter))
        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
    @endif
    <div class="dz-message needsclick">
        <i class="h1 text-muted dripicons-cloud-upload"></i>
        <h3>{{ __('Drop files here or click to upload.') }}</h3>
    </div>
</form>

@if(isset($chapter) && $chapter->bonusMaterials->count())
    <div class="row mt-4">
        @foreach($chapter->bonusMaterials as $bonusMaterial)
            <div class="col-sm-2" id="imgContainer">
                <form action="{{ route('chapter.bonus.delete', $bonusMaterial->id) }}" data-load="false" data-target="#imgContainer">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-danger waves-effect waves-light text-right delete-button" style="position: absolute;right: 53px;"><i class="mdi mdi-delete"></i></button>
                </form>
                @if(isFileImage($bonusMaterial->file_path))
                    <a href="{{ url(uploads_files('chapter_bonus_material', null,true) . '/' . $bonusMaterial->file_path) }}" target="_blank">
                        <img src="{{ url(uploads_files('chapter_bonus_material', null,true) . '/' . $bonusMaterial->file_path) }}" alt="image" class="img-fluid img-thumbnail" width="200" height="200">
                    </a>
                @else
                    <div class="image-fluid img-thumbnail justify-content-center text-center" style="height: 200px; width:200px">
                        <a href="{{ url(uploads_files('chapter_bonus_material', null,true) . '/' . $bonusMaterial->file_path) }}"  target="_blank">
                            <i class="mdi mdi-file-document text-muted" style="font-size: 130px;"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif