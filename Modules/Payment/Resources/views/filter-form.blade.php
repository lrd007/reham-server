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
            <label class="form-label">{{ __('Age') }} </label>
            <input type="text" name="address" class="form-control" placeholder="{{ __('Age') }}"/>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Gender') }} </label>
            <select name="gender" class="form-control">
                <option value="">{{ __('Select Gender') }}</option>
                <option value="Male">{{ __('Male') }}</option>
                <option value="Female">{{ __('Female') }}</option>
            </select>
        </div>
    
        <div class="form-group">
            <label class="form-label">{{ __('Payment Status') }} </label>
            <select name="payment_status" class="form-control">
                <option value="">{{ __('Select Payment Status') }}</option>
                    <option value="failed">{{ __('Failed Payments') }}</option>
                    <option value="successful">{{ __('Successful Payments') }}</option>
                    <option value="pending">{{ __('Pending Payments') }}</option>
            </select>
        </div>
    
        <div class="form-group">
            <label class="form-label">{{ __('Course Statistics') }} </label>
            <select name="course_statistics" class="form-control">
                    <option value="best">{{ __('Best Course') }}</option>
            </select>
        </div>
    
        <div class="form-group">
            <label class="form-label">{{ __('Discount') }} </label>
            <input type="text" name="discount" class="form-control" placeholder="{{ __('Discount') }}"/>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Coupon') }} </label>
            <input type="text" name="coupon" class="form-control" placeholder="{{ __('Coupon') }}"/>
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
            <label class="form-label">{{ __('Country') }}</label>
            <select name="country" class="form-control select2" data-placeholder="{{ __('Select') }}">
                <option value="">{{ __('Select Country') }}</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" >{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="button" class="apply-button-filter btn btn-primary waves-effect waves-light">{{ __('Apply') }}</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >{{ __('Cancel') }}</button>
        </div>
    </form>
</div>
