<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Thesis;
use Illuminate\Support\Facades\Validator;



class ThesisController extends BaseController
{
    public function index(){

        $thesis = Thesis::all();
        return $this->sendResponse($thesis,"Thesises");

    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
           "thesis_text" => "required",
           "pages" => 'required',
           "user_books_id" => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        try{
            $thesis = Thesis::create($input);
        }catch(\Illuminate\Database\QueryException $e){
            return $this->sendError('UserBook does not exist');
        }

        return $this->sendResponse($thesis,"Thesis created");

    }


    public function show($id){
        $thesis = Thesis::find($id);

        if (is_null($thesis)) {

            return $this->sendError('thesis not found!' );
        }
        return $this->sendResponse($thesis,"Thesis");
    }


    public function update(Request $request,  $id){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            "thesis_text" => "required",
            "pages" => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error' , $validator->errors());
        }


        $thesis = Thesis::find($id);

        $updateParam = [
            "thesis_text" => $input['thesis_text'],
            "pages" => $input['pages'],
        ];
      try{
        $thesis->update($updateParam);
      }catch(\Error $e){
        return $this->sendError('Thesis not found');
      }
        return $this->sendResponse($thesis, 'Thesis updated Successfully!' );





    }

    public function destroy($id){

        $result = Thesis::destroy($id);

        if ($result == 0) {

            return $this->sendError('thesis not found!' );
        }
        return $this->sendResponse($result, 'Thesis deleted Successfully!' );



    }


}
