<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\User\Entities\UserActivity;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
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

    public function userActivityIndex()
    {
        $this->authorize('users_activity.view');

        $data = [
            'Id',
            'User Name',
            'Activity',
            'Activity Time',
            'Status',
            'Action'
        ];
        $table = [
            'id' => 'admin_user_table',
            'source' => route('user.activity.list'),            
            'data' => $data
        ];
        
        return view('user::user-activity', compact('table'));
    }


    public function list(DataTables $dataTables)
    {
        $this->authorize('users_activity.view');

        $builder = UserActivity::select(['id', 'user_id','activity', 'created_at'])->where('type', 0);

        return $dataTables::of($builder)

            ->editColumn('user_id', function ($item){
                return @$item->user->name;
            }, 1)
            ->editColumn('created_at', function ($item){
                return showDateTime($item->created_at);
            }, 3)
            ->addColumn('status', function ($item){
                $status = '<span><small class="mdi mdi-circle text-danger"></small> Offline</span>';
                if(isset($item->user) && $item->user->isOnline()) {
                    $status = '<span><small class="mdi mdi-circle text-success"></small> Online</span>';
                }
                return $status;
            }, 4)
            ->addColumn('action', function ($item){
                return 'Action';
            }, 5)
            ->rawColumns(range(0, 5))
            ->make(false);
    }

    public function auditActivityIndex()
    {
        $this->authorize('audit_log.view');

        $data = [
            __('Id'),
            __('Activity'),
            __('Activity Time'),
            __('Activity By'),
            __('Detail')
        ];
        $table = [
            'id' => 'admin_user_table',
            'source' => route('audit-log.activity.list'),            
            'data' => $data
        ];
        
        return view('admin::activity.audit-index', compact('table'));
    }


    public function auditList(DataTables $dataTables)
    {
        $this->authorize('audit_log.view');

        $builder = UserActivity::select(['id', 'activity', 'created_at', 'created_by', 'modal_id'])->where('type', 1);

        return $dataTables::of($builder)

            ->removeColumn('modal_id')
            ->editColumn('created_at', function ($item){
                return showDateTime($item->created_at);
            })
            ->editColumn('created_by', function($item) {
                return @$item->user->name;
            })
            ->addColumn('action', function ($item){
                return '<button type="button" class="action-icon btn modal-button" data-url="'. route('audit-log.activity.get', $item->id) .'" data-toggle="modal" title="Edit"> <i class="text-info mdi mdi-eye"></i></button>';
            }, 5)
            ->rawColumns(range(0, 5))
            ->make(false);
    }

    public function auditActivityShow($id)
    {
        $userActivity = UserActivity::findOrFail($id);
        $input = json_decode($userActivity->input);
        return view('admin::activity.show', compact('userActivity', 'input'));
    }

    public function changeLanguage()
    {
        app()->setLocale(request('locale'));
        session()->put('locale', request('locale'));
        return redirect()->back();
    }
    
}
