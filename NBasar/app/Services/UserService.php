<?php
namespace App\Services;

use App\Exceptions\ExceptionTypes;
use App\Mail\ContactSellerMail;
use App\Mail\Registration;
use App\Mail\Reported;
use App\Models\Admin;
use App\Models\Estate;
use App\Models\User;
use App\Services\ErrorCheckService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Class UserService{

    public function __construct(private ErrorCheckService $errorCheck) {
    }

    public function getUser(){
      
      return Auth::guard('sanctum')->user();
    }

    public function getUsers($limit){
        $users = User::paginate($limit);
        return $users;
    }

    public function patchUser($data){
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        $patchData = (object) Arr::only((array) $data,  User::$patchable);
        
        if(isset($data->email))
        if ($data->email != $user->email)
        $this->errorCheck->checkIfAlreadyExisting(new User, $data->email,'email');

        foreach ($patchData as $key => $value)
            $user->$key = $value;

        if (isset($data->password))
            $user->password = bcrypt($data->password);

        $user->save();
    }

    public function deleteUser($id){
        $user = User::findById($id);
        $user->delete();
    }

    public function createUser($data){
        $this->errorCheck->checkIfAlreadyExisting(new User, $data->email,'email');

        $user = new User((array)$data);
        $user->password = bcrypt($data->password);
       // Mail::to($user->email)->send(new Registration($user));
        $user->assignRole('User');
        $user->save();
        return $user->createToken("accessToken")->plainTextToken;
    }

    public function login($data){
        $user = User::findByEmail($data->email);
        $this->errorCheck->checkIfMashMatching($data->password, $user->password, 'heslo');
        return $user->createToken("accessToken")->plainTextToken;
    }

    public function contactSeller($data){
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        if(in_array($data->seller_id, $user->contacted_sellers))
        return false;

        //Mail::to($data->seller_email)->send(new ContactSellerMail($user,Estate::findByUuid($data->uuid)));
        $user->contacted_sellers[] = $data['seller_id'];
        $user->save();
        return true;
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
        $user = User::findById(Auth::guard('sanctum')->user()->id);

       // $this->errorCheck->checkIfAlreadyReported($user->reported, $data->uuid, 'Nemovitost');

        $estate = Estate::findByUuid($data->uuid);
        $estate->reported += 1;
        $estate->save();
        
       // Mail::to(Admin::getAdmin()->email)->send(new Reported($user, $data));
    }
}
?>