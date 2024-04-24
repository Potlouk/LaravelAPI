<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Energy extends Model
{
    use HasFactory;

    protected $table = 'estate_energy_consumptions';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
