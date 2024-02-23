<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measure_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'ml_id';

    protected $fillable = [
        'ml_title',
        'ml_value',
        'ts_id'
    ];
}
