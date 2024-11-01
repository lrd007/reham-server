<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($tag))
        {{ method_field('PUT') }}
    @endif
    <div class="form-group">
        <label class="form-label">{{ __('Name') }} AR</label><span class="text-danger">*</span>
        <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$tag->name_ar }}" required />
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Name') }} EN</label><span class="text-danger">*</span>
        <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$tag->name_en }}" required />
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Progress') }}</label>
        <input type="number" name="progress" class="form-control" placeholder="{{ __('Progress') }}" value="{{ @$tag->progress }}" required min="0" max="100"/>
        <span class="text-muted">{{ __('Required for get sugested course according course complete.') }}</span>
    </div>
    <div class="text-right">
        <button type="button" class="save-button btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
    </div>
</form>