<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Book;

class BooksController extends BaseController
{

    public function index()
    {
        $books = Book::all();
        return $this->sendResponse($books, "Books");
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'pages' => 'required',
            'book_name' => 'required',
            'type_id' => 'required',
            "category_id" => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validate Error', $validator->errors());
        }

        try{
            $book = Book::create($input);
          }catch (\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return $this->sendError('Book already exist');
            }else{
                return $this->sendError('Type or Category does not exist');
            }
        }

        return $this->sendResponse($book, 'Book added Successfully!');
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return $this->sendError('Book does not exist');
        }
        return $this->sendResponse($book, "Book");
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'pages' => 'required',
            'book_name' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }

        $book = Book::find($id);

        $updateParam = [
            "pages" => $input['pages'],
            "book_name" => $input['book_name'],
        ];
        try {
            $book->update($updateParam)->where;
        } catch (\Error $e) {
            return $this->sendError('Book does not exist');
        }
        return $this->sendResponse($book, 'Book updated Successfully!');
    }

    public function destroy($id)
    {
        $result = Book::destroy($id);

        if ($result == 0) {

            return $this->sendError('Book does not exist');
        }
        return $this->sendResponse($result, 'Book deleted Successfully!');
    }
}
