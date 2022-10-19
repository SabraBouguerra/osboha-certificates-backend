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

        $count = UserBook::whereNull('status')->orWhere('status','!=','finished')->where('user_id',Auth::id())->count();

        if($count > 0 ){
            return $this->sendError('You have an open book');
        }
        try {
            $userBook=UserBook::firstOrCreate([
                'book_id' => $request->book_id,
                'user_id'=>Auth::id()
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            echo ($e);
            return $this->sendError('User or book does not exist');
        }
        return $this->sendResponse($userBook, "User book created");
    }

    
    public function getByBookID($bookId)
    {
        $userBook = UserBook::with('thesises','questions','generalInformation')->where('book_id',$bookId)->where('user_id', Auth::id())->first();
        return $userBook;
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
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
        try {
            $userBook = UserBook::where('id',$id)->update(['status'=>$request->status]);
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
    public function review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        try {
            //REJECT OR RETARD ENTIER USER BOOK
            $userBook=UserBook::find($request->id);
            $user=User::find($userBook->user_id);
            $userBook->status=$request->status;
            $userBook->reviews=$request->reviews;
            $theses=Thesis::where('user_book_id',$request->id)->update(['status'=>$request->status ,'reviews'=>$request->reviews ]);
            $questions=Question::where('user_book_id',$request->id)->update(['status'=>$request->status ,'reviews'=>$request->reviews ]);
            $generalInformations=GeneralInformations::where('user_book_id',$request->id)->update(['status'=>$request->status ,'reviews'=>$request->reviews ]);
            $user->notify(new \App\Notifications\RejectAchievement());


        } catch (\Error $e) {
            return $this->sendError('User Book does not exist');
        }
    }


    public function checkOpenBook()
    {
        $id = Auth::id();

        $open_book = UserBook::where('user_id',$id)->where('status','!=','finished')->count();


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
