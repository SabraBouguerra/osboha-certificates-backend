<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Thesis;
use Illuminate\Support\Facades\Validator;
use App\Traits\MediaTraits;

use Illuminate\Support\Facades\Storage;



class ThesisController extends BaseController
{

    use MediaTraits;

    public function index()
    {

        $thesis = Thesis::all();
        return $this->sendResponse($thesis, "Thesises");
    }


    public function store(Request $request)
    {
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

        try {
            $newthesis = Thesis::create($input);
            $this->createThesisMedia($request->file('image'), $newthesis->id);
            // if ($request->has('image')) {
            //     foreach ($request->image as $image) {
            //         $this->createThesisMedia($image, $newthesis->id);
            //     }
            // }

        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendResponse($e, 'User Book does not exist');
        }
        $thesis=Thesis::find($newthesis->id);

        return $this->sendResponse($thesis, "Thesis created");
    }


    public function show($id)
    {
        $thesis = Thesis::find($id);

        if (is_null($thesis)) {

            return $this->sendError('Thesis does not exist');
        }
        return $this->sendResponse($thesis, "Thesis");
    }


    public function update(Request $request,  $id)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            "thesis_text" => "required",
            "pages" => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }


        $thesis = Thesis::find($id);

        $updateParam = [
            "thesis_text" => $input['thesis_text'],
            "pages" => $input['pages'],
        ];
        try {
            $thesis->update($updateParam);
        } catch (\Error $e) {
            return $this->sendError('Thesis does not exist');
        }
        return $this->sendResponse($thesis, 'Thesis updated Successfully!');
    }

    public function destroy($id)
    {

        $result = Thesis::destroy($id);

        if ($result == 0) {

            return $this->sendError('thesis not found!');
        }
        return $this->sendResponse($result, 'Thesis deleted Successfully!');
    }



    public function addDegree(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
            'reviews' => 'required',
            'degree' => 'required',
            'reviewer_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }
 
        $thesis = Thesis::find($id);
        $thesis->reviews = $request->reviews;
        $thesis->degree=$request->degree;
        $thesis->reviewer_id = $request->reviewer_id;
        $thesis->status='reviewed';
        
 
        try {
            $thesis->save();
        } catch (\Error $e) {
            return $this->sendError('Thesis does not exist');
        }
        return $this->sendResponse($thesis, 'Degree added Successfully!');
    }




    public function finalDegree($user_book_id)
    {
        $degrees = Thesis::where("user_book_id", $user_book_id)->avg('degree');
        return $this->sendResponse($degrees, 'Final Degree!');
    }

    public function uploadPhoto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "images"    => "required|array|min:1|max:2",
            "images.*"  => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $thesis = Thesis::find($id);
        if (is_null($thesis)) {
            return $this->sendError('Thesis does not exist');
        }
        foreach ($request->file('images') as $imagefile) {
            $this->createThesisMedia($imagefile, $thesis->id);
        }
        return $this->sendResponse($thesis, 'Photo uploaded Successfully!');
    }

    //ready to review
 
    public function auditThesis($id){
        try{
            $thesis = Thesis::where('user_book_id',$id)->update(['status' => 'audit']);
          }catch(\Error $e){
            return $this->sendError('Thesis does not exist');
          }
    }

    public function audit(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'status' => 'required',
            'auditor_id'=>'required',
            'reviews'=>'required_if:status,rejected'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        try{
            $thesis = Thesis::find($request->id);
            $thesis->status=$request->status;
            $thesis->auditor_id=$request->auditor_id;
            if ($request->has('reviews')) {
                $thesis->reviews=$request->reviews;
            }

            $thesis->save();



          }catch(\Error $e){
            return $this->sendError('Thesis does not exist');
          }

 

        }

    public function getByStatus($status){
        $thesises =  Thesis::with("user_book.user")->with("user_book.book")->where('status',$status)->groupBy('user_book_id')->get();
 
        return $this->sendResponse($thesises, 'Thesises');
    }
 
    public function getByUserBook($user_book_id){

        $thesises =  Thesis::with("user_book.user")->with("user_book.book")->with("photos")->where('user_book_id',$user_book_id)->get();
        return $this->sendResponse($thesises, 'Thesises');
    }


    public function image(Request $request)
    {
        $path = $request->query('path', 'not found');
        if ($path === 'not found') {
            return $this->sendError('Path nout found');
        }
        $image = Storage::get($path);
        $exp = "/[.][a-z][a-z][a-z]/";
        if (is_null($image)) {
            return $this->sendError('Image not found');
        }

        preg_match($exp, $path, $matches);
        $extention = ltrim($matches[0], '.');

        return response($image, 200)->header('Content-Type', "image/$extention");
    }
}
