<form id="subscriberForm" action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($subscriber))
        {{ method_field('PUT') }}
        <input type="hidden" name="user_id" value="{{ $subscriber->user_id }}">
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('First Name') }}<span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control" placeholder="{{ __('First Name') }}" value="{{ @$subscriber->first_name }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('Last Name') }}<span class="text-danger">*</span></label>
                <input type="text" name="last_name" class="form-control" placeholder="{{ __('Last Name') }}" value="{{ @$subscriber->last_name }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('Email') }}<span class="text-danger">*</span></label>
                <input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ @$subscriber->user->email }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('Mobile No') }}<span class="text-danger">*</span></label>
                <input type="text" name="mobile_no" class="form-control" placeholder="{{ __('Mobile No') }}" value="{{ @$subscriber->mobile_no }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('Country') }}</label>
                <select class="form-control select2" name="country" data-placeholder="{{ __('Select') }}" >
                    @foreach($countries as $key => $country)
                        <option value="{{ $country->id }}" @if(isset($subscriber) && $subscriber->country_id == $country->id) {{ 'selected' }} @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('Fee Receipt') }} <span class="text-danger">*</span></label>
                <input type="file" name="receipt" class="form-control" />
                @if(@$subscriber->receipt)
                    <a href="{{ url(uploads_files('fee_receipt', null,true) . '/' . $subscriber->receipt) }}" target="_blank">{{ $subscriber->receipt }}</a>
                    <input type="hidden" name="old_receipt" value="{{ $subscriber->receipt }}">
                @endif
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" id="saveButton" class="btn btn-primary waves-effect waves-light global-save">{{ __('Save') }} </button>
    </div>
</form>