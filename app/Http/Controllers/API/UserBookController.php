<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\UserBook;
use Illuminate\Support\Facades\Validator;



class UserBookController extends BaseController
{
    public function index(){

        $userbook = UserBook::all();
        return $this->sendResponse($userbook,"User Books");

    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        try{
            $userBook = UserBook::create($input);
        }catch(\Illuminate\Database\QueryException $e){
            return $this->sendError('User or book does not exist');
        }



        return $this->sendResponse($userBook,"User book created");

    }


    public function show($id){
        $userBook = UserBook::find($id);
        if (is_null($userBook)) {
            return $this->sendError('UserBook not found!' );
        }
        return $userBook;
    }


    public function update(Request $request,$id){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'book_id',
            'user_id'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error' , $validator->errors());
        }


        $userBook = UserBook::find($id);

        $updateParam = [
            "book_id" => $input['book_id'],
            "user_id" => $input['user_id'],
        ];
      try{
        $userBook->update($updateParam);
      }catch(\Error $e){
        return $this->sendError('Thesis not found');
      }
        return $this->sendResponse($userBook, 'Thesis updated Successfully!' );




    }

    public function destroy($id){

        $result = UserBook::destroy($id);

        if ($result == 0) {

            return $this->sendError('UserBook not found!');
        }
        return $this->sendResponse($result, 'UserBook deleted Successfully!' );



    }


}
