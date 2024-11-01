<?php

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;
use Modules\Course\Entities\CoursePackage;
use Modules\Course\Http\Requests\CoursePackageRequest;

class CoursePackageController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('course_package.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Days'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'course_package_table',
            'source' => route('coursepackage.list'),
            'data' => $data
        ];
        
        return view('course::coursepackage.index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('course_package.view');

        $canUpdate = auth()->user()->can('course_package.update');
        $canDelete = auth()->user()->can('course_package.delete');
        $builder = CoursePackage::select(['id', 'name' . withLocalization(), 'days', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            ->editColumn('deleted_at', function($item) {
                return statusSwitch($item->id, route("coursepackage.change.status", $item->id), $item->deleted_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("coursepackage.edit", $item->id), $canUpdate);
                $buttons .= deleteForm(route("coursepackage.destroy", $item->id), $canDelete, true);
                
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
        $this->authorize('course_package.create');

        $action = route('coursepackage.store');
        return view('course::coursepackage.create')->with('action', $action);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CoursePackageRequest $request)
    {
        $this->authorize('course_package.create');

        try{
            $coursePackage = new CoursePackage;
            $coursePackage->name_ar = $request->name_ar;
            $coursePackage->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $coursePackage->days = $request->days ?: 0;
            $coursePackage->save();

            $this->logActivity(['activity' => sprintf('Course Package created.'), 'id' => $coursePackage->id], true, true);

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
        return view('course::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('course_package.update');

        $coursePackage = CoursePackage::withTrashed()->findOrFail($id);
        $action = route('coursepackage.update', $id);
        return view('course::coursepackage.update')->with(['coursePackage' => $coursePackage, 'action' => $action]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CoursePackageRequest $request, $id)
    {
        $this->authorize('course_package.create');

        try{
            $coursePackage = CoursePackage::withTrashed()->findOrFail($id);
            $coursePackage->name_ar = $request->name_ar;
            $coursePackage->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $coursePackage->days = $request->days ?: 0;
            $coursePackage->save();

            $this->logActivity(['activity' => sprintf('Course Package updated.'), 'id' => $coursePackage->id], true, true);

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
        $this->authorize('course_package.delete');

        try{
            $coursePackage = CoursePackage::withTrashed()->findOrFail($id);
            $coursePackage->forceDelete();

            $this->logActivity(['activity' => sprintf('Course Package deleted.'), 'id' => $coursePackage->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('course_package.delete');

        try{

            $coursePackage = CoursePackage::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $coursePackage->restore();
                $this->logActivity(['activity' => sprintf('Course Package active.'), 'id' => $coursePackage->id], true, true);
            } else {
                $coursePackage->delete();
                $this->logActivity(['activity' => sprintf('Course Package disable.'), 'id' => $coursePackage->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
