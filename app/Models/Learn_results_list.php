<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learn_results_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'lrl_id';

    protected $fillable = [
        'lrl_title',
        'ts_id'
    ];
}
