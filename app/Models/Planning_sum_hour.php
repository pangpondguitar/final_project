<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_sum_hour extends Model
{
    use HasFactory;

    protected $primaryKey = 'psh_id';

    protected $fillable = [
        'psh_describe',
        'psh_practice',
        'psh_self',
        'ts_id'
    ];
}
