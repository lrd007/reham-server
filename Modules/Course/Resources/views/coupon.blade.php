<form action="{{ route('course.coupon') }}" method="post">
    {{ csrf_field() }}
    @if(isset($course))
        <input type="hidden" name="course_id" value="{{ $course->id }}">
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label >{{ __('Coupon Code') }} <span class="text-danger">*</span></label>
                <select class="form-control select2" name="coupon" data-placeholder="{{ __('Select') }}">
                    <option value="" >{{ __('Select') }}</option>
                    @foreach($coupons as $key => $coupon)
                        <option value="{{ $coupon->id }}" @if(isset($course) && $coupon->id == $course->coupon_code) {{ 'selected' }} @endif >{{ $coupon->code }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-right">
                <button type="button" class="btn btn-primary waves-effect waves-light  global-save">{{ __('Save') }} </button>
            </div>
        </div>
    </div>    
</form>