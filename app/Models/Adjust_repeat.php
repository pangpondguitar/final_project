<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjust_repeat extends Model
{
    use HasFactory;
    protected $primaryKey = 'adr_id';

    protected $fillable = [
        'adr_title',
        'ts_id'
    ];
}
