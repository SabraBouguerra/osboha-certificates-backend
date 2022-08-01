<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Certificates;
use Illuminate\Support\Facades\Validator;



class GeneralInfromationsController extends BaseController
{
    public function index()
    {

        $certificate = Certificates::all();
        return $this->sendResponse($certificate, "Certificate");
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
            $certificate = Certificates::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendError('User Book does not exist');
        }

        return $this->sendResponse($certificate, "Certificate created");
    }


    public function show($id)
    {
        $certificate = Certificates::find($id);

        if (is_null($certificate)) {

            return $this->sendError('Certificate does not exist');
        }
        return $this->sendResponse($certificate, "Certificates");
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


        $certificate = Certificates::find($id);

        $updateParam = [
            "general_question" => $input['general_question'],
            "summary" => $input['summary'],
        ];
        try {
            $certificate->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('Certificate not found');
        }
        return $this->sendResponse($certificate, 'Certificate updated Successfully!');
    }

    public function destroy($id)
    {

        $result = Certificates::destroy($id);

        if ($result == 0) {

            return $this->sendError('Certificate not found!');
        }
        return $this->sendResponse($result, 'Certificate deleted Successfully!');
    }
}
