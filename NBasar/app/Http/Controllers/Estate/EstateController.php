<?php

namespace App\Http\Controllers\Estate;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstateRequest;
use App\Services\EstateService;

class EstateController extends Controller
{
    public function __construct(private EstateService $estateService){
    }

    public function getEstate($uuid) {
        $estate = $this->estateService->get($uuid);
        return $this->response($estate, 200);
    }

    public function deleteEstate($uuid, EstateRequest $request) {
        if(str_contains($request->url(), 'admin'))
        $this->estateService->delete($uuid, true);
        else $this->estateService->delete($uuid);
        return $this->respondSuccess('Smazáno', 200);
    }

    public function patchEstate($uuid,EstateRequest $request) {
        $req = (object) $request->validated();
        $this->estateService->patch($uuid, $req);
        return $this->respondSuccess('Aktualizováno', 201);
    }

    public function createEstate(EstateRequest $request) {
        $req = (object) $request->all();
        $id = $this->estateService->create((object)$req);
        return $this->response( $id, 201);
    }
}
