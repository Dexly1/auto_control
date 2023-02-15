<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $fillable = ['brand_id', 'model_id', 'register_sign', 'current_record'];
    use HasFactory;
}
