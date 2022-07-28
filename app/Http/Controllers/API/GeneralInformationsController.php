<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\GeneralInformations;
use Illuminate\Support\Facades\Validator;



class GeneralInfromationsController extends BaseController
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
            'user_books_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        try {
            $general_informations = GeneralInformations::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendError('general_informations does not exist');
        }

        return $this->sendResponse($general_informations, "General Informations created");
    }


    public function show($id)
    {
        $general_informations = GeneralInformations::find($id);

        if (is_null($general_informations)) {

            return $this->sendError('General Informations not found!');
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
            return $this->sendError('General Informations not found');
        }
        return $this->sendResponse($general_informations, 'General Informations updated Successfully!');
    }

    public function destroy($id)
    {

        $result = GeneralInformations::destroy($id);

        if ($result == 0) {

            return $this->sendError('General Informations not found!');
        }
        return $this->sendResponse($result, 'General Informations deleted Successfully!');
    }
}
