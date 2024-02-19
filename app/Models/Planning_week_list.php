<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_week_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'pwl_id';

    protected $fillable = [
        'pwl_title',
        'pw_id',
        'pt_id'
    ];
}
