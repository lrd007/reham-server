<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Subscriber\Entities\Subscriber;

class Payment extends Model
{
    public static $status = [
        'pending' => 'Pending',
        'success' => 'Paid',
        'failed' => 'Failed'
    ];

    public static $statusColor = [
        'pending' => 'primary',
        'success' => 'success',
        'failed' => 'danger'
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function paymentDetail()
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function getStatus($status, $color)
    {
        return '<span class="badge bg-soft-' . $color . ' text-' . $color . ' p-1" >' . __($status) . '</span>';
    }
}
