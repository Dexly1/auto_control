<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['auto_id', 'img_in', 'img_out', 'edit_img_in', 'edit_img_out', 'auto_time_in', 'auto_time_out'];
    use HasFactory;
}
