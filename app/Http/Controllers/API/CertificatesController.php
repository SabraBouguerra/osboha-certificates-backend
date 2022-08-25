<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Certificates;
use App\Models\Thesis;
use App\Models\UserBook;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class CertificatesController extends BaseController
{
    public function index()
    {

        $certificate = Certificates::all();
        return $this->sendResponse($certificate, "Certificate");
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_books_id' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        $all_avareges = UserBook::
        join('general_informations', 'user_books.id', '=', 'general_informations.user_books_id')
        ->join('questions', 'user_books.id', '=', 'questions.user_books_id')
        ->join('thesis', 'user_books.id', '=', 'thesis.user_books_id')
        ->select(\DB::raw('avg(general_informations.degree) as general_informations_degree,avg(questions.degree) as questions_degree,avg(thesis.degree) as thesises_degree'))
        ->where('user_books.id', $input['user_books_id'])
        ->get();
        $thesisDegree = $all_avareges[0]['thesises_degree'];
        $generalInformationsDegree = $all_avareges[0]['general_informations_degree'];
        $questionsDegree = $all_avareges[0]['questions_degree'];
        $finalDegree = ($questionsDegree+$generalInformationsDegree+$thesisDegree) /3 ;
        $certificate = new Certificates();
        $certificate->user_books_id = $input['user_books_id'];
        $certificate->thesis_grade = $questionsDegree;
        $certificate->check_reading_grade = $questionsDegree;
        $certificate->general_summary_grade = $generalInformationsDegree;
        $certificate->final_grade = $finalDegree;
        try {
            $certificate->save();
        } catch (\Illuminate\Database\QueryException $e) {
            echo($e);
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
        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $certificate = Certificates::find($id);

        $updateParam = [];
        try {
            $certificate->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('Certificate does not exist');
        }
        return $this->sendResponse($certificate, 'Certificate updated Successfully!');
    }

    public function destroy($id)
    {

        $result = Certificates::destroy($id);

        if ($result == 0) {

            return $this->sendError('Certificate does not exist');
        }
        return $this->sendResponse($result, 'Certificate deleted Successfully!');
    }
}
