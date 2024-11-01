<?php

namespace Modules\Comment\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;
use Modules\Comment\Entities\Comment;

class CommentController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('comment.view');

        $data = [
            __('Id'),
            // __('Program'),
            __('Comment'),
            __('Comment By'),            
            __('Created At'),
            __('Status'),
            __('Action')
        ];
        $table = [
            'id' => 'comment_table',
            'source' => route('comment.list'),
            'data' => $data
        ];
        
        return view('comment::index', compact('table'));
    }

    public function list(DataTables $dataTables)
    {
        $this->authorize('comment.view');

        $canDelete = auth()->user()->can('comment.delete');
       // $builder = Comment::select(['id','model_id', 'comment', 'user_id', 'created_at', 'deleted_at'])->withTrashed();
       $builder = Comment::select(['id', 'comment', 'user_id', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)
            // ->editColumn('model_id', function ($item){
            //     return @$item->program->{'name' . withLocalization()};
            // })
            ->editColumn('comment', function ($item){
                return strlen($item->comment) > 50 ? mb_substr($item->comment, 0, 50) . "..." : $item->comment;
            })
            ->editColumn('user_id', function ($item){
                return @$item->user->name;
            })
            ->editColumn('deleted_at', function ($item){
                return statusSwitch($item->id, route("comment.change.status", $item->id), $item->deleted_at);
            })
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            })
            ->addColumn('action', function ($item) use ($canDelete){

                $buttons = '<button class="action-icon btn modal-button" title="Fee History" type="button" data-url="' . route('comment.show', $item->id) .'" data-toggle="modal"><i class="text-info mdi mdi-eye"></i></button>';
                $buttons .= deleteForm(route("comment.destroy", $item->id), $canDelete, true);
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
        return view('comment::create');
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
        $comment = Comment::withTrashed()->findOrFail($id);
        return view('comment::show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('comment::edit');
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
        $this->authorize('comment.delete');

        try{
            $comment = Comment::withTrashed()->findOrFail($id);
            $comment->forceDelete();

            $this->logActivity(['activity' => sprintf('Comment deleted.'), 'id' => $comment->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function changeStatus($id)
    {
        $this->authorize('comment.delete');

        try{
            $comment = Comment::withTrashed()->findOrFail($id);

            if(isset(request()->status)) {
                $comment->restore();
                $this->logActivity(['activity' => sprintf('Comment active.'), 'id' => $comment->id], true, true);
            } else {
                $comment->delete();
                $this->logActivity(['activity' => sprintf('Comment disabled.'), 'id' => $comment->id], true, true);
            }

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
