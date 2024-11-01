<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($coursePackage))
        {{ method_field('PUT') }}
    @endif
    <div class="form-group">
        <label class="form-label">{{ __('Name') }} AR</label><span class="text-danger">*</span>
        <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$coursePackage->name_ar }}" required />
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Name') }} EN</label><span class="text-danger">*</span>
        <input type="text" name="name_en" class="form-control" placeholder="{{ __('Name') }}" value="{{ @$coursePackage->name_en }}" required />
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Days') }}</label>
        <input type="number" name="days" class="form-control" placeholder="{{ __('Days') }}" value="{{ @$coursePackage->days }}" required min="1"/>
    </div>
    <div class="text-right">
        <button type="button" class="save-button btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
    </div>
</form>