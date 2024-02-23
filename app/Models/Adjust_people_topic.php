<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjust_people_topic extends Model
{
    use HasFactory;
    protected $primaryKey = 'apt_id';

    protected $fillable = [
        'apt_title'
    ];
}
