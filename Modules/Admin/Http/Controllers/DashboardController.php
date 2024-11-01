<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Modules\Installment\Entities\Installment;
use Carbon\Carbon;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //$this->authorize('admin_dashboard.view');

        return view('admin::dashboard');
    }

    public function data()
    {
        $this->authorize('admin_dashboard.view');
        
        $today = Carbon::now()->format('Y-m-d');
        $paid = Installment::where('remaining_amount', '==', 0)->count();
        $pending = Installment::whereDate('installment_due_date', '>=', $today)->where('remaining_amount', '>', 0)->count();
        $overdue = Installment::where('remaining_amount', '>', 0)->whereDate('installment_due_date', '<', $today)->count();

        $payment = [
            'Paid' => $paid,
            'Pending' => $pending,
            'Overdue' => $overdue,
        ];
        return $this->success(['payment' => $payment]);
    }
}
