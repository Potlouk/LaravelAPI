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
        'short_name',
        'zip_code',
        'coordinates',
        'county',
    ];

    public static $patchable = [
        'address',
        'short_name',
        'zip_code',
        'county',
        'coordinates',
    ];

    protected $casts = [
        'coordinates' => 'json',
    ];

    public function lcounty()
    {
        return $this->belongsTo(County::class, 'county');
    }

    public static function findByAdress($data) {
        return Location::where('address', $data->address)
        ->where('short_name', $data->short_name)
        ->where('zip_code', $data->zip_code)
        ->where('county', $data->county)
        ->first();  
    }

    public static function findById($id) {
        return Location::where('id', $id)->first();
    }

}
