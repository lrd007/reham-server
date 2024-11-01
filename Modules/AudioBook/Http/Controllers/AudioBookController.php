<?php

namespace Modules\AudioBook\Http\Controllers;

use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\AudioBook\Entities\AudioBook;
use Modules\AudioBook\Http\Requests\AudioBookRequest;
use Modules\Chapter\Entities\Chapter;
use Yajra\DataTables\DataTables;
use Modules\Course\Entities\Course;

class AudioBookController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('audiobook.view');

        $data = [
            __('Id'),
            __('Name'),
            __('Author'),
            __('Chapter'),
            __('Status'),
            __('Created At'),
            __('Action')
        ];
        $table = [
            'id' => 'audiobook_table',
            'source' => route('audiobook.list'),
            'data' => $data
        ];
        
        return view('audiobook::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('audiobook.view');

        $canUpdate = auth()->user()->can('audiobook.update');
        $canDelete = auth()->user()->can('audiobook.delete');
        $builder = AudioBook::select(['id', 'name' . withLocalization(), 'author' . withLocalization(), 'chapter_id', 'deleted_at', 'created_at'])->withTrashed();

        return $dataTables::of($builder)
            ->editColumn('chapter_id', function($item) {
                return $item->chapter->{'name' . withLocalization()};
            })
            ->editColumn('deleted_at', function($item) {
                return statusSwitch($item->id, route("audiobook.change.status", $item->id), $item->deleted_at);
            })            
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {

                $buttons = editButton(route("audiobook.edit", $item->id), $canUpdate, false);
                $buttons .= deleteForm(route("audiobook.destroy", $item->id), $canDelete, true);
                
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
        $action = route('audiobook.store');
        $chapters = Chapter::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('audiobook::book', compact('action', 'chapters'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AudioBookRequest $request)
    {
        $this->authorize('audiobook.create');

        try{
            $filePath = uploads_files('audiobook');
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $authorAr = $request->author_ar;
            $authorEn = empty($request->author_en) ? $request->author_ar : $request->author_en;
    
            $audiobook = new AudioBook;
            $audiobook->name_ar = $nameAr;
            $audiobook->name_en = $nameEn;
            $audiobook->author_ar = $authorAr;
            $audiobook->author_en = $authorEn;            
            $audiobook->chapter_id = $request->chapter;
            $audiobook->is_playable = $request->is_playable ?: 0;
            $audiobook->is_downloadable	 = $request->is_downloadable ?: 0;        

            if($request->file) {
                $getID3 = new \getID3;
                $file = $getID3->analyze($request->file);
                $audiobook->duration = gmdate('H:i:s', $file['playtime_seconds']);
                $audiobook->file = uploadFile($request, 'audiobook_', 'file', 'file', $filePath);
            }        
            
            if($request->has('post_or_schedule') && $request->post_or_schedule) {
                $audiobook->schedule = $request->schedule;
                $audiobook->deleted_at = now();
            }
            
            $audiobook->save();

            $this->logActivity(['activity' => sprintf('Audio book created.'), 'id' => $audiobook->id], true, true);

            return $this->success(['redirection'=> route('audiobook.index')]);
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
        return view('audiobook::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = route('audiobook.update', $id);
        $audiobook = AudioBook::withTrashed()->findOrFail($id);
        $chapters = Chapter::orderBy('name' . withLocalization())->select('name' . withLocalization(), 'id')->get();
        return view('audiobook::book', compact('action', 'chapters', 'audiobook'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AudioBookRequest $request, $id)
    {
        $this->authorize('audiobook.update');

        try{
            $filePath = uploads_files('audiobook');
            $nameAr = $request->name_ar;
            $nameEn = empty($request->name_en) ? $request->name_ar : $request->name_en;
            $authorAr = $request->author_ar;
            $authorEn = empty($request->author_en) ? $request->author_ar : $request->author_en;
    
            $audiobook = AudioBook::withTrashed()->findOrFail($id);
            $audiobook->name_ar = $nameAr;
            $audiobook->name_en = $nameEn;
            $audiobook->author_ar = $authorAr;
            $audiobook->author_en = $authorEn;            
            $audiobook->chapter_id = $request->chapter;
            $audiobook->is_playable = $request->is_playable ?: 0;
            $audiobook->is_downloadable	 = $request->is_downloadable ?: 0;        

            if($request->file) {
                $getID3 = new \getID3;
                $file = $getID3->analyze($request->file);
                $audiobook->duration = gmdate('H:i:s', $file['playtime_seconds']);
                $audiobook->file = uploadFile($request, 'audiobook_', 'file', 'file', $filePath);
            }        
            
            if($request->has('post_or_schedule') && $request->post_or_schedule) {
                $audiobook->schedule = $request->schedule;
                $audiobook->deleted_at = now();
            }
            
            $audiobook->save();

            $this->logActivity(['activity' => sprintf('Audio book updated.'), 'id' => $audiobook->id], true, true);

            return $this->success(['redirection'=> route('audiobook.index')]);
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
        $this->authorize('audiobook.delete');

        try{
    
            $audiobook = AudioBook::withTrashed()->findOrFail($id);
            $audiobook->forceDelete();

            $this->logActivity(['activity' => sprintf('Audio book deleted.'), 'id' => $audiobook->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('audiobook.delete');

        try{
            $audiobook = AudioBook::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $audiobook->restore();
                $this->logActivity(['activity' => sprintf('Audio book active.'), 'id' => $audiobook->id], true, true);
            } else {
                $audiobook->delete();
                $this->logActivity(['activity' => sprintf('Audio book disabled.'), 'id' => $audiobook->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
