<style>
    .module-row:hover{
        background-color: aliceblue;
    }
</style>
<form action="{{ $action }}" method="post" data-redirection="{{ route('role.index') }}">
    {{ csrf_field() }}
    @if(isset($role))
        {{ method_field('PUT') }}
    @endif

    <div class="row">
        <div class="col-md-6">            
            <div class="mb-3">
                <label class="form-label">Role Name</label><span class="text-danger">*</span>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter role name" value="{{ @$role->name }}" required />
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-right">
                <button type="button" class="global-save btn btn-primary waves-effect waves-light">Save</button>
            </div>
        </div>
    </div>
    <hr class="mt-0">
    <div class="row py-1">
        <div class="col-md-6">
            <label class="mb-0 font-weight-bold">Permissions</label>
        </div>
        <div class="col-md-6">
            <div class="text-right">
                <input type="checkbox" class="form-check-input" id="allPermissionCheck">
            </div>
        </div>
    </div>

    @foreach($permissions as $module => $modulePermission)
        <div class="row py-1 bg-light {{ !$loop->first ? 'mt-2' : ''}} mb-1">
            <div class="col-sm-6">
                <label class="mb-0 font-weight-bold">{{ str_replace('_', ' ', ucfirst($module)) }}</label>
            </div>
            <div class="col-sm-6">
                <div class="text-right">
                    <input type="checkbox" class="form-check-input module-permission permission-check" data-module="{{ $module }}">
                </div>
            </div>
        </div>
        @foreach($modulePermission as $permission)
            <div class="row module-row">
                <div class="col-sm-6">
                    <label class="form-label">{{ str_replace('_', ' ', ucfirst(ltrim(strstr($permission->name, '.'), '.'))) }}</label>
                </div>
                <div class="col-sm-6">
                    <div class="text-right">
                        <input type="checkbox" name="permissions[]" class="form-check-input {{ $module }}-permission permission-check" value="{{ $permission->id }}" {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</form>