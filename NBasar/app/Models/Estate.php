<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;

class Estate extends Model
{
    use HasFactory;

    protected $table = 'estates';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
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
        'transaction_type',
        'furniture',
        'room_type',
        'images',
    ];

    protected $casts = [
        'data' => 'json',
        'images' => 'array',
    ];

    public static $patchable = [
        'price',
        'info',
        'floor',
        'sub_type',
        'building_material',
        'ownership_type',
        'energy_consumption',
        'type',
        'condition',
        'room_type',
        'furniture',
        'area',
        'transaction_type',
    ];

   
    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'estate_has_equipment', 'estate_id', 'equipment_id');
    }

    public function elocation()
    {
        return $this->belongsTo(Location::class, 'location');
    }

    public function ownershipType()
    {
        return $this->belongsTo(Ownership::class, 'ownership_type');
    }

    public function energyConsumption(){
        return $this->belongsTo(Energy::class, 'energy_consumption');
    }

    public function owner(){
        return $this->belongsTo('App\Models\User');
    }

    public function etype(){
        return $this->belongsTo(EType::class, 'type');
    }

    public function subType(){
        return $this->belongsTo(ESubType::class, 'sub_type');
    }

    public function buildingMaterial(){
        return $this->belongsTo(BuildingMaterial::class, 'building_material');
    }

    public function conditionType(){
        return $this->belongsTo(Condition::class, 'condition');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function roomType(){
        return $this->belongsTo(Room::class, 'room_type');
    }

    public function energy(){
        return $this->belongsTo(Energy::class, 'energy_consumption');
    }

    public static function findById($id) {
        return Estate::where('id', $id)->first();
    }
    public static function findByUuid($id) {
        return Estate::where('uuid', $id)->first();
    }

    public static function costumeCollection($filters){
        $query = Estate::query();
        foreach ($filters as $key => $value){
            $query->where($key, $value);
        }
        return $query->get()->paginate(10);
    }
}
