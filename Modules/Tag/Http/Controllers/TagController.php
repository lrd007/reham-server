<?php

namespace Modules\Tag\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Tag\Entities\Tag;
use Modules\Tag\Http\Requests\TagRequest;
use Yajra\DataTables\DataTables;

class TagController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('tag.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Progress'),
            __('Created At'),
            __('Action')
        ];
        $table = [
            'id' => 'tag_table',
            'source' => route('tag.list'),
            'data' => $data
        ];
        
        return view('tag::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('tag.view');

        $canUpdate = auth()->user()->can('tag.update');
        $canDelete = auth()->user()->can('tag.delete');
        $builder = Tag::select(['id', 'name' . withLocalization(), 'progress', 'created_at']);

        return $dataTables::of($builder)
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("tag.edit", $item->id), $canUpdate);
                $buttons .= deleteForm(route("tag.destroy", $item->id), $canDelete, true);
                
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
        $this->authorize('tag.create');

        $action = route('tag.store');
        return view('tag::create')->with('action', $action);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(TagRequest $request)
    {
        $this->authorize('tag.create');

        try{
            $tag = new Tag;
            $tag->name_ar = $request->name_ar;
            $tag->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $tag->progress = $request->progress ?: 0;
            $tag->save();

            $this->logActivity(['activity' => sprintf('Tag created.'), 'id' => $tag->id], true, true);

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
        return view('tag::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('tag.update');

        $tag = Tag::findOrFail($id);
        $action = route('tag.update', $id);
        return view('tag::update')->with(['tag' => $tag, 'action' => $action]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TagRequest $request, $id)
    {
        $this->authorize('tag.update');

        try{
            $tag = Tag::findOrFail($id);
            $tag->name_ar = $request->name_ar;
            $tag->name_en = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $tag->progress = $request->progress ?: 0;
            $tag->save();

            $this->logActivity(['activity' => sprintf('Tag updated.'), 'id' => $tag->id], true, true);

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
        $this->authorize('tag.delete');

        try{
            $tag = Tag::find($id);
            $tag->delete();

            $this->logActivity(['activity' => sprintf('Tag deleted.'), 'id' => $tag->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
