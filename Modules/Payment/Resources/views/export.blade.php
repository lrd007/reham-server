<style>
    table {
       border-collapse: collapse;
    }
</style>
<table width="100%">
    <thead>
        <tr>
            <td colspan="8" style="background: #d9d9d9bf;">                
                <b>{{ __('Payments') }}</b>
            </td>
        </tr>
        <tr>
            <td style="background: #e1efff;"><b>{{ __('Id') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Payment Id') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Track Id') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Amount') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Discount') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Type') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Subscriber') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Status') }}</b></td>
            <td style="background: #e1efff;"><b>{{ __('Created At') }}</b></td>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            <tr >
                <td>{{ @$payment->id }} </td>
                <td>{{ @$payment->paymentid }} </td>
                <td>{{ @$payment->trackid }} </td>
                <td>{{ @$payment->amount }} </td>
                <td>{{ @$payment->discount }}</td>
                <td>{{ @$payment->payment_type }}</td>
                <td>{{ @$payment->subscriber->full_name }}</td>
                <td>{{ @$payment->status }}</td>
                <td>{{ showDate($payment->created_at) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>