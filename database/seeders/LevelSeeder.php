<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('level')->insert([
            'name' => 'simple'
        ]);
        DB::table('level')->insert([
            'name' => 'medium'
        ]);
        DB::table('level')->insert([
            'name' => 'difficult'
        ]);
    }
}
