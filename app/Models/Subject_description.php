<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject_description extends Model
{
    use HasFactory;

    protected $primaryKey = 'sd_id';

    protected $fillable = [
        'sd_title',
        'sd_title_eng',
        'ts_id'
    ];
}
