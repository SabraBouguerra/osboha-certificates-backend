<?php
namespace App\Traits;
use App\Models\Photos;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

Trait MediaTraits{

    function createMedia($media, $id){
        $imageName = time().'.'. $media->extension();
        $media->move(public_path('assets/images'), $imageName);
        // link media with comment
        $media = new Photos();
        $media->path = $imageName;
        $media->thesis_id = $id;
        $media->save();
        return $media;
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
        File::delete(public_path('assets/images/'.$currentMedia->media));
        $currentMedia->delete();
    }


}
