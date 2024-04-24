<?php

namespace App\Http\Controllers\Estate;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstateRequest;
use App\Services\EstateService;
use App\Services\ImageService;

class EstateController extends Controller
{
    public function __construct(private EstateService $estateService, private ImageService $imageService){
    }

    public function getEstate($uuid) {
        $estate = $this->estateService->get('uuid',[$uuid])[0];
        return $this->response($estate, 200);
    }
    
    public function getpatchEstate($uuid) {
        $estate = $this->estateService->getwithIDs($uuid);
        return $this->response($estate, 200);
    }

    public function deleteEstate($uuid, EstateRequest $request) {
        if(str_contains($request->url(), 'admin'))
        $this->estateService->delete($uuid, true);
        else $this->estateService->delete($uuid);
        return $this->respondSuccess('Smazáno', 200);
    }

    public function patchEstate($uuid,EstateRequest $request) {
        $req = (object) $request->all();
        $this->estateService->patch($uuid,(object)$req);
        return $this->respondSuccess('Aktualizováno', 201);
    }

    public function createEstate(EstateRequest $request) {
        $req = (object) $request->all();
        $id = $this->estateService->create((object)$req);
        return $this->response($id, 201);
    }
}
