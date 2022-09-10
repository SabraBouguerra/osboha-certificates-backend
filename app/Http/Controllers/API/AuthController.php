<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as baseController;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{


    public function login(Request $request)
    {


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('random key')->accessToken;
            $success['name'] = $user->name;
            $success['role'] = $user->getRoleNames();
            $success['id'] = $user->id;
            return $this->sendResponse($success, 'User Login Successfully!' );
        }

       else{
            return $this->sendError('Unauthorised',['error','Unauthorised'] );
        }
    }


    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => 'required',
            "c_password" => 'required|same:password',

        ]);


        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        try{
            $user = User::create($input);
            $role =$role = Role::where('name', 'user')->first();
            $user->assignRole($role);
        }catch (\Illuminate\Database\QueryException $e){
         $errorCode = $e->errorInfo[1];
         if($errorCode == 1062){
             return $this->sendError('User already exist');
         }
     }
        $success['token'] = $user->createToken('random key')->accessToken;
        $success['name'] = $user->name;
        $success['role'] = $user->role;
        $success['id'] = $user->id;
        return $this->sendResponse($success,"test");
    }
}
