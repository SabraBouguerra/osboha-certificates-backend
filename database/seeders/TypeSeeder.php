<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type')->insert([
            'name' => 'simple'
        ]);
        DB::table('type')->insert([
            'name' => 'medium'
        ]);
        DB::table('type')->insert([
            'name' => 'difficult'
        ]);
    }
}
