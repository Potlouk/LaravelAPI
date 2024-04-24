<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function __construct(private ImageService $imageService){
    }

    public function saveImages(ImageRequest $request){
      //  $req = (object) $request->validated();
        if ($request->hasFile('images'))
        $this->imageService->save($request->file('images'), $request->input('uuid'));
        return $this->respondSuccess('Uloženo', 201);
    }

    public function deleteImages($uuid,ImageRequest $request){
        $this->imageService->delete(explode(',', $request->query('images')), $uuid);
        return $this->respondSuccess('Smazáno', 200);
    }
}
