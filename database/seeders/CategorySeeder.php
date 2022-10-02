<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = 1;
        while ($cat <= 10) {
            DB::table('category')->insert([
                'name' => 'cat' . $cat,
            ]);
        $cat++;    
        }
        
    }
}
