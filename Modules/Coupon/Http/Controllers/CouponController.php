<?php

namespace Modules\Coupon\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\CouponRequest;
use App\Http\Controllers\BaseController;
use Exception;

class CouponController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('coupon.view');

        $data = [
            __('Id'),
            __('Code'),
            __('Amount'),
            __('Start Date'),
            __('End Date'),            
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'coupon_table',
            'source' => route('coupon.list'),
            'data' => $data
        ];
        
        return view('coupon::index', compact('table'));
    }


    public function list(DataTables $dataTables)
    {
        $this->authorize('coupon.view');

        $canUpdate = auth()->user()->can('coupon.update');
        $canDelete = auth()->user()->can('coupon.delete');
        $builder = Coupon::select(['id', 'code', 'amount', 'start_date', 'end_date', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            ->editColumn('start_date', function ($item) {
                return showDate($item->start_date);
            })
            ->editColumn('end_date', function ($item){
                return showDate($item->end_date);
            })
            ->editColumn('deleted_at', function($item) {
                return statusSwitch($item->id, route("coupon.change.status", $item->id), $item->deleted_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("coupon.edit", $item->id), $canUpdate);
                $buttons .= deleteForm(route("coupon.destroy", $item->id), $canDelete, true);
                
                return $buttons;
            })
            ->rawColumns(range(0, 7))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('coupon.create');

        $action = route('coupon.store');
        return view('coupon::create')->with('action', $action);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CouponRequest $request)
    {
        $this->authorize('coupon.create');

        try{
            $coupon = new Coupon;
            $coupon->fill($this->setData($request))->save();

            $this->logActivity(['activity' => sprintf('Coupon created.'), 'id' => $coupon->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('coupon::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('coupon.update');

        $coupon = Coupon::withTrashed()->findOrFail($id);
        $action = route('coupon.update', $id);
        return view('coupon::update')->with(['coupon' => $coupon, 'action' => $action]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CouponRequest $request, $id)
    {
        $this->authorize('coupon.update');

        try{
            $coupon = Coupon::withTrashed()->findOrFail($id);
            $coupon->fill($this->setData($request))->save();

            $this->logActivity(['activity' => sprintf('Coupon updated.'), 'id' => $coupon->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('coupon.delete');

        try{
            $coupon = Coupon::find($id);
            $coupon->delete();

            $this->logActivity(['activity' => sprintf('Coupon deleted.'), 'id' => $coupon->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function recover($id)
    {
        $this->authorize('coupon.delete');

        try{
            $coupon = Coupon::withTrashed()->find($id);
            $coupon->restore();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function setData($request)
    {
        return [
            'code' => $request->code,
            'amount' => $request->amount,
            'start_date' => $request->start_date ?: null,
            'end_date' => $request->end_date?: null
        ];
    }

    public function changeStatus($id)
    {
        $this->authorize('coupon.delete');

        try{
            $coupon = Coupon::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $coupon->restore();
                $this->logActivity(['activity' => sprintf('Coupon active.'), 'id' => $coupon->id], true, true);
            } else {
                $coupon->delete();
                $this->logActivity(['activity' => sprintf('Coupon disable.'), 'id' => $coupon->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }       
    }
}
