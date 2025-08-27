<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = new Role;
        $superadmin->name = 'Superadmin';
        $superadmin->save();

        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();

        $customer = new Role;
        $customer->name = 'Customer';
        $customer->save();

        // Mendapatkan seluruh permissions
        $permissions = Permission::all();

        foreach ($permissions as $value) {
            $superadmin->givePermissionTo($value->name);
            $admin->givePermissionTo($value->name);
        }
        $customer->givePermissionTo('Dashboard Index');
    }
}
