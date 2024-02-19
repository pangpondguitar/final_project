<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_topic extends Model
{
    use HasFactory;
    protected $primaryKey = 'pt_id';

    protected $fillable = [
        'pt_title',
        'doc_type'
    ];
}
