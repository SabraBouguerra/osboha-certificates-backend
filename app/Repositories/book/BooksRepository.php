<?php

namespace App\Repositories\book;


use App\Models\Book;
use App\Repositories\book\interfaces\BooksRepositoryInterface;

class BooksRepository implements BooksRepositoryInterface {
   function getAllBooks(){
    $books = Book::all();
        return $books;
   }
}
