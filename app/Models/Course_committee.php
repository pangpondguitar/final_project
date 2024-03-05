<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_committee extends Model
{
    use HasFactory;
    protected $primaryKey = 'cm_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
