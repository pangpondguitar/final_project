<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjust_people_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'apl_id';

    protected $fillable = [
        'apl_title',
        'apt_id',
        'ts_id'
    ];
}
