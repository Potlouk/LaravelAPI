<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'estate_locations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'address',
        'city',
        'zip_code',
        'coordinates',
    ];

    public static $patchable = [
        'address',
        'city',
        'zip_code',
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public static function findByAdress($data) {
        return Location::where('address', $data->address)
        ->where('city', $data->city)
        ->where('zip_code', $data->zip_code)
        ->first();  
    }

    public static function findById($id) {
        return Location::where('id', $id)->first();
    }

}
