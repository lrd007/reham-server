<?php

namespace Modules\Payment\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return the collection of payments.
     */
    public function collection()
    {
        return $this->data->map(function ($payment) {
            return [
                $payment->id ?? '',
                $payment->paymentid ?? '',
                $payment->trackid ?? '',
                $payment->amount ?? '',
                $payment->discount ?? '',
                $payment->payment_type ?? '',
                $payment->subscriber->full_name ?? '',
                $payment->status ?? '',
                $payment->created_at ? $payment->created_at->format('Y-m-d H:i:s') : '',
            ];
        });
    }
    

    /**
     * Define CSV headings.
     */
    public function headings(): array
    {
        return [
            'Id',
            'Payment Id',
            'Track Id',
            'Amount',
            'Discount',
            'Payment Type',
            'Subscriber',
            'Status',
            'Created At'
        ];
    }
}
