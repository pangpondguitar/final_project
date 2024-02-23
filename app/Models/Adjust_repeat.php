<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjust_repeat extends Model
{
    use HasFactory;
    protected $primaryKey = 'apr_id';

    protected $fillable = [
        'apr_title',
        'ts_id'
    ];
}
