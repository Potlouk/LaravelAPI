<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $table = 'estate_conditions_types';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
