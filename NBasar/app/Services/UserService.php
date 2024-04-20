<?php
namespace App\Services;

use App\Exceptions\ExceptionTypes;
use App\Mail\ContactSellerMail;
use App\Mail\Registration;
use App\Mail\Reported;
use App\Models\Admin;
use App\Models\RealEstate;
use App\Models\User;
use App\Services\ErrorCheckService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Class UserService{

    public function __construct(private $errorCheck) {
        $this->errorCheck = new ErrorCheckService(ExceptionTypes::UserException);
    }

    public function getUser($id){
        $user = User::findById($id);
        return $user;
    }

    public function getUsers($limit){
        $users = User::all()->paginate($limit);
        return $users;
    }

    public function patchUser($id, $data){
        $user = User::findById($id);
        $patchData = (object) Arr::only((array) $data,  User::$patchable);
        
        foreach ($patchData as $key => $value)
            $user->$key = $value;

        return $user;
    }

    public function deleteUser($id){
        $user = User::findById($id);
        $user->delete();
    }

    public function createUser($data){
        $user = new User($data);
        Mail::to($user->email)->send(new Registration($user));
        $user->assignRole('User');
        $user->save();
        return $user->createToken("accessToken");
    }

    public function login($data){
        $user = User::findByEmail($data->email);
        $this->errorCheck->checkIfMashMatching($data->password, $user->password, 'heslo');
        
        return $user->createToken("accessToken");
    }

    public function contactSeller($data){
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        if(in_array($data->seller_id, $user->contacted_sellers))
        return false;

        Mail::to($data->seller_email)->send(new ContactSellerMail($user,RealEstate::findByUuid($data->uuid)));
        $user->contacted_sellers[] = $data['seller_id'];
        $user->save();
        return true;
    }

    public function addToFavorites($data){
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        
        if (!in_array($data->id, $user->watched_estates)){
            $user->watched_estates[] = $data->id;
            $user->save();
            return true;
        }
       
        $user->watched_estates = array_diff($user->watched_estates, [$data->id]);
        $user->save();
        return false;
    }

    public function reportEstate($data){
        $user = User::findById(Auth::guard('sanctum')->user()->id);

        $this->errorCheck->checkIfAlreadyReported($user->reported, $data->uuid, 'Nemovitost');

        $user->reported[] = $data->id;
        $user->save();
           
        $estate = RealEstate::findByUuid($data->uuid);
        $estate->reported += 1;
        $estate->save();
        
        Mail::to(Admin::getAdmin()->email)->send(new Reported($user, $data));
    }
}
?>