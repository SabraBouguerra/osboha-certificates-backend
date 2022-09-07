<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GeneralInformations;
use Illuminate\Support\Facades\Validator;


class GeneralInformationsController extends BaseController
{
    public function index()
    {

        $general_informations = GeneralInformations::all();
        return $this->sendResponse($general_informations, "General Informations");
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'general_question' => 'required',
            'summary' => 'required',
            'user_book_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        try {
            $general_informations = GeneralInformations::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendError('User Book does not exist');
        }

        return $this->sendResponse($general_informations, "General Informations created");
    }


    public function show($id)
    {
        $general_informations = GeneralInformations::find($id);

        if (is_null($general_informations)) {

            return $this->sendError('General Informations does not exist');
        }
        return $this->sendResponse($general_informations, "General Informations");
    }


    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'general_question' => 'required',
            'summary' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $general_informations = GeneralInformations::find($id);

        $updateParam = [
            "general_question" => $input['general_question'],
            "summary" => $input['summary'],
        ];
        try {
            $general_informations->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('General Informations does not exist');
        }
        return $this->sendResponse($general_informations, 'General Informations updated Successfully!');
    }

    public function destroy($id)
    {

        $result = GeneralInformations::destroy($id);

        if ($result == 0) {

            return $this->sendError('General Informations does not exist');
        }
        return $this->sendResponse($result, 'General Informations deleted Successfully!');
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


        $general_informations = GeneralInformations::find($id);

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

        $degrees = GeneralInformations::where("user_book_id",$user_book_id)->avg('degree');
        return $this->sendResponse($degrees, 'Final Degree!');
    }

    public Function getByUserBookId($user_book_id){

        $general_informations = GeneralInformations::get();
        return $this->sendResponse($general_informations, 'General Informations!');
    }
}
