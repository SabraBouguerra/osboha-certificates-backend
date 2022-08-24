<?php

namespace App\Http\Controllers\API;

use App\Models\BookType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookTypeController extends BaseController
{
    public function index()
    {

        $Type = BookType::all();
        return $this->sendResponse($Type, "Type");
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();

        try {
            $type = BookType::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendError('Type does not exist');
        }

        return $this->sendResponse($type, "Type created");
    }


    public function show($id)
    {
        $type = BookType::find($id);

        if (is_null($type)) {

            return $this->sendError('Type does not exist');
        }
        return $this->sendResponse($type, "Type");
    }


    public function update(Request $request,  $id)
    {

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }



        $type = BookType::find($id);

        $updateParam = [
            "name" => $input['name'],

        ];

            $type->update($updateParam);

        return $this->sendResponse($type, 'Type updated Successfully!');
    }

    public function destroy($id)
    {

        $type = BookType::destroy($id);

        if ($type == 0) {

            return $this->sendError('Type does not exist');
        }
        return $this->sendResponse($type, 'Type deleted Successfully');
    }

}
