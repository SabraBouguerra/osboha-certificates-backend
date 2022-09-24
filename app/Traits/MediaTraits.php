<?php
namespace App\Traits;
use App\Models\Photos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
Trait MediaTraits{

    function createThesisMedia($media, $id){

        $path = Storage::putFile('image', $media);

        try{
            $media = Photos::create(['path' => $path,"thesis_id" => $id]);

        }catch(\Illuminate\Database\QueryException $e){
          echo($e);
        }


        return $media;
    }

    function createUserPhoto($media, $user){


        $path = Storage::putFile('image', $media);
        $user->picture = $path;
        $user->save();
        return $user;

    }

    function updateMedia($media, $media_id){
        //get current media
        $currentMedia= Photos::find($media_id);
        //delete current media
        File::delete(public_path('assets/images/'.$currentMedia->media));

        // upload new media
        $imageName = time().'.'. $media->extension();
        $media->move(public_path('assets/images'), $imageName);

        // update current media
        $currentMedia->media = $imageName;
        $currentMedia->save();
    }


    function deleteMedia($media_id){
        $currentMedia= Photos::find($media_id);
         //delete current media
        File::delete(public_path('assets/images/'.$currentMedia->path));
        $currentMedia->delete();
    }


    function deleteUserPicture($path){
        Storage::delete($path);
    }



}
