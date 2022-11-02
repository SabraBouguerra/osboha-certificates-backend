<?php


namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Traits\MediaTraits;
use Illuminate\Auth\Events\Registered;

class UserController extends BaseController
{

    use MediaTraits;
    public function index(){

       $users = User::all();
       return $this->sendResponse($users,"Users");
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => 'required',
            'role' => 'required',
            "image" => "required|image|mimes:png,jpg,jpeg,gif,svg|max:2048",
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $role = $this->GetRole($input['role']);
        $input['password'] = Hash::make($request->password);
      try{

        $user = User::create($input);
        $user->assignRole($role);
        $this->createUserPhoto($request->file('image'), $user);
        event(new Registered($user));
      }catch (\Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
        if($errorCode == 1062){
            return $this->sendError('User already exist');
        }
    }
        return $this->sendResponse($user,"User created");
    }


    private function GetRole($role){
        $role = Role::where('name', $role)->first();
        if (is_null($role)) {

            return $this->sendError('Role does not exist' );
        }

        return $role;
    }

    public function show($id){
        $user = User::find($id);
        if (is_null($user)) {

            return $this->sendError('User does not exist' );
        }
        return $this->sendResponse($user,"User");
    }


    public function update(Request $request,  $id){
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


        $user = User::find($id);
        $input['password'] = Hash::make($request->password);
        $updateParam = [
            "name" => $input['name'],
            "email" => $input['email'],
            "password" => $input['password'],
            "role" => $input['role'],
        ];
      try{
        $user->update($updateParam);
      }catch(\Error $e){
        return $this->sendError('User does not exist');
      }
        return $this->sendResponse($user, 'User updated Successfully!' );

    }

    public function destroy($id){
      $user=User::find($id);
      $user->notify(new \App\Notifications\RejectUserEmail())->delay(now()->addMinutes(2));
        $result = User::destroy($id);

        if ($result == 0) {

            return $this->sendError('User does not exist' );
        }
        return $this->sendResponse($result, 'User deleted Successfully!' );

    }





    public function listUnactiveUser(){
      try{
        $users = User::with('roles')->where('is_active',0)->whereHas(
            'roles', function($q){
            $q->where('name', 'user');
        })->get();
        return $this->sendResponse($users, 'All Un Accepted Users!');
      }catch(\Error $e){
        return $this->sendError('All Users Have Been Accepted');
      }

    }

    public function listUnactiveReviwers(){
      try{
        $users = User::with('roles')->where('is_active',0)->whereHas(
            'roles', function($q){
            $q->where('name', 'reviewer')->orWhere('name','auditor');
        })->get();

        return $this->sendResponse($users, 'All Un Accepted Reviewers And Auditors!');
      }catch(\Error $e){
        return $this->sendError('All Reviewers And Auditors Have Been Accepted');
      }

    }

    public function activeUser(Request $request,$id){
        $user = User::find($id);
        if(!is_null($user->picture)){
        $this->deleteUserPicture($user->picture);
        }
      try{
        $user->update(['is_active' => true,'picture' => null]);
      }catch(\Error $e){
        return $this->sendError('User does not exist');
      }

        return $this->sendResponse($user, 'user activated!');
    }

    public function image(Request $request)
    {
        $path = $request->query('path', 'not found');
        if ($path === 'not found') {
            return $this->sendError('Path nout found');
        }
        $image = Storage::get($path);
        echo($image);
        $exp = "/[.][a-z][a-z][a-z]/";
        if (is_null($image)) {
            return $this->sendError('Image not found');
        }

        preg_match($exp, $path, $matches);
        $extention = ltrim($matches[0], '.');

        return response($image, 200)->header('Content-Type', "image/$extention");
    }


    public function registerAdmin(Request $request){

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => 'required',
            'role' => 'required',
            'fb_name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $role  = Role::where('name', $input['role'])->first();
        $input['password'] = Hash::make($request->password);

      try{

        $user = User::create($input);
        $user->assignRole($role);
        event(new Registered($user));

      }catch (\Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
        if($errorCode == 1062){
            return $this->sendError('User already exist');
        }
    }
    $success['token'] = $user->createToken('random key')->accessToken;
    $success['name'] = $user->name;
    $success['role'] = $user->getRoleNames();;
    $success['id'] = $user->id;
        return $this->sendResponse($success,"User created");
    }

}
