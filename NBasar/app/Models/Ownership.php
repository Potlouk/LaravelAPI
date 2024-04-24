<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ownership extends Model
{
    use HasFactory;

    protected $table = 'estate_ownership_types';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
