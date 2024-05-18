<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    use HasFactory;
    protected $table = 'locations_counties';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
