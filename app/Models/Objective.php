<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;
    protected $primaryKey = 'obj_id';

    protected $fillable = [
        'obj_title',
        'ts_id',
        'lrl_id'
    ];
}
