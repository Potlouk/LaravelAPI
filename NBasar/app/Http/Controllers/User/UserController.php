<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\EstateService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private UserService $userService, private EstateService $estateService){
    }

    public function getUser() {
        return $this->response(Auth::guard('sanctum')->user(), 200);
    }

    public function delete($id) {
        $this->userService->deleteUser($id);
        return $this->respondSuccess('Smazáno', 200);
    }

    public function patchUser(UserRequest $request) {
        $req = (object) $request->validated();
        $this->userService->patchUser($req);
        return $this->respondSuccess('Aktualizováno', 201);
    }

    public function createUser(UserRequest $request) {
        $req = (object) $request->validated();
        $token = $this->userService->createUser($req);
        return $this->response($token, 201);
    }

    public function all($limit){
        return $this->respondWithPages($this->userService->getUsers($limit));
    }

    public function login(UserRequest $request){
        $req = (object) $request->validated();
        $user = $this->userService->login($req);
        return $this->response($user);
    }


    public function getFavorites($id){
        return $this->response($this->estateService->getFavorites($id));
    }
    public function getOwned($id){
        return $this->response($this->estateService->getOwned($id));
    }

    public function contactSeller(UserRequest $request){
       $req = (object) $request->validated();
       $contacted = $this->userService->contactSeller($req);
       if ($contacted) return $this->respondSuccess('Prodejce kontaktován', 200);
       else return $this->respondSuccess('Prodejce byl již kontaktován', 200);
    }

    public function addToFavorite(UserRequest $request){
        $req = (object) $request->validated();
        $wState = $this->userService->addToFavorites($req);
        if ($wState) return $this->respondSuccess('Sleduji', 200);
        else return $this->respondSuccess('Nesleduji', 200);
    }

    public function reportEstate(UserRequest $request){
        $req = (object) $request->validated();
        $this->userService->reportEstate($req);
        return $this->respondSuccess('Nahlášeno', 200);
    }
}
