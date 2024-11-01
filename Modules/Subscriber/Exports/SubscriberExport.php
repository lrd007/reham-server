<?php

namespace Modules\Subscriber\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriberExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Map data to CSV format and handle null values.
     */
    public function collection()
    {
        return $this->data->map(function ($subscriber) {
            return [
                $subscriber->id ?? '',
                $subscriber->user->name ?? '',
                $subscriber->user->email ?? '',
                $subscriber->mobile_no ?? '',
                $subscriber->country->name ?? '',
                $subscriber->is_premium ? __('Yes') : __('No'),
                $subscriber->created_at ? $subscriber->created_at->format('Y-m-d H:i:s') : '',
                isActive($subscriber->deleted_at, true) ?? ''
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
            'Name',
            'Email',
            'Mobile No',
            'Country',
            'Is Premium',
            'Created At',
            'Status'
        ];
    }
}
