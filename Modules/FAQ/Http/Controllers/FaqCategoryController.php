<?php

namespace Modules\FAQ\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\FAQ\Entities\Category;
use Exception;
use Modules\FAQ\Http\Requests\CategoryRequest;

class FaqCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('category.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Type'),
            __('Created At'),
            __('Status'),            
            __('Action')
        ];

        $table = [
            'id' => 'faq_table',
            'source' => route('category.list'),
            'data' => $data
        ];
        
        return view('faq::category.index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('category.view');

        $canUpdate = auth()->user()->can('category.update');
        $canDelete = auth()->user()->can('category.delete');
        $builder = Category::select(['id','name' . withLocalization(), 'type', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)        
            ->editColumn('type', function($item) {
                return $item->type ? __('Legal') : __('General');
            })
            ->editColumn('deleted_at', function($item) {
                return statusSwitch($item->id, route("category.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("category.edit", $item->id), $canUpdate, true);
                $buttons .= deleteForm(route("category.destroy", $item->id), $canDelete, true);
                
                return $buttons;
            })
            ->rawColumns(range(0, 10))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $action = route('category.store');
        return view('faq::category.create', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CategoryRequest $request)
    {
        $this->authorize('category.create');

        try{
            $category = new Category;
            $category->name_ar = $request->name_ar;
            $category->name_en = $request->name_en;
            $category->type = $request->type;
            $category->save();

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
        return view('faq::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('category.update');

        $action = route('category.update', $id);
        $faqCategory = Category::withTrashed()->findOrFail($id);
        return view('faq::category.update', compact('action', 'faqCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CategoryRequest $request, $id)
    {
        $this->authorize('category.update');

        try{

            $category = Category::withTrashed()->findOrFail($id);
            $category->name_ar = $request->name_ar;
            $category->name_en = $request->name_en;
            $category->type = $request->type;
            $category->save();

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
        $this->authorize('category.delete');

        try{
            $category = Category::withTrashed()->findOrFail($id);
            $category->forceDelete();
            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('category.delete');

        try{

            $category = Category::withTrashed()->findOrFail($id);            

            if(isset(request()->status)) {
                $category->restore();
            } else {
                $category->delete();
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
