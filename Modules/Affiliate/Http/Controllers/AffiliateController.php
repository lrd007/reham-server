<?php

namespace Modules\Affiliate\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Affiliate\Entities\Affiliate;
use Modules\Affiliate\Http\Requests\AffiliateRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Exception;
use Modules\Program\Entities\Program;

class AffiliateController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('affiliate.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Start Date'),
            __('End Date'),
            __('Program'),
         //   __('Payment Link'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'affiliate_table',
            'source' => route('affiliate.list'),
            'data' => $data
        ];

        return view('affiliate::index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('affiliate.store');
        $programs = Program::all();
        return view('affiliate::affiliate', compact('action', 'programs'));
    }


    public function list(DataTables $dataTables)
    {
        $this->authorize('affiliate.view');

        $canUpdate = auth()->user()->can('affiliate.update');
        $canDelete = auth()->user()->can('affiliate.delete');

        $builder = Affiliate::select(['id', 'name' . withLocalization(), 'start_date', 'end_date','program_id', 'created_at', 'deleted_at'])->withTrashed();


        return $dataTables::of($builder)
            ->editColumn('start_date', function ($item) {
                return showDate($item->start_date);
            })
            ->editColumn('end_date', function ($item) {
                return showDate($item->end_date);
            })
            ->editColumn('program_id', function ($item) {
                return $item->program ? '<label class="badge bg-soft-primary text-primary p-1">' . $item->program->{'name' . withLocalization()} . '</label>' : '';
            })
            ->editColumn('created_at', function ($item) {
                return showDate($item->created_at);
            })
            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("affiliate.change.status", $item->id), $item->deleted_at);
            })
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete) {
                $buttons = editButton(route("affiliate.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("affiliate.destroy", $item->id), $canDelete, true);
                return $buttons;
            }, 8)
            ->rawColumns(range(0, 8))
            ->make(false);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AffiliateRequest $request)
    {
        $this->authorize('affiliate.create');

        try {
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $path = uploads_images('affiliate');
            $affiliate = new Affiliate;
            $affiliate->name_ar = $nameAr;
            $affiliate->name_en = $nameEn;
            $affiliate->start_date = $request->start_date;
            $affiliate->program_id = $request->program_id;
            $affiliate->type = $request->type;
            $affiliate->value = $request->value;
            $affiliate->code = Str::random(30);
            $affiliate->end_date = $request->end_date;
            $affiliate->course_url = $request->course_url;
            $affiliate->payment_link = $request->payment_link;
            $affiliate->status = $request->status == "on" ? 1 : 0;
            $affiliate->slug = Str::slug($nameEn);
            $affiliate->contract = uploadFile($request, 'affiliate', 'contract', 'contract', $path);
            $affiliate->invoice = uploadFile($request, 'affiliate', 'invoice', 'invoice', $path);
            $affiliate->image = uploadFile($request, 'affiliate', 'image', 'image', $path);
            $affiliate->bonus_material = uploadFile($request, 'affiliate', 'bonus_material', 'bonus_material', $path);

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $affiliate->schedule = $request->schedule;
                $affiliate->deleted_at = now();
            }

            $affiliate->save();

            $this->logActivity(['activity' => sprintf('Affiliate created.'), 'id' => $affiliate->id], true, true);

            return $this->success(['redirection' => route('affiliate.index')]);
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
        return view('affiliate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('affiliate.update');
        $programs = Program::all();
        $action = route('affiliate.update', $id);
        $affiliate = Affiliate::withTrashed()->findOrFail($id);
        return view('affiliate::affiliate', compact('action', 'affiliate','programs'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AffiliateRequest $request, $id)
    {
        $this->authorize('affiliate.update');

        try {
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $path = uploads_images('affiliate');
            $affiliate = Affiliate::withTrashed()->findOrFail($id);
            $affiliate->name_ar = $nameAr;
            $affiliate->name_en = $nameEn;
            $affiliate->start_date = $request->start_date;
            $affiliate->end_date = $request->end_date;
            $affiliate->program_id = $request->program_id;
            $affiliate->type = $request->type;
            $affiliate->value = $request->value;
            $affiliate->course_url = $request->course_url;
            $affiliate->payment_link = $request->payment_link;
            $affiliate->status = $request->status == "on" ? 1 : 0;
            $affiliate->slug = Str::slug($nameEn);
            $affiliate->contract = uploadFile($request, 'affiliate', 'contract', 'contract', $path, $affiliate);
            $affiliate->invoice = uploadFile($request, 'affiliate', 'invoice', 'invoice', $path, $affiliate);
            $affiliate->image = uploadFile($request, 'affiliate', 'image', 'image', $path, $affiliate);
            $affiliate->bonus_material = uploadFile($request, 'affiliate', 'bonus_material', 'bonus_material', $path, $affiliate);

            if ($request->has('post_or_schedule') && $request->post_or_schedule) {
                $affiliate->schedule = $request->schedule;
                $affiliate->deleted_at = now();
            }

            $affiliate->save();

            $this->logActivity(['activity' => sprintf('Affiliate updated.'), 'id' => $affiliate->id], true, true);

            return $this->success(['redirection' => route('affiliate.index')]);
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
        $this->authorize('affiliate.delete');

        try {

            $path = uploads_images('affiliate');
            $affiliate = Affiliate::withTrashed()->find(1);
            $affiliate->contract ? deleteFileIfExist($path . $affiliate->contract, true) : '';
            $affiliate->invoice ? deleteFileIfExist($path . $affiliate->invoice, true) : '';
            $affiliate->image ? deleteFileIfExist($path . $affiliate->image, true) : '';
            $affiliate->bonus_material ? deleteFileIfExist($path . $affiliate->bonus_material, true) : '';
            $affiliate->forceDelete();

            $this->logActivity(['activity' => sprintf('Affiliate deleted.'), 'id' => $affiliate->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('affiliate.delete');

        try {
            $affiliate = Affiliate::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $affiliate->restore();
                $this->logActivity(['activity' => sprintf('Affiliate active.'), 'id' => $affiliate->id], true, true);
            } else {
                $affiliate->delete();
                $this->logActivity(['activity' => sprintf('Affiliate disable.'), 'id' => $affiliate->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
