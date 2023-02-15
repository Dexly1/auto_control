<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangesList extends Model
{
    protected $fillable = ['auto_id', 'record_id', 'record_type', 'comment', 'img_old', 'img_new', 'create_date'];
    use HasFactory;
}
