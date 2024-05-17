<?php
namespace App\Services;

use App\Models\Estate;
use Illuminate\Support\Facades\Storage;

class ImageService{

    public function save($images, $id){
        $estate = is_int($id) ? Estate::findById($id) : Estate::findByUuid($id);
        $eImages = $estate->images;
        foreach($images as $image){
            $iName = $image->getClientOriginalName();
            $path = $image->storeAs('images'.'/'.$estate->uuid, $iName, 'public');
            $eImages[] = $path;
        }
        $estate->images = $eImages;
        $estate->save();
    }

    public function delete($images, $uuid){
        $estate = Estate::findByUuid($uuid);
        $eImages = $estate->images;
        Storage::disk('public')->delete($images);
        $eImages = array_diff($eImages, $images);
        $estate->images = $eImages;
        $estate->save(); //smaz obrazky pri delte estatu 
    }
}