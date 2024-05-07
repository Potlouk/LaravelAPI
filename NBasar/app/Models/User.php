<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'surname',
        'password',
        'watched_estates',
        'reported_estates'
    ];

    protected $hidden = [
        'password',
    ];

    public static $patchable = [
        'name',
        'email',
        'surname',
    ];

    protected $casts = [
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

    public static function findByIdWithRoles($id) {
        return User::with('roles')->where('id', $id)->first();
    }

    public static function findByEmail($email) {
        return User::where('email', $email)->first();
    }
}
