<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ __('Filter') }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-4">
    <form>
        <div class="form-group">
            <label class="form-label">{{ __('Name') }} </label>
            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}"/>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('Mobile No') }} </label>
            <input type="text" name="mobile_no" class="form-control" placeholder="{{ __('Mobile No') }}"/>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('Email') }} </label>
            <input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}"/>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('No. Of Purchage Program') }} </label>
            <input type="text" name="no_of_pur_program" class="form-control" placeholder="{{ __('No. Of Purchage Program') }}"/>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Program') }}</label>
            <select name="program[]" class="form-control select2" multiple data-placeholder="{{ __('Select') }}">
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" >{{ $program->{'name' . withLocalization()} }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Country') }}</label>
            <select name="country[]" class="form-control select2" multiple data-placeholder="{{ __('Select') }}">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" >{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Purchased Program ') }}</label>
            <select name="purchased_program" class="form-control select2" data-placeholder="{{ __('Select') }}">
                @for ($i=0; $i <= 10; $i++)
                    <option value="{{ $i }}" >{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Date') }} </label>
            <div class="row d-flex text-center align-items-center">
                <div class="col-md-5">
                    <input type="date" name="from_date"  class="form-control"/>
                </div>
                <div class="col-md-2">
                    <Label>To</Label>
                </div>
                <div class="col-md-5">
                    <input type="date" name="to_date"  class="form-control"/>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Status') }}</label>
            <select name="status[]" class="form-control select2" multiple data-placeholder="{{ __('Select') }}">
                <option value="1">{{ __('Active') }}</option>
                <option value="2">{{ __('Disabled') }}</option>
            </select>
        </div>
        <div class="text-right">
            <button type="button" class="apply-button-filter btn btn-primary waves-effect waves-light">{{ __('Apply') }}</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
        </div>
    </form>
</div>
