<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RealEstate extends Model
{
    use HasFactory;

    protected $table = 'estates';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'price',
        'user_id',
        'uuid',
        'info',
        'reported_count',
        'floor',
        'sub_type',
        'building_material',
        'ownership_type',
        'energy_consumption',
        'type',
        'location', //coordinates
        'condition',
        'area',
        'onsale',
        'furniture',
        'room_count',

    ];

    protected $casts = [
        'data' => 'json',
        'info' => 'json',
    ];

    public static $patchable = [
        'title',
        'price',
        'info',
        'floor',
        'sub_type',
        'building_material',
        'ownership_type',
        'energy_consumption',
        'type',
        'condition',
    ];


    public function owner(){
        return $this->belongsTo('App\Models\User');
    }

    public static function findById($id) {
        return RealEstate::where('id', $id)->first();
    }
    public static function findByUuid($id) {
        return RealEstate::where('Uuid', $id)->first();
    }

    public static function costumeCollection($filters){
        $query = RealEstate::query();
        foreach ($filters as $key => $value){
            $query->where($key, $value);
        }
        return $query->get()->paginate(10);
    }
}
