<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'estate_room_types';
    protected $primaryKey = 'id';
    public $timestamps = false;

    
}
