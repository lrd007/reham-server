<form action="{{ $action }}" method="post">
    {{ csrf_field() }}
    @if(isset($admin))
        {{ method_field('PUT') }}
    @endif
    @if(isset($isTeacher) && $isTeacher)
        <input type="hidden" name="is_teacher" value="1">
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Name</label><span class="text-danger">*</span>
                <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ @$admin->name }}" required />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Email</label><span class="text-danger">*</span>
                <input type="text" name="email" class="form-control" placeholder="Enter email" value="{{ @$admin->email }}" required />
            </div>
        </div>
    </div>
    
    <div class="row">
        
        <div class="col-sm-12">
            <div class="form-group">
                <label class="form-label">Password</label>
                @if(!isset($admin))
                    <span class="text-danger">*</span>
                @endif
                <input type="password" name="password" class="form-control" placeholder="Enter password" required />
            </div>
        </div>
    </div>
        
    <div class="form-group">
        <label class="form-label">Role</label><span class="text-danger">*</span>
        <select name="role[]" class="form-control select2" data-placeholder="{{ __('Select') }}" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @if(isset($admin)) @foreach($admin->roles as $adminRole) @if($adminRole->id == $role->id) {{ 'Selected' }} @endif @endforeach @endif>{{ $role->name }}</option>        
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label">Permission</label>
        <select name="permission[]" class="form-control select2" data-placeholder="{{ __('Select') }}" multiple>
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}" @if(isset($admin)) @foreach($admin->permissions as $adminPermission) @if($adminPermission->id == $permission->id) {{ 'Selected' }} @endif @endforeach @endif>{{ str_replace('_', ' ', str_replace('.', ' | ', ucfirst($permission->name))) }}</option>        
            @endforeach
        </select>
    </div>  
    
    <div class="text-right">
        <button type="button" class="save-button btn btn-primary waves-effect waves-light">Save</button>
        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" data-dismiss="modal" aria-hidden="true" >Cancel</button>
    </div>
</form>