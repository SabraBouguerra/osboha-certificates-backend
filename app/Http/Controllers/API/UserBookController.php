<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GeneralInformations;
use App\Models\Question;
use App\Models\Thesis;
use App\Models\UserBook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class UserBookController extends BaseController
{
    public function index()
    {

        $userbook = UserBook::all();
        return $this->sendResponse($userbook, "User Books");
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required'
        ]);



        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $input['status'] = 'open';
        $input['user_id'] = Auth::id();

        try {
            $userBook = UserBook::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            echo ($e);
            return $this->sendError('User or book does not exist');
        }
        return $this->sendResponse($userBook, "User book created");
    }


    public function show($id)
    {
        $userBook = UserBook::find($id);
        if (is_null($userBook)) {
            return $this->sendError('UserBook does not exist');
        }
        return $userBook;
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'book_id',
            'user_id'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $userBook = UserBook::find($id);

        $updateParam = [
            "book_id" => $input['book_id'],
            "user_id" => $input['user_id'],
        ];
        try {
            $userBook->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('UserBook does not exist');
        }
        return $this->sendResponse($userBook, 'UserBook updated Successfully!');
    }

    public function destroy($id)
    {

        $result = UserBook::destroy($id);

        if ($result == 0) {

            return $this->sendError('UserBook does not exist');
        }
        return $this->sendResponse($result, 'UserBook deleted Successfully!');
    }


    public function changeStatus(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $userBook = UserBook::find($id);

        $updateParam = [
            'status' => $input['status']
        ];
        try {
            $userBook->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('UserBook does not exist');
        }
        return $this->sendResponse($userBook, 'UserBook updated Successfully!');
    }

    public function checkOpenBook()
    {
        $id = Auth::id();
        $open_book = UserBook::where('user_id', $id)->where('status', 'open')->count();

        return $this->sendResponse($open_book, 'Open Book');
    }


    public function getStageStatus($id)
    {

        $thesis = Thesis::where('user_book_id', $id)->where('status', 'audit')->exists();
        $question = Question::where('user_book_id', $id)->where('status', 'audit')->exists();
        $status = $thesis + $question;


        return $this->sendResponse($status, 'Status');
    }

}
