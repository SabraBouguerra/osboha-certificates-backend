<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Thesis;
use Illuminate\Support\Facades\Validator;
use App\Traits\MediaTraits;



class ThesisController extends BaseController
{

    use MediaTraits;

    public function index(){

        $thesis = Thesis::all();
        return $this->sendResponse($thesis,"Thesises");

    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
           "thesis_text" => "required",
           "ending_page" => 'required',
           "starting_page" => 'required',
           "user_book_id" => 'required',
        //    "image" => "required|image|mimes:png,jpg,jpeg,gif,svg|max:2048",
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        try{
            $thesis = Thesis::create($input);
            // $this->createThesisMedia($request->file('image'), $thesis);
        }catch(\Illuminate\Database\QueryException $e){
            return $this->sendResponse($e,'User Book does not exist');
        }

        return $this->sendResponse($thesis,"Thesis created");

    }


    public function show($id){
        $thesis = Thesis::find($id);

        if (is_null($thesis)) {

            return $this->sendError('Thesis does not exist' );
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
        return $this->sendError('Thesis does not exist');
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


        $general_informations = Thesis::find($id);

        $updateParam = [
            "reviews" => $input['reviews'],
            "degree" => $input['degree'],
            "reviewer_id" => $input['reviewer_id'],
        ];
        try {
            $general_informations->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('Thesis does not exist');
        }
        return $this->sendResponse($general_informations, 'Degree added Successfully!');
    }




    public function finalDegree($user_book_id){
        $degrees = Thesis::where("user_book_id",$user_book_id)->avg('degree');
        return $this->sendResponse($degrees, 'Final Degree!');
    }

    public function uploadPhoto(Request $request,$id){
        $validator = Validator::make($request->all(), [
            "images"    => "required|array|min:1|max:2",
            "images.*"  => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
         ]);

         if ($validator->fails()) {
             return $this->sendError($validator->errors());
         }
         $thesis = Thesis::find($id);
         if (is_null($thesis)) {
            return $this->sendError('Thesis does not exist' );
        }
         foreach ($request->file('images') as $imagefile) {
            $this->createThesisMedia($imagefile, $thesis->id);
         }
         return $this->sendResponse($thesis, 'Photo uploaded Successfully!');
    }


    public function auditThesis($id){
        try{
            $thesis = Thesis::where('user_book_id',$id)->update(['status' => 'audit']);
          }catch(\Error $e){
            return $this->sendError('Thesis does not exist');
          }



    }



    public function getByStatus($status){
        $thesises =  Thesis::where('status',$status)->get();
        return $this->sendResponse($thesises, 'Thesises');
    }

}
