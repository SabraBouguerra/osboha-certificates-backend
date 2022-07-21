<?php

namespace App\Repositories\book;

use App\Repositories\book\interfaces\BooksRepositoryInterface;


class BooksService implements BooksRepositoryInterface {

    function __construct(BooksRepositoryInterface $booksRepo) {
        $this->bookService = $booksRepo;
      }

   public function getAllBooks(){
        return $this->booksRepo->getAllBooks();
   }
}
