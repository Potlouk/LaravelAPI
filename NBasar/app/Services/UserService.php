<?php
namespace App\Services;

use App\Http\Resources\UserResource;
use App\Mail\EstateReported;
use App\Mail\UserCreate;
use App\Mail\UserDelete;
use App\Mail\UserPatched;
use App\Models\Admin;
use App\Models\Estate;
use App\Models\User;
use App\Services\ErrorCheckService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Class UserService{

    function __construct(private ErrorCheckService $errorCheck) {
    }

    public function getUser(){
        $user = User::findByIdWithRoles(Auth::guard('sanctum')->user()->id);
        return new UserResource($user);
    }

    public function getUsers($request){
        $this->errorCheck->checkPaginateRequest($request);
        $this->errorCheck->checkIfAdmin(User::findById(Auth::guard('sanctum')->user()->id));
        $users = User::paginate($request->input('limit'), ['*'], 'page', $request->input('page'));
        return [UserResource::collection($users), $users];
    }

    public function patchUser($data){
        $userOrigin = User::findById(Auth::guard('sanctum')->user()->id);
        $userId = $userOrigin->hasRole('Admin') ? $data->id : $userOrigin->id;
        $this->errorCheck->checkIfEmpty($userId, 'id');
        $user = User::findById($userId);

        if (isset($data->email))
        if ($data->email != $user->email && !$user->hasRole('Admin'))
            $this->errorCheck->checkIfAlreadyExisting(new User, $data->email,'email');

        $patchData = (object) Arr::only((array) $data, User::$patchable);
        
        foreach ($patchData as $key => $value)
            $user->$key = $value;

        if (isset($data->password))
            $user->password = bcrypt($data->password);

        $user->save();
        Mail::to($user->email)->send(new UserPatched($user));
    }

    public function delete($id){
        $user = User::findById($id);
        $user->tokens()->delete();
        $user->delete();
        Mail::to($user->email)->send(new UserDelete($user));
    }

    public function create($data){
        $this->errorCheck->checkIfAlreadyExisting(new User, $data->email,'email');

        $user = new User((array)$data);
        $user->password = bcrypt($data->password);

        $user->watched_estates = $user->reported_estates = [];
        $user->assignRole('User');
        $user->save();

        Mail::to($user->email)->send(new UserCreate($user));
        return $user->createToken("accessToken")->plainTextToken;
    }

    public function login($data){
        $this->errorCheck->checkIfEmpty($data->email, 'email');
        $this->errorCheck->checkIfExisting(new User, $data->email, 'email');
        $user = User::findByEmail($data->email);
        $this->errorCheck->checkIfMashMatching($data->password, $user->password, 'heslo');
        return $user->createToken("accessToken")->plainTextToken;
    }

    public function addToFavorites($data){
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        $temp = $user->watched_estates;
        
        if (!in_array($data->uuid, $user->watched_estates)){
            $temp[] = $data->uuid;
            $user->watched_estates = $temp;
            $user->save();
            return true;
        }
       
        $temp = array_diff($user->watched_estates, [$data->uuid]);
        $user->watched_estates =  $temp;
        $user->save();
        return false;
    }

    public function reportEstate($data){
        $estate = Estate::findByUuid($data->uuid);
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        $temp = $user->reported_estates;

        if (in_array($data->uuid, $user->reported_estates))
        return false;

        $estate->reported_count += 1;
        $estate->save();
        $temp[] = $data->uuid;
        $user->reported_estates = $temp;
        $user->save();
       // Mail::to(Admin::getAdmin()->email)->send(new EstateReported($data));
        
    }
}
?>