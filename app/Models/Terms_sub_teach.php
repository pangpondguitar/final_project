<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms_sub_teach extends Model
{
    use HasFactory;
    protected $primaryKey = 'tst_id';

    protected $fillable = [
        'id',
        'ts_id'
    ];
}
