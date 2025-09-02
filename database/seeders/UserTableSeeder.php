<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin =  User::query()->updateOrCreate(
            [
                'email' => 'superadmin@gmail.com'
            ],
            [
                'email' => 'superadmin@gmail.com',
                'name' => 'Superadmin',
                'password' => Hash::make('superadmin'),
                'username' => 'superadmin',
            ]
        );

        $admin =  User::query()->updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'email' => 'admin@gmail.com',
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
                'username' => 'admin',
            ]
        );

        $customer =  User::query()->updateOrCreate(
            [
                'email' => 'customer@gmail.com'
            ],
            [
                'email' => 'customer@gmail.com',
                'name' => 'Customer',
                'password' => Hash::make('customer'),
                'username' => 'customer',
            ]
        );

        $superadmin->assignRole('Superadmin');
        $admin->assignRole('Admin');
        $customer->assignRole('Customer');
    }
}
