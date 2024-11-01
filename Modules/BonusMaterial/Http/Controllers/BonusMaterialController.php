<?php

namespace Modules\BonusMaterial\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\BonusMaterial\Entities\BonusMaterial;
use Modules\BonusMaterial\Entities\BonusMaterialFile;
use Modules\BonusMaterial\Http\Requests\BonusMaterialRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class BonusMaterialController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('bonus_material.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'bonus_material_table',
            'source' => route('bonusmaterial.list'),
            'data' => $data
        ];

        return view('bonusmaterial::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('bonus_material.view');

        $canUpdate = auth()->user()->can('bonus_material.update');
        $canDelete = auth()->user()->can('bonus_material.delete');
        $builder = BonusMaterial::withTrashed()->select(['id', 'name' . withLocalization(), 'created_at', 'deleted_at']);

        return $dataTables::of($builder)
            ->editColumn('deleted_at', function ($item) {
                return statusSwitch($item->id, route("bonusmaterial.change.status", $item->id), $item->deleted_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("bonusmaterial.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("bonusmaterial.destroy", $item->id), $canDelete, true);

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
        $this->authorize('bonus_material.create');

        $action = route('bonusmaterial.store');
        return view('bonusmaterial::material', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BonusMaterialRequest $request)
    {
        $this->authorize('bonus_material.create');

        DB::beginTransaction();

        try {
            $bonusMaterial = new BonusMaterial;
            $bonusMaterial->name_ar = $request->name_ar;
            $bonusMaterial->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $bonusMaterial->save();

            $path = uploads_files('bonus_materials');

            foreach($request->description_ar as $key => $description_ar) {
                
                $material = new BonusMaterialFile;
                $material->bonus_material_id = $bonusMaterial->id;    
                $material->description_ar = $description_ar;
                $material->description_en = empty($request->description_en[$key]) ? $description_ar : $request->description_en[$key]; 
                $material->type = $request->type[$key] == 'vimeo' ? 1 : 0;
                if($request->type[$key] == 'video' && !empty($request->file[$key])) {
                    $material->file = isset($request->file[$key]) ? $this->uploadFile($request->file[$key], 'bonus_material_', 'bonus_material', $path) : NULL;
                } else {
                    $material->file = $request->vimeo[$key];
                }
                $material->save();
            }

            $this->logActivity(['activity' => sprintf('Bonus material created.'), 'id' => $bonusMaterial->id], true, true);

            DB::commit();

            return $this->success(['redirection' => route('bonusmaterial.index')]);
        } catch (Exception $e) {
            DB::rollBack();
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
        return view('bonusmaterial::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('bonus_material.update');

        $action = route('bonusmaterial.update', $id);
        $bonusMaterial = BonusMaterial::withTrashed()->findOrFail($id);
        return view('bonusmaterial::material', compact('action', 'bonusMaterial'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BonusMaterialRequest $request, $id)
    {
        $this->authorize('bonus_material.update');

        DB::beginTransaction();

        try {
            $bonusMaterial = BonusMaterial::withTrashed()->findOrFail($id);
            $bonusMaterial->name_ar = $request->name_ar;
            $bonusMaterial->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $bonusMaterial->save();

            BonusMaterialFile::where('bonus_material_id', $bonusMaterial->id)->delete();
            $path = uploads_files('bonus_materials');
            
            foreach($request->description_ar as $key => $description_ar) {                

                $material = new BonusMaterialFile;
                $material->bonus_material_id = $bonusMaterial->id;
                $material->description_ar = $description_ar;
                $material->description_en = empty($request->description_en[$key]) ? $description_ar : $request->description_en[$key]; 
                $material->type = $request->type[$key] == 'vimeo' ? 1 : 0;
                if($request->type[$key] == 'video' && !empty($request->file[$key])) {
                    $material->file = isset($request->file[$key]) ? $this->uploadFile($request->file[$key], 'bonus_material_', 'bonus_material', $path) : NULL;
                } else {
                    $material->file = $request->vimeo[$key];
                }
                $material->save();
            }

            $this->logActivity(['activity' => sprintf('Bonus material created.'), 'id' => $bonusMaterial->id], true, true);

            DB::commit();

            return $this->success(['redirection' => route('bonusmaterial.index')]);
        } catch (Exception $e) {
            DB::rollBack();
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
        $this->authorize('bonus_material.delete');

        try {
            $bonusMaterial = BonusMaterial::withTrashed()->findOrFail($id);
            $bonusMaterial->materials()->delete();
            $bonusMaterial->forcedelete();

            $this->logActivity(['activity' => sprintf('Bonus material deleted.'), 'id' => $bonusMaterial->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function bonusmaterialBonus(Request $request)
    {

        $this->authorize('bonus_material.create');

        $request->validate([
            'bonus_material_id' => 'required'
        ], [
            'bonus_material_id.required' => __('Please create bonus first.'),
        ]);

        try {

            $path = uploads_files('bonus_materials');

            $material = new BonusMaterialFile;
            $material->bonus_material_id = $request->bonus_material_id;
            $material->file = uploadFile($request, 'bonus_material_', 'file', 'bonus_material', $path);
            $material->save();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function bonusmaterialBonusDelete($id)
    {

        $this->authorize('bonus_material.delete');

        try {

            $path = uploads_files('bonus_materials');
            $material = BonusMaterialFile::findOrFail($id);
            deleteFileIfExist($path . $material->file, true);
            $material->delete();

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('bonus_material.delete');

        try {
            $bonusMaterial = BonusMaterial::withTrashed()->findOrFail($id);

            if (isset(request()->status)) {
                $bonusMaterial->restore();
                $this->logActivity(['activity' => sprintf('Bonus material active.'), 'id' => $bonusMaterial->id], true, true);
            } else {
                $bonusMaterial->delete();
                $this->logActivity(['activity' => sprintf('Bonus material disable.'), 'id' => $bonusMaterial->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    function uploadFile($file, $prefix, $fileName, $path, $model = null, $isImage = false)
    {
        if (!$file && $model) {
            return $model->{$fileName};
        }

        if($file) {
            if($model && !empty(trim($model->{$fileName}))) {
                deleteFileIfExist($path . $model->{$fileName}, true);
            }
        
            return $isImage ? upload_image($file, $path) : upload_file($file, $path, $prefix);
        }

        return null;
    }
}
