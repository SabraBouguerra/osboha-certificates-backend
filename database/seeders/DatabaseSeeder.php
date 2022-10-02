<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RolesSeeder::class,
            CategorySeeder::class,
            TypeSeeder::class,
            BookSeeder::class,
            FqasSeeder::class,
            UsersTableSeeder::class,
            User_BookSeeder::class,
            ThesisSeeder::class


        ]);
    }
}
