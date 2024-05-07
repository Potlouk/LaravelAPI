<?php

namespace App\Http\Controllers\Image;

use App\Http\Requests\ImageRequest;
use App\Services\ImageService;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function __construct(private ImageService $imageService){
    }

    public function saveImages(ImageRequest $request){
        if ($request->hasFile('images'))
        $this->imageService->save($request->file('images'), $request->input('uuid'));
        return $this->respondSuccess('Uloženo', 201);
    }

    public function deleteImages($uuid,ImageRequest $request){
        $this->imageService->delete(explode(',', $request->query('images')), $uuid);
        return $this->respondSuccess('Smazáno', 200);
    }
}
