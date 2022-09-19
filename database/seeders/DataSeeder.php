<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookType;
use App\Models\UserBook;
use App\Models\Question;
use App\Models\GeneralInformations;
use App\Models\Thesis;
use App\Models\Quotation;
use App\Models\User;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookCategory::create(['name' => 'book category']);
        BookType::create(['name' => 'book category']);
        Book::create([
            'book_name'=>"هذا كتاب جميل",
            'pages' => 122,
            'type_id' => 1,
            'category_id' => 1,


        ]);Book::create([
            'book_name'=>"هذا كتاب ",
            'pages' => 122,
            'type_id' => 1,
            'category_id' => 1,


        ]);Book::create([
            'book_name'=>"هذا  ",
            'pages' => 122,
            'type_id' => 1,
            'category_id' => 1,


        ]);
        UserBook::create([
            'book_id' => 1,
            "user_id" => 1
        ]);
    }
}
