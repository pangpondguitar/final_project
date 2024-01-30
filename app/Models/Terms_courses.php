<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms_courses extends Model
{
    use HasFactory;

    protected $primaryKey = 'tco_id';

    protected $fillable = [
        't_id',
        'p_id',
        'c_id'
    ];
}
