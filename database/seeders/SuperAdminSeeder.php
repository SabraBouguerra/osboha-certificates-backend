<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
       $role =  Role:: findByName('admin', 'api');
        echo($role);
        $user = User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => $password,

        ]);
        $user->assignRole($role);

    }
}
