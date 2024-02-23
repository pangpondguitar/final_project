<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prep_plan_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'ppl_id';

    protected $fillable = [
        'ppl_title',
        'ppt_id',
        'ts_id',
    ];
}
