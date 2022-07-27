<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserContoller extends BaseController
{
    public function index(){

       $users = User::all();
       return $this->sendResponse($users,"Users");
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => 'required',
            "role" => "required"
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);


        return $this->sendResponse($user,"User created");
    }


    public function show($id){
        $user = User::find($id);
        return $user;
    }


    public function update(Request $request, User $user){
        $input = $request->all();
        $validator = Validator::make($input,[
            "name" => "required",
            "email" => "required|email",
            "password" => 'required',
            "role" => "required"
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error' , $validator->errors());
        }


        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->role = $input['role'];
        $user->save();
    }

    public function destroy(User $user, Request $request){

        $user->delete();
        return $this->sendResponse($user, 'User deleted Successfully!' );

    }


}
