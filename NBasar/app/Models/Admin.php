<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use HasApiTokens, HasRoles;

    protected $table = 'admins';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public static $patchable = [
        'email',
        'password',
    ];

    public static function getAdmin() {
        return User::where('id', 1)->first();
    }
}
