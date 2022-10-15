<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
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
            DB::table('section')->insert([
                'name' => 'cat' . $cat,
            ]);
        $cat++;
        }

    }
}
