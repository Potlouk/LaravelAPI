<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'estate_additional_equipment';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'estate_id',
        'equipment_id',
    ];

    public static $patchable = [
        'estate_id',
        'equipment_id',
    ];

    public function estates()
    {
        return $this->belongsToMany(Estate::class, 'estate_has_equipment', 'equipment_id', 'estate_id');
    }



}
