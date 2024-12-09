<?php

namespace Database\Seeders;

use App\Constants\Role as ConstantsRole;
use Illuminate\Database\Seeder;
use App\Permissions\Permissions;
use App\Permissions\Roles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $mUserPers = Permissions::userPermissions();
        $userPers = array_map(function ($per) {
            return Permission::create(['name' => $per]);
        }, $mUserPers);

        $mAdminPers = Permissions::adminPermissions();
        $adminPers = array_map(function ($per) {
            return Permission::findOrCreate($per);
        }, $mAdminPers);

        // create roles and assign existing permissions
        $user = Role::create(['name' => ConstantsRole::USER]);
        $admin = Role::create(['name' => ConstantsRole::ADMIN]);


        $user->syncPermissions($userPers);
        $user->syncPermissions($adminPers);
    }
}
