<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends BaseController
{
    public function index()
    {

        $category = BookCategory::all();
        return $this->sendResponse($category, "Category");
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
            $category = BookCategory::create($input);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->sendError('Category does not exist');
        }

        return $this->sendResponse($category, "Category created");
    }


    public function show($id)
    {
        $category = BookCategory::find($id);

        if (is_null($category)) {

            return $this->sendError('Category does not exist');
        }
        return $this->sendResponse($category, "Category");
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


        $category = BookCategory::find($id);

        $updateParam = [
            "name" => $input['name'],

        ];

            $category->update($updateParam);

        return $this->sendResponse($category, 'Category updated Successfully!');
    }

    public function destroy($id)
    {

        $category = BookCategory::destroy($id);

        if ($category == 0) {

            return $this->sendError('Category does not exist');
        }
        return $this->sendResponse($category, 'Category deleted Successfully');
    }



}
