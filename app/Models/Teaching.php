<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    use HasFactory;

    protected $primaryKey = 'tc_id';

    protected $fillable = [
        'id',
        's_id'
    ];
}
