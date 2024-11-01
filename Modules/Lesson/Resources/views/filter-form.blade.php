<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ __('Filter') }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    <form>
        <div class="form-group">
            <label class="form-label">{{ __('Program') }}</label>
            <select id="program" name="program[]" class="form-control select2" multiple data-placeholder="{{ __('Select') }}">
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" >{{ $program->{'name' . withLocalization()} }}</option>        
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('Course') }}</label>
            <select id="course" name="course[]" class="form-control select2" multiple data-placeholder="{{ __('Select') }}">
            </select>
        </div>
        <div class="form-group">
                <label class="form-label">{{ __('Chapter') }}</label>
                <select class="form-control select2" id="chapter" name="chapter[]" multiple data-placeholder="{{ __('Select') }}">
                    <option value="">{{ __('Select') }}</option>
                </select>
            </div>
        <div class="text-right">
            <button type="button" class="apply-button-filter btn btn-primary waves-effect waves-light">{{ __('Apply') }}</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
        </div>
    </form>
</div>