<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc_committee extends Model
{
    use HasFactory;

    protected $primaryKey = 'dc_id';

    protected $fillable = [
        'id',
        'ts_id'
    ];
}
