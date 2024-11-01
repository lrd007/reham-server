<div class="modal-header bg-light">
    <h4 class="modal-title" >{{ __('Payment') }} : {{ $payment->paymentid }}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body p-4">
    <div class="row">
        <div class="col-sm-7">
            <label >{{ __('Subscriber') }}</label>
            <p><span class="font-weight-bold text-primary">{{  @$payment->subscriber->full_name }}</span></p>
        </div>
        <div class="col-sm-5">
            <label >{{ __('Payment ID') }}</label>
            <p class="font-weight-bold text-info">{{ @$payment->paymentid }}</p>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-7">
            <label >{{ __('Amount') }}</label>
            <p class="font-weight-bold">{{ $payment->amount }} KD</p>
        </div>
        <div class="col-sm-5">
            <label >{{ __('Status') }}</label>
            <p class="font-weight-bold">{!! $payment->getStatus(Modules\Payment\Entities\Payment::$status[$payment->status], Modules\Payment\Entities\Payment::$statusColor[$payment->status]); !!}</p>
        </div>
    </div>    
    @if($payment->paymentDetail->count())
        <table class="table table-hover table-bordered table-sm">
            <tr>
                <!-- <th>{{ __('Program') }}</th> -->
                <th>{{ __('Course') }}</th>
                <th>{{ __('Package') }}</th>
                <th>{{ __('Amount') }}</th>
            </tr>
            @foreach($payment->paymentDetail as $paymentDetail)
                <tr>
                    <!-- <td>{{ @$paymentDetail->program->{'name' . withLocalization()} }}</td> -->
                    <td>{{ @$paymentDetail->course->{'name' . withLocalization()} }}</td>
                    <td>{{ @$paymentDetail->package->{'name' . withLocalization()} }}</td>
                    <td>{{ $paymentDetail->amount }} KD</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>