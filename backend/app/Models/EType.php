<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EType extends Model
{
    use HasFactory;

    protected $table = 'estate_types';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
