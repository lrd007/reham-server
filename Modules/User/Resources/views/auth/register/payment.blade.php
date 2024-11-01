<form id="finishForm" method="post" action="{{ route('user.register.step.six.post') }}" class="form-horizontal"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                @include('layouts.shared.notifications')
                <p class="w-75 mb-2 mx-auto">You will be charge for the initial registration fee of 70KD. This is
                    non-refundable. Please select the payment method to pay online and complete the registeration.</p>

                <input type="hidden" name="payment_method" value="myfatoorah">
                @if (setting('myfatoorah_enabled'))                
                <div class="form-row">
                    <div class="form-group p-3 mb-3 rounded col-md-6">
                        <div class="float-end"><i class="fab fa-bootstrap font-24 text-primary"></i></div>
                        <div class="form-check">
                            <input type="radio" id="BillingOptRadio2" name="btype" class="form-check-input"
                                value="myfatoorah" checked>
                            <label class="form-check-label font-16 fw-bold" for="BillingOptRadio2">Pay with
                                MyFatoorah</label>
                        </div>
                        <p class="mb-0 ps-3 pt-1">You will be redirected to MyFatoorah website to complete your purchase
                            securely.</p>

                    </div>
                </div>
                @else
                    @if (setting('booking_enabled'))
                    <input type="hidden" name="payment_method" value="bookeey">
                    <div class="form-row">
                        <div class="form-group p-3 mb-3 rounded col-md-6">
                            <div class="float-end"><i class="fab fa-bootstrap font-24 text-primary"></i></div>
                            <div class="form-check">
                                <input type="radio" id="BillingOptRadio2" name="btype" class="form-check-input"
                                    value="KNET">
                                <label class="form-check-label font-16 fw-bold" for="BillingOptRadio2">Pay with
                                    KNET</label>
                            </div>
                            <p class="mb-0 ps-3 pt-1">You will be redirected to KNET website to complete your purchase
                                securely.</p>

                        </div>
                        <div class="form-group p-3 mb-3 rounded col-md-6">
                            <div class="float-end"><i class="fas fa-credit-card font-24 text-primary"></i></div>
                            <div class="form-check">
                                <input type="radio" id="BillingOptRadio4" name="btype" class="form-check-input"
                                    value="Credit">
                                <label class="form-check-label font-16 fw-bold" for="BillingOptRadio4">Pay with Credit
                                    Card</label>
                            </div>
                            <p class="mb-0 ps-3 pt-1">You will be redirected to Credit Card website to complete your
                                purchase securely.</p>
                        </div>
                    </div>
                    @endif
                @endif

                @if(auth()->check() && auth()->user()->can('applicant_registration.index'))
                    <div class="form-row">
                        <div class="form-group p-3 mb-3 rounded col-md-6">
                            <div class="float-end"><i class="fas fa-credit-card font-24 text-success"></i></div>
                            <div class="form-check">
                                <input type="radio" id="BillingOptRadio4" name="btype" class="form-check-input"
                                    value="cash">
                                <label class="form-check-label font-16 fw-bold" for="BillingOptRadio4">Pay with Cash</label>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="accepted_terms" class="custom-control-input" id="customCheck4"
                            value="1" @if (request()->session()->get('accepted_terms'))checked @endif required>
                        <label class="custom-control-label" for="customCheck4">I agree with the Terms and
                            Conditions</label>
                        @if ($errors->has('accepted_terms'))
                            <ul class="parsley-errors-list filled" id="parsley-id-40" aria-hidden="false">
                                <li class="parsley-required">{{ $errors->first('accepted_terms') }}</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    <ul class="list-inline wizard mb-0">
        <li class="previous list-inline-item">
            <a href="{{ auth()->check() && auth()->user()->can('applicant_registration.index') ? route('applicant.step-five') : route('user.register.step.five.get') }}" class="btn btn-secondary">Previous</a>
        </li>
        <li class="next list-inline-item float-right">
            <button type="submit" id="submitButton" class="btn btn-secondary" disabled>Pay Now</button>
        </li>
    </ul>
</form>

@section('script-bottom')
    <script src="{{ asset('assets/libs/jquery-toast-plugin/jquery-toast-plugin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>
    <script>
        $("#customCheck4").change(function() {
            this.checked ? $("#submitButton").prop('disabled', false) : $("#submitButton").prop('disabled', true);            
        });

        $("input[name='btype']").on('change', function(){
            $val = $(this).val();

            if($(this).val() == 'cash') {
                $("#submitButton").text('Register');
            } else {
                $("#submitButton").text('Pay Now');
            }

            $val = $val == 'KNET' || $val == 'Credit' ? 'bookeey' : $val
            $("input[name='payment_method']").val($val);
        });
    </script>
@endsection
