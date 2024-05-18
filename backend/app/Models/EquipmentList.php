<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentList extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'estate_has_equipment';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'estate_id',
        'equipment_id',
    ];

}
