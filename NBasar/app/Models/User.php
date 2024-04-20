<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'data',
        'contacted_sellers',
        'watched_estates',
        'reported_estates'
    ];

    protected $hidden = [
        'password',
    ];

    public $patchable = [
        'name',
        'email',
        'surname',
        'password',
        'data',
        'contacted_sellers',
        'watched_estates',
        'reported_estates',
    ];

    protected $casts = [
        'data' => 'json',
        'contacted_sellers' => 'array',
        'watched_estates' => 'array',
        'reported_estates' => 'array',
    ];
    
    public function estate(){
        return $this->hasMany('App\Models\RealEstate');
    }

    public static function findById($id) {
        return User::where('id', $id)->first();
    }
    public static function findByEmail($email) {
        return User::where('email', $email)->first();
    }
    public static function GetFilteredUser($id){
        return User::select('name','email','id')->where('id', $id)->first();
    }
    public static function getUsers($limit) {
        return User::all()->paginate($limit);
    }
}
