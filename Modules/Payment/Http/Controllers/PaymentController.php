<?php

namespace Modules\Payment\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Payment\Entities\Payment;
use Modules\Program\Entities\Program;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\BaseController;
use Modules\Payment\Exports\PaymentExport;
use Barryvdh\DomPDF\PDF;
use Illuminate\Contracts\Support\Renderable;

class PaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('payment.view');

        $data = [
            __('Id'),
            __('Payment Id'),
            __('Track Id'),
            __('Name'),
            __('Email'),
            __('Country'),
            __('Coupon'),
            __('Amount'),
            __('Discount'),
            __('Type'),
            __('Subscriber'),            
            __('Status'),
            __('created_at'),
            __('Action')
        ];
        $table = [
            'id' => 'payment_table',
            'source' => route('payment.list'),
            'data' => $data
        ];
        
        return view('payment::index', compact('table'));
    }


    public function list(DataTables $dataTables, Request $request)
    {
        $this->authorize('payment.view');
        

        // $builder = Payment::select(['id', 'paymentid', 'trackid', 'amount', 'discount', 'payment_type', 'subscriber_id', 'status', 'created_at'])
        // ->join('subscribers', 'payments.subscriber_id', '=', 'subscribers.id')
        // ->leftJoin('users', 'subscribers.user_id', '=', 'users.id')
        // ->select('payments.*', 'subscribers.first_name', 'subscribers.last_name', 'subscribers.mobile_no', 'subscribers.country_id', 'subscribers.dob', 'subscribers.gender', 'users.name as full_name', 'users.email');

        $builder = Payment::select([
            'payments.id', 'payments.paymentid', 'payments.trackid','users.name as full_name','users.email','subscribers.country_id','coupons.code as coupon_name' ,'payments.amount', 
            'payments.discount', 'payments.payment_type', 'payments.subscriber_id', 
            'payments.status', 'payments.created_at', 
            /*'payments.coupon_id',
            'subscribers.first_name', 'subscribers.last_name', 'subscribers.mobile_no', 
            'subscribers.country_id', 'subscribers.dob', 'subscribers.gender', 
            'users.name as full_name', 'users.email', 
            'coupons.code as coupon_name'*/ 
        ])
        ->join('subscribers', 'payments.subscriber_id', '=', 'subscribers.id')
        ->leftJoin('users', 'subscribers.user_id', '=', 'users.id')
        ->leftJoin('coupons', 'payments.coupon_id', '=', 'coupons.id');

        if ($request->filled('name')) {
            $builder->where('users.name', 'LIKE', "%{$request->name}%");
        }
        if (request()->filled('coupon')) {
            $builder->where('coupons.code', 'LIKE', '%' . request()->coupon . '%');
        }

        if ($request->filled('mobile_no')) {
            $builder->where('subscribers.mobile_no', 'LIKE', '%' . $request->mobile_no . '%');
        }
        // $builder = $builder->where('mobile_no', 'LIKE', "%{$request->mobile_no}%");

    
        if ($request->filled('email')) {
            $builder->where('users.email', 'LIKE', '%' . $request->email . '%');
        }

    
        if ($request->filled('age')) {
            $builder->where('subscribers.age', $request->age);
        }
    
        if ($request->filled('gender')) {
            $builder->where('subscribers.gender', 'LIKE',"%{$request->gender}%");
        }

        if ($request->filled('discount')) {
            // dd(1);
            $builder->where('payments.discount', 'LIKE', '%' . $request->discount . '%');
        }
    

        // dump($request->filled('discount'));
        // dd($request->filled('country'));

        if ($request->has('from_date') && $request->has('to_date')  ) {
            // $builder = $builder->whereDateBetween('created_at', [$request->from_date, $request->to_date]);
            if(!empty($request->from_date) && empty($request->to_date)){
                $builder = $builder->where('payments.created_at','>=', $request->from_date)
                    ->where('payments.created_at', '<=', $request->to_date);
            }elseif(!empty($request->from_date)){
                $builder = $builder->where('payments.created_at','>=', $request->from_date);
            }elseif(!empty($request->to_date)){
                $builder = $builder->where('payments.created_at','>=', $request->to_date);
            }

        }
        if ($request->filled('country')) {
            $countries = $request->country;
            $builder->where('subscribers.country_id', $countries);
        }
    

        if ($request->filled('payment_status')) {
            $status = $request->payment_status;
            if ($status === 'failed') {
                $builder->where('payments.status', 'failed');
            } elseif ($status === 'successful') {
                $builder->where('payments.status', 'success');
            } elseif ($status === 'pending') {
                $builder->where('payments.status', 'pending');
            }
        }
    
    
    
        // dd($builder->toSql());
        return $dataTables::of($builder)
            ->editColumn('subscriber_id', function ($item) {
                return @$item->subscriber->full_name;
            })
            ->editColumn('status', function ($item){
                return $item->getStatus(Payment::$status[$item->status], Payment::$statusColor[$item->status]);
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->editColumn('country_id', function ($item) {
                return isset($item->subscriber->country) ? $item->subscriber->country->name : 'Unknown'; // Check if subscriber and country exist
            })
            ->addColumn('action', function ($item) {

                $buttons = '<a href="#" class="modal-button" data-url="' . route('payment.show', $item->id) . '" data-toggle="modal"><i class="text-primary mdi mdi-eye"></i></a>';
                return $buttons;
            })
            ->rawColumns(range(0, 13))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('payment::create');
    }

    public function exportExcel()
    {
        $request = request();
        $builder = Payment::select([
            'payments.id', 'payments.paymentid', 'payments.trackid', 'payments.amount', 
            'payments.discount', 'payments.payment_type', 'payments.subscriber_id', 
            'payments.status', 'payments.created_at', 
            /*'payments.coupon_id',
            'subscribers.first_name', 'subscribers.last_name', 'subscribers.mobile_no', 
            'subscribers.country_id', 'subscribers.dob', 'subscribers.gender', 
            'users.name as full_name', 'users.email', 
            'coupons.code as coupon_name'*/ 
        ])
        ->join('subscribers', 'payments.subscriber_id', '=', 'subscribers.id')
        ->leftJoin('users', 'subscribers.user_id', '=', 'users.id')
        ->leftJoin('coupons', 'payments.coupon_id', '=', 'coupons.id');

        if ($request->filled('name')) {
            $builder->where('users.name', 'LIKE', "%{$request->name}%");
        }
        if (request()->filled('coupon')) {
            $builder->where('coupons.code', 'LIKE', '%' . request()->coupon . '%');
        }

        if ($request->filled('mobile_no')) {
            $builder->where('subscribers.mobile_no', 'LIKE', '%' . $request->mobile_no . '%');
        }
        // $builder = $builder->where('mobile_no', 'LIKE', "%{$request->mobile_no}%");

    
        if ($request->filled('email')) {
            $builder->where('users.email', 'LIKE', '%' . $request->email . '%');
        }

    
        if ($request->filled('age')) {
            $builder->where('subscribers.age', $request->age);
        }
    
        if ($request->filled('gender')) {
            $builder->where('subscribers.gender', 'LIKE',"%{$request->gender}%");
        }

        if ($request->filled('discount')) {
            // dd(1);
            $builder->where('payments.discount', 'LIKE', '%' . $request->discount . '%');
        }

        if ($request->has('from_date') && $request->has('to_date')  ) {
            // $builder = $builder->whereDateBetween('created_at', [$request->from_date, $request->to_date]);
            if(!empty($request->from_date) && empty($request->to_date)){
                $builder = $builder->where('payments.created_at','>=', $request->from_date)
                    ->where('payments.created_at', '<=', $request->to_date);
            }elseif(!empty($request->from_date)){
                $builder = $builder->where('payments.created_at','>=', $request->from_date);
            }elseif(!empty($request->to_date)){
                $builder = $builder->where('payments.created_at','>=', $request->to_date);
            }

        }
    

        // dump($request->filled('discount'));
        // dd($request->filled('country'));

        if ($request->filled('country')) {
            $countries = $request->country;
            $builder->where('subscribers.country_id', $countries);
        }
    

        if ($request->filled('payment_status')) {
            $status = $request->payment_status;
            if ($status === 'failed') {
                $builder->where('payments.status', 'failed');
            } elseif ($status === 'successful') {
                $builder->where('payments.status', 'success');
            } elseif ($status === 'pending') {
                $builder->where('payments.status', 'pending');
            }
        }
        ini_set('max_execution_time', 300);
        $payments = $builder->get();
        return Excel::download(new PaymentExport($payments), 'Payment-Report.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportPDF()
    {

        $request = request();
        $builder = Payment::select([
            'payments.id', 'payments.paymentid', 'payments.trackid', 'payments.amount', 
            'payments.discount', 'payments.payment_type', 'payments.subscriber_id', 
            'payments.status', 'payments.created_at', 
            /*'payments.coupon_id',
            'subscribers.first_name', 'subscribers.last_name', 'subscribers.mobile_no', 
            'subscribers.country_id', 'subscribers.dob', 'subscribers.gender', 
            'users.name as full_name', 'users.email', 
            'coupons.code as coupon_name'*/ 
        ])
        ->join('subscribers', 'payments.subscriber_id', '=', 'subscribers.id')
        ->leftJoin('users', 'subscribers.user_id', '=', 'users.id')
        ->leftJoin('coupons', 'payments.coupon_id', '=', 'coupons.id');

        if ($request->filled('name')) {
            $builder->where('users.name', 'LIKE', "%{$request->name}%");
        }

        if ($request->has('from_date') && $request->has('to_date')  ) {
            // $builder = $builder->whereDateBetween('created_at', [$request->from_date, $request->to_date]);
            if(!empty($request->from_date) && empty($request->to_date)){
                $builder = $builder->where('payments.created_at','>=', $request->from_date)
                    ->where('payments.created_at', '<=', $request->to_date);
            }elseif(!empty($request->from_date)){
                $builder = $builder->where('payments.created_at','>=', $request->from_date);
            }elseif(!empty($request->to_date)){
                $builder = $builder->where('payments.created_at','>=', $request->to_date);
            }

        }
        if (request()->filled('coupon')) {
            $builder->where('coupons.code', 'LIKE', '%' . request()->coupon . '%');
        }

        if ($request->filled('mobile_no')) {
            $builder->where('subscribers.mobile_no', 'LIKE', '%' . $request->mobile_no . '%');
        }
        // $builder = $builder->where('mobile_no', 'LIKE', "%{$request->mobile_no}%");

    
        if ($request->filled('email')) {
            $builder->where('users.email', 'LIKE', '%' . $request->email . '%');
        }

    
        if ($request->filled('age')) {
            $builder->where('subscribers.age', $request->age);
        }
    
        if ($request->filled('gender')) {
            $builder->where('subscribers.gender', 'LIKE',"%{$request->gender}%");
        }

        if ($request->filled('discount')) {
            // dd(1);
            $builder->where('payments.discount', 'LIKE', '%' . $request->discount . '%');
        }
    

        // dump($request->filled('discount'));
        // dd($request->filled('country'));

        if ($request->filled('country')) {
            $countries = $request->country;
            $builder->where('subscribers.country_id', $countries);
        }
    

        if ($request->filled('payment_status')) {
            $status = $request->payment_status;
            if ($status === 'failed') {
                $builder->where('payments.status', 'failed');
            } elseif ($status === 'successful') {
                $builder->where('payments.status', 'success');
            } elseif ($status === 'pending') {
                $builder->where('payments.status', 'pending');
            }
        }
        ini_set('max_execution_time', 300);
        $payments = $builder->get();
        $pdf = app('dompdf.wrapper')->loadView('payment::export', ['payments' => $payments]);
        return $pdf->download('Payment-Report.pdf');
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payment::show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('payment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

 public function paypalSuccess(Request $request)
    {
        // Process PayPal success callback here
        // You may want to save transaction details to your database, update user orders, etc.

        // Example: Log the PayPal callback data
        \Log::info('PayPal Success Callback Data:', $request->all());

        // Return a response (you may redirect the user or show a success message)
        return response()->json(['message' => 'Payment successful']);
    }

    public function filterForm()
    {
        $countries = Country::all();
        $programs = Program::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->withTrashed()->get();
        return view('payment::filter-form', compact('countries', 'programs'));
    }

}
