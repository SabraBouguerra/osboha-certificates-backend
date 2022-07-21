<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Book;
use App\Repositories\book\interfaces\BooksRepositoryInterface;

class BooksController extends BaseController
{

    private BooksRepositoryInterface $bookService;
    function __construct(BooksRepositoryInterface $bookService) {
        $this->bookService = $bookService;
      }

    public function index(){

        $books =$this->bookService->getAllBooks();
        return $this->sendResponse($books,"Tasks");
     }


     public function store(Request $request){
         $input = $request->all();
         $validator = Validator::make($input,[
             'pages'=>'required',
             'book_name'=>'required'
         ]);
         if ($validator->fails()) {
             return $this->sendError('Validate Error',$validator->errors() );
         }

         $book = $this->bookService->saveBook($input);
         return $this->sendResponse($book, 'task added Successfully!' );
     }

     public function show($id){


         return $this->bookService->findBookById($id);
     }


     public function update(Request $request, Book $book){
         $input = $request->all();
         $validator = Validator::make($input,[
            'pages'=>'required',
            'book_name'=>'required'
        ]);
         if ($validator->fails()) {
             return $this->sendError('Validation error' , $validator->errors());
         }

         return $this->bookService->update($input,$book);



     }

     public function destroy(Book $book, Request $request){



         $deleted = $this->bookService->deleteBook($book);
         return $this->sendResponse($book, 'Task deleted Successfully!' );

     }


}
