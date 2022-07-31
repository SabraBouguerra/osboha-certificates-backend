<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('admin');
        $user = User::create([
            "name" => "super_admin",
            "email" => "super_admin@gmail.com",
            "password" => $password,

        ]);
        $user->assignRole('super_admin');
    }
}
