<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService){
    }

    public function get(UserRequest $request) {
        $req = (object) $request->validated();
        $user = $this->userService->getUser($req);
        return $this->response($user);
    }

    public function delete($id) {
        $this->userService->deleteUser($id);
        return $this->respondSuccess('Smazáno', 200);
    }

    public function patch($id,UserRequest $request) {
        $req = (object) $request->validated();
        $this->userService->patchUser($id, $req);
        return $this->respondSuccess('Aktualizováno', 201);
    }

    public function create(UserRequest $request) {
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
