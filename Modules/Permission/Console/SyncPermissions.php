<?php

namespace Modules\Permission\Console;

use Illuminate\Console\Command;
use Modules\User\Entities\User;
use Modules\Role\Entities\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $basePermissions = config('permission.base_permissions');
        $modulePermissionsWithBase = config('permission.module_permissions_with_base');
        $modulePermissionsExcludeBase = config('permission.module_permissions_exclude_base');

        foreach($modulePermissionsWithBase as $module => $modulePermission) {            

            $moduleName = is_array($modulePermission) ? $module : $modulePermission;
            $modulePermission = is_array($modulePermission) && !empty($modulePermission) ? array_merge($basePermissions, $modulePermission) : $basePermissions;

            foreach($modulePermission as $permission) {
                $permission = $moduleName . '.' . $permission;
                Permission::firstOrCreate([
                    'name' => $permission,
                    'module' => $moduleName
                ]);
            }
        }

        foreach($modulePermissionsExcludeBase as $module => $modulePermission) {
            
            if(is_array($modulePermission)) {
                foreach($modulePermission as $permission) {
                    $permission = $module . '.' . $permission;
                    Permission::firstOrCreate([
                        'name' => $permission,
                        'module' => $module
                    ]);
                }
            }
        }
        
        /**
         * Find or create Administrtor role if not exist
         * And assign all permission to it.
         */
        $role = Role::firstOrCreate([
            'name' => 'Administrator'
        ]);        
        $role->permissions()->sync(Permission::pluck('id')->toArray());

        /**
         * Find first admin & assign role to it.
         */
        $admin = User::where('name', 'Administrator')->where('is_admin', 1)->first();
        $adminRoles = $admin->roles->pluck('id')->toArray();
        $roles = array_unique(array_merge($adminRoles, [$role->id]));
        $admin->roles()->sync($roles);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
