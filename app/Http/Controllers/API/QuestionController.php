<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Question;
use App\Models\Quotation;
use Illuminate\Support\Facades\Validator;



class QuestionController extends BaseController
 {
    public function index()
    {

        $question = Question::all();
        return $this->sendResponse($question, "Questions");
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'quotes' => 'required|array',
            'quotes.*.text' => 'required',
            'user_book_id' => 'required',
            "starting_page"=> 'required',
            "ending_page"=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $quotationInput = $input['quotes'];
        $qoutes =[];

        foreach ($quotationInput as $value) {

            $qoute = Quotation::create( $value);
            array_push($qoutes,$qoute);
          }



        try {
            $question = Question::create($input);
            $question->quotation()->saveMany($qoutes);
        } catch (\Illuminate\Database\QueryException $e) {
            echo($e);
            return $this->sendError('User Book does not exist.');
        }

        return $this->sendResponse($question, "Question created");
    }


    public function show($id)
    {
        $question = Question::find($id);

        if (is_null($question)) {

            return $this->sendError('Question does not exist');
        }
        return $this->sendResponse($question, "Question");
    }


    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'pages' => 'required',
            'quotation' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $question = Question::find($id);

        $updateParam = [
            "question" => $input['question'],
            "starting_page"=> 'required',
            "ending_page"=> 'required',
        ];
        try {
            $question->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('User Book does not exist');
        }
        return $this->sendResponse($question, 'Question updated Successfully!');
    }

    public function destroy($id)
    {

        $result = Question::destroy($id);

        if ($result == 0) {

            return $this->sendError('Question does not exist');
        }
        return $this->sendResponse($result, 'Question deleted Successfully');
    }



    public function addDegree(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'reviews' => 'required',
            'degree' => 'required',
            'reviewer_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $general_informations = Question::find($id);

        $updateParam = [
            "reviews" => $input['reviews'],
            "degree" => $input['degree'],
            "reviewer_id" => $input['reviewer_id'],
        ];
        try {
            $general_informations->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('General Informations does not exist');
        }
        return $this->sendResponse($general_informations, 'Degree added Successfully!');
    }




    public function finalDegree($user_book_id){
        $degrees = Question::where("user_book_id",$user_book_id)->avg('degree');
        return $this->sendResponse($degrees, 'Final Degree!');
    }
    public function getByStatus($status){
        $questions =  Question::where('status',$status)->get();
        return $this->sendResponse($questions, 'Questions');
    }


    public function getUserBookQuestions($id){
        $questions = Question::where('user_book_id',$id)->get();
        return $this->sendResponse($questions,'Questions');

    }

}


