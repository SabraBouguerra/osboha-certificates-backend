<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Book;
use App\Models\Certificates;
use App\Models\GeneralInformations;
use App\Models\Question;
use App\Models\Thesis;
use App\Models\User;
use App\Models\UserBook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
        $input['user_id'] = Auth::id();
        $count = pBook::where('status','!=','finished')->where('user_id',$input['user_id'])->count();

        if($count > 0 ){
            return $this->sendError('You have an open book');
        }
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

        $open_book = UserBook::where('user_id',$id)->where('status','stage_one')->orWhere('status','stage_two')->count();


        return $this->sendResponse($open_book, 'Open Book');
    }


    public function getStageStatus($id)
    {

        $thesis = Thesis::where('user_book_id', $id)->where('status', 'audit')->exists();
        $question = Question::where('user_book_id', $id)->where('status', 'audit')->exists();
        $status = $thesis + $question;


        return $this->sendResponse($status, 'Status');
    }


    public function checkCertificate($id){
        $status = Certificates::where('user_book_id',$id)->exists();
        return $this->sendResponse($status , 'Status' );
    }



    public function getStatistics($id){
        $thesisFinalDegree = Thesis::where("user_book_id",$id)->avg('degree');
        $questionFinalDegree = Question::where("user_book_id",$id)->avg('degree');
        $generalInformationsFinalDegree = GeneralInformations::where("user_book_id",$id)->avg('degree');
        $finalDegree = ($thesisFinalDegree + $questionFinalDegree + $generalInformationsFinalDegree) / 3;
        $response = [
            "thesises" => intval($thesisFinalDegree),
            "questions" => intval($questionFinalDegree),
            "general_informations" => intval($generalInformationsFinalDegree),
            "final" => intval($finalDegree),
        ];
        return $this->sendResponse($response , 'Statistics');

    }

    public function getGeneralstatistics(){
        $thesis = ThesisController::thesisStatistics();
        $questions = QuestionController::questionsStatistics();
        $generalInformations = GeneralInformationsController::generalInformationsStatistics();
        $certificates = Certificates::count();
        $users = User::count();
        $books = Book::count();
        $auditer = Role::where('name','auditer')->count();
        $reviewer = Role::where('name','reviewer')->count();



        $response = [
            "thesises" => $thesis,
            "questions" => $questions,
            "general_informations" => $generalInformations,
            "certificates" => $certificates,
            'users' => $users,
            "books" => $books,
            "auditers" => $auditer,
            "reviewer" => $reviewer,
        ];
        return $this->sendResponse($response , 'Statistics');

    }


}
