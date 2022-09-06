<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Access Admin']);
        Permission::create(['name' => 'Access Roles']);

        Permission::create(['name' => 'List Users']);
        Permission::create(['name' => 'New Users']);
        Permission::create(['name' => 'Edit Users']);
        Permission::create(['name' => 'Delete Users']);
        
        Permission::create(['name' => 'List Services']);
        Permission::create(['name' => 'New Services']);
        Permission::create(['name' => 'Edit Services']);
        Permission::create(['name' => 'Delete Services']);

        Permission::create(['name' => 'List Providers']);
        Permission::create(['name' => 'New Providers']);
        Permission::create(['name' => 'Edit Providers']);
        Permission::create(['name' => 'Delete Providers']);
        
        Permission::create(['name' => 'List Shops']);
        Permission::create(['name' => 'New Shops']);
        Permission::create(['name' => 'Edit Shops']);
        Permission::create(['name' => 'Delete Shops']);

        Permission::create(['name' => 'List Materials']);
        Permission::create(['name' => 'New Materials']);
        Permission::create(['name' => 'Edit Materials']);
        Permission::create(['name' => 'Delete Materials']);
        
        Permission::create(['name' => 'List Payments']);
        Permission::create(['name' => 'New Payments']);
        Permission::create(['name' => 'Edit Payments']);
        Permission::create(['name' => 'Delete Payments']);
        
        Permission::create(['name' => 'List Clients']);
        Permission::create(['name' => 'New Clients']);
        Permission::create(['name' => 'Edit Clients']);
        Permission::create(['name' => 'Delete Clients']);
        
        Permission::create(['name' => "Employee Administrative"]);
        Permission::create(['name' => "Employee Sales"]);
        
        $superrole = Role::create(['name' => 'Super-Admin']);

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo(Permission::all());
        $role->revokePermissionTo('Access Roles');

        Role::create(['name' => 'User']);
        Role::create(['name' => 'Provider']);
        Role::create(['name' => 'Client']);
        Role::create(['name' => 'Test']);

        $user = User::find(1);
        $superrole->givePermissionTo('Access Admin');
        $user->assignRole($superrole);
    }
}
