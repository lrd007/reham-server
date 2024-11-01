<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Yajra\DataTables\DataTables;
use Modules\Role\Http\Requests\RoleRequest;
use Spatie\Permission\Models\Permission;
use Modules\Role\Entities\Role;
use Exception;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('role.view');

        $data = [
            'Id',
            'Name',
            'Created At',
            'Action'
        ];
        $table = [
            'id' => 'role_table',
            'source' => route('role.list'),            
            'data' => $data
        ];
        
        return view('role::index', compact('table'));
    }


    public function list(DataTables $dataTables)
    {
        $this->authorize('role.view');

        $canUpdate = auth()->user()->can('role.update');
        $canDelete = auth()->user()->can('role.delete');
        $builder = Role::select(['id','name', 'created_at', 'deleted_at'])->withTrashed();

        return $dataTables::of($builder)            
            // ->addColumn('permissions', function ($item){
            //     $label = '';
            //     foreach($item->permissions as $permission) {
            //         $label .= '<label class="badge bg-soft-primary text-primary p-1">' . $permission->name . '</label> ';
            //     }

            //     return $label;
            // }, 2)
            ->removeColumn('deleted_at')
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            }, 2)
            ->addColumn('Action', function ($item) use ($canUpdate, $canDelete) {
                
                $buttons = '';
                if($item->name != 'Administrator') {
                    $buttons = editButton(route("role.edit", $item->id), $canUpdate, false);
                    $buttons .= deleteForm(route("role.destroy", $item->id), $canDelete, true);                        
                }

                return $buttons;
                
            }, 3)
            ->rawColumns(range(0, 4))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('role.create');

        $action = route('role.store');
        $permissions = Permission::select('id', 'name', 'module')->orderBy('name')->get()->groupBy('module');
        return view('role::create')->with(['action' => $action, 'permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('role.create');

        $role = new Role;
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);

        $this->logActivity(['activity' => sprintf('Role created.'), 'id' => $role->id], true, true);

        return $this->success();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('role::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('role.update');

        $role = Role::findOrFail($id);
        $action = route('role.update', $id);
        $permissions = Permission::select('id', 'name', 'module')->orderBy('name')->get()->groupBy('module');
        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        return view('role::update')->with(['role' => $role, 'action' => $action, 'permissions' => $permissions, 'rolePermissions' => $rolePermissions]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(RoleRequest $request, $id)
    {
        $this->authorize('role.update');

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->permissions()->sync($request->permissions);

        $this->logActivity(['activity' => sprintf('Role updated.'), 'id' => $role->id], true, true);

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('role.delete');

        try{
            $role = Role::findOrFail($id);
            if($role->users()->count()) {
                return $this->error('You can\'t archive '. $role->name .' as it attached in some user(s).');
            }
            $role->forcedelete();

            $this->logActivity(['activity' => sprintf('Role deleted.'), 'id' => $role->id], true, true);

            return $this->success();
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function recover($id)
    {
        $this->authorize('role.delete');

        try{
            $role = Role::withTrashed()->findOrFail($id);
            $role->restore();

            return $this->success();
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
