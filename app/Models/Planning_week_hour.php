<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_week_hour extends Model
{
    use HasFactory;
    protected $primaryKey = 'pw_id';

    protected $fillable = [
        'pw_week',
        'pw_hour',
        'ts_id'
    ];
}
