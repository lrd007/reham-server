<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\User\Entities\User;
use Modules\Admin\Http\Requests\AdminRequest;
use Spatie\Permission\Models\Permission;
use Modules\Role\Entities\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Exception;
use Hash;

class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('admin_user.view');

        $data = [
            'Id',
            'Name',
            'Email',
            'Role',
            'Last Login',
            'Created At',
            'Action'
        ];
        $table = [
            'id' => 'admin_user_table',
            'source' => route('admin-user.list'),
            'data' => $data
        ];

        return view('admin::index', compact('table'));
    }


    public function list(DataTables $dataTables)
    {
        $this->authorize('admin_user.view');

        $canUpdate = auth()->user()->can('admin_user.update');
        $canDelete = auth()->user()->can('admin_user.delete');
        $builder = User::select(['id','name', 'email', 'last_login', 'created_at', 'last_activity', 'deleted_at'])->withTrashed()->where('is_admin', 1);

        return $dataTables::of($builder)
            ->removeColumn('deleted_at')
            ->addColumn('role', function ($item){
                $label = '';
                foreach($item->roles as $roles) {
                    $label .= '<label class="badge bg-soft-primary text-primary p-1">' . $roles->name . '</label> ';
                }

                return $label;
            }, 3)
            ->editColumn('last_login', function ($item){
                return showDateTime($item->last_login);
            },4)
            ->editColumn('created_at', function ($item){
                return showDate($item->created_at);
            }, 5)
            ->addColumn('action', function ($item) use ($canUpdate, $canDelete){

                $isSoftDelete = !empty($item->deleted_at);
                if($isSoftDelete) {
                    $buttons = recoverButton(route("admin-user.recover", $item->id), $canDelete);
                } else {
                    $buttons = editButton(route("admin-user.edit", $item->id), $canUpdate);
                    if(Auth::user()->id != $item->id) {
                        $buttons .= deleteForm(route("admin-user.destroy", $item->id), $canDelete, $isSoftDelete);
                    }
                }

                return $buttons;
            }, 6)
            ->rawColumns(range(0, 7))
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $isTeacher = request()->is_teacher;
        if($isTeacher) {
            $this->authorize('teacher.create');
        } else {
            $this->authorize('admin_user.create');
        }

        $action = route('admin-user.store');
        $roles = Role::select('id', 'name')->get();
        $permissions = Permission::select('id', 'name')->orderBy('name')->get();

        return view('admin::create')->with(['action' => $action, 'roles' => $roles, 'permissions' => $permissions, 'isTeacher' => $isTeacher]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdminRequest $request)
    {
        $user = 'Admin';
        if($request->is_teacher) {
            $this->authorize('teacher.create');
            $user = 'Teacher';
        } else {
            $this->authorize('admin_user.create');
        }

        try {
            $admin = new User;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = bcrypt($request->password);
            $admin->is_admin = 1;
            $admin->save();

            $admin->roles()->sync($request->role);
            $admin->permissions()->sync($request->permission);

            $this->logActivity(['activity' => sprintf('Admin user created.'), 'id' => $admin->id], true, true);

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
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $isTeacher = request()->is_teacher;
        if($isTeacher) {
            $this->authorize('teacher.update');
        } else {
            $this->authorize('admin_user.update');
        }

        $admin = User::findOrFail($id);
        $roles = Role::select('id', 'name')->orderBy('name')->get();
        $permissions = Permission::select('id', 'name')->orderBy('name')->get();
        $action = route('admin-user.update', $id);

        return view('admin::update')->with(['admin' => $admin, 'action' => $action, 'roles' => $roles, 'permissions' => $permissions, 'isTeacher' => $isTeacher]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdminRequest $request, $id)
    {
        $user = 'Admin';
        if($request->is_teacher) {
            $this->authorize('teacher.update');
            $user = 'Teacher';
        } else {
            $this->authorize('admin_user.update');
        }

        try {
            $admin = User::find($id);
            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->password) {
                $admin->password = bcrypt($request->password);
            }
            $admin->save();

            $admin->roles()->sync($request->role);
            $admin->permissions()->sync($request->permission);

            $this->logActivity(['activity' => sprintf('Admin user updated.'), 'id' => $admin->id], true, true);

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
        $this->authorize('admin_user.delete');

        try{
            $user = User::find($id);
            $user->delete();

            $this->logActivity(['activity' => sprintf('Admin user deleted.'), 'id' => $user->id], true, true);

            return $this->success();
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function recover($id)
    {
        $userType = 'Admin';
        if(request()->is_teacher) {
            $this->authorize('teacher.delete');
            $userType = 'Teacher';
        } else {
            $this->authorize('admin_user.delete');
        }

        try{
            $user = User::withTrashed()->find($id);
            $user->restore();

            return $this->success();
        } catch(Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function uploadCertificate($request, $user = null)
    {
        $flag = $user && !empty(trim($user->vaccination_certificate));
        if (!$request->hasFile('vaccination_certificate')) {
            return $flag ? $user->vaccination_certificate : null;
        }

        if($flag) {
            deleteFileIfExist($user->vaccination_certificate);
        }

        $file = $request->file('vaccination_certificate');
        $path = '/assets/vaccination_certificate';
        $certificateName = 'vaccine_certi_' . time() . '.' .$file->getClientOriginalExtension();
        $file->move(public_path($path), $certificateName);

        return $path . '/' . $certificateName;
    }

    public function profile($id)
    {
        if(auth()->user()->id != $id) {
            return redirect('/');
        }

        $admin = User::findOrFail($id);
        $action = route('admin-user.update.profile', $id);
        return view('admin::profile')->with(['admin' => $admin, 'action' => $action]);
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|required_with:current_password|min:6|max:50',
            'current_password' => 'nullable|required_with:password|min:6|max:50',
        ]);

        if ($request->get('current_password') && !(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return $this->error(__("Your current password does not matches with the password"));
        }

        try {
            $admin = User::find($id);
            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->password) {
                $admin->password = bcrypt($request->password);
            }
            $admin->save();

            $this->logActivity(['activity' => sprintf('Profile updated.'), 'id' => $admin->id], true, true);

            return $this->success();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
