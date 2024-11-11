<?php

namespace Database\Seeders;

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
        Permission::create(['name' => Permissions::UpdateOwnProfile]);

        // create roles and assign existing permissions
        $student = Role::create(['name' => Roles::STUDENT]);
        $student->givePermissionTo(Permissions::UpdateOwnProfile);
    }
}
