<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoModel extends Model
{
    protected $fillable = ['brand_id', 'model_name'];
    use HasFactory;
}
