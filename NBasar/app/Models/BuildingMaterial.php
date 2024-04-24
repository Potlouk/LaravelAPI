<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingMaterial extends Model
{
    use HasFactory;

    protected $table = 'estate_building_material_types';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
