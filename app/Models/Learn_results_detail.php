<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learn_results_detail extends Model
{
    use HasFactory;

    protected $primaryKey = 'lrd_id';

    protected $fillable = [
        'lrd_title',
        'tlr_id',
        'ts_id',
        'lrd_remark'
    ];
}