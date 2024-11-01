<?php

namespace Modules\SuccessStory\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;
use Modules\SuccessStory\Entities\SuccessStory;

class SuccessStoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('story.view');

        $data = [
            __('Id'),
            // __('Program'),
            // __('Course'),
            __('Title'),
            __('Comment'),
            __('Subscriber'),
            __('Created At'),
            __('Status'),            
            __('Action')
        ];
        $table = [
            'id' => 'successstory_table',
            'source' => route('successstory.list'),
            'data' => $data
        ];
        
        return view('successstory::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('story.view');

        $canDelete = auth()->user()->can('successstory.delete');
        // $builder = SuccessStory::select(['id','program_id', 'course_id', 'comment', 'user_id', 'created_at', 'deleted_at'])->withTrashed();
        $builder = SuccessStory::select(['id','title', 'comment', 'user_id', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            ->removeColumn('file_url')
            // ->editColumn('program_id', function ($item){
            //     return @$item->program->{'name' . withLocalization()};
            // })
            // ->editColumn('course_id', function ($item){
            //     return @$item->course->{'name' . withLocalization()};
            // })
            ->editColumn('title', function ($item){
                return strlen($item->title) > 50 ? mb_substr($item->title, 0, 50) . "..." : $item->title;
            })
            ->editColumn('comment', function ($item){
                return strlen($item->comment) > 50 ? mb_substr($item->comment, 0, 50) . "..." : $item->comment;
            })
            ->editColumn('user_id', function ($item){
                return @$item->user->name;
            })
            ->editColumn('deleted_at', function ($item){
                return statusSwitch($item->id, route("successstory.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('action', function ($item) use ($canDelete){
                $buttons = '<button class="action-icon btn modal-button" title="Fee History" type="button" data-url="' . route('successstory.show', $item->id) .'" data-toggle="modal"><i class="text-info mdi mdi-eye"></i></button>'; 
                $buttons .= editButton(route("successstory.edit", $item->id),true, false);
                $buttons .= deleteForm(route("successstory.destroy", $item->id), $canDelete, true);
                return $buttons;
            }, 7)
            ->rawColumns(range(0, 7))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('successstory::create');
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
        $successstory = SuccessStory::withTrashed()->findOrFail($id);
        return view('successstory::show', compact('successstory'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $action = route('successstory.update', $id);
        $successstory = SuccessStory::withTrashed()->findOrFail($id);
        return view('successstory::edit',compact('successstory','action'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try{
            $filePath = uploads_files('success_story');
            $success_story = SuccessStory::findOrFail($id);
            $success_story->title = $request->title;
            $success_story->comment = $request->comment;
            $success_story->file = uploadFile($request, 'success_story_', 'file', 'file', $filePath, $success_story);
            
            $success_story->save();

            $this->logActivity(['activity' => sprintf('Success Story updated.'), 'id' => $success_story->id], true, true);

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
        $this->authorize('story.delete');

        try{
            $successstory = successstory::withTrashed()->findOrFail($id);
            $successstory->forceDelete();

            $this->logActivity(['activity' => sprintf('Story deleted.'), 'id' => $successstory->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('story.delete');

        try{
            $successstory = successstory::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $successstory->restore();
                $this->logActivity(['activity' => sprintf('Story active.'), 'id' => $successstory->id], true, true);
            } else {
                $successstory->delete();
                $this->logActivity(['activity' => sprintf('Story disabled.'), 'id' => $successstory->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
        
    }

    function editButton($route, $hasPermission = false, $modal = true) {
        if(!$hasPermission) {
            return '';
        }
        $button = '<button type="button" class="action-icon btn modal-button" data-url="'. $route .'" data-toggle="modal" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></button>';
        if(!$modal) {
            $button = '<a class="action-icon btn" href="'. $route .'" title="Edit"> <i class="mdi mdi-square-edit-outline"></i></a>';
        }
        return $button;
    }
}
