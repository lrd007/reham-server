<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($coupon))
        {{ method_field('PUT') }}
    @endif
    <div class="form-group">
        <label class="form-label">{{ __('Code') }}</label><span class="text-danger">*</span>
        <input type="text" name="code" class="form-control" placeholder="{{ __('Code') }}" value="{{ @$coupon->code }}" required />
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Amount') }}</label><span class="text-danger">*</span>
        <input type="text" name="amount" class="form-control autonumber" placeholder="{{ __('Amount') }}" value="{{ @$coupon->amount }}" required />
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('Start Date') }}</label>
        <input type="text" name="start_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$coupon->start_date }}">
    </div>
    <div class="form-group">
        <label class="form-label">{{ __('End Date') }}</label>
        <input type="text" name="end_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-m-d" value="{{ @$coupon->end_date }}">
    </div>
    <div class="text-right">
        <button type="button" class="save-button btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
    </div>
</form>