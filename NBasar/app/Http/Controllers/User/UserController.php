<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\EstateService;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService, private EstateService $estateService){
    }

    public function getUser() {
        return $this->response($this->userService->getUser(), 200);
    }

    public function deleteUser($id) {
        $this->userService->delete($id);
        return $this->respondSuccess('Smazáno', 200);
    }

    public function patchUser(UserRequest $request) {
        $req = (object) $request->validated();
        $this->userService->patchUser($req);
        return $this->respondSuccess('Aktualizováno', 201);
    }

    public function createUser(UserRequest $request) {
        $req = (object) $request->validated();
        $token = $this->userService->create($req);
        return $this->response($token, 201);
    }

    public function all(UserRequest $request){
        return $this->respondWithPages(
            $this->userService->getUsers($request)
        );
    }

    public function login(UserRequest $request){
        $req = (object) $request->validated();
        $user = $this->userService->login($req);
        return $this->response($user);
    }

    public function getFavorites($id, UserRequest $request){
        return $this->respondWithPages(
            $this->estateService->getFavorites($id,$request)
        );
    }

    public function getOwned($id, UserRequest $request){
        return $this->respondWithPages(
            $this->estateService->getPaginated('user_id',[$id],$request)
        );
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
