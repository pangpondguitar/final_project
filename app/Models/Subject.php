<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $primaryKey = 's_id';
    use HasFactory;

    public function term_sub()
    {
        return $this->belongsTo(Terms_sub::class, 's_id');
    }
}
