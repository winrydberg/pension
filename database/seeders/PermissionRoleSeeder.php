<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Reset cached roles and permissions
        //   app()[PermissionRegistrar::class]->forgetCachedPermissions();

          // create permissions
          // Permission::create(['name' => 'edit articles']);
          // Permission::create(['name' => 'delete articles']);
          // Permission::create(['name' => 'publish articles']);
          // Permission::create(['name' => 'unpublish articles']);
          
          Role::create(['name' => 'system-admin']);
          Role::create(['name' => 'claim-entry']);
          Role::create(['name' => 'audit']);
          Role::create(['name' => 'accounting']);
          Role::create(['name' => 'front-desk']);
    }
}
