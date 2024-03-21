<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc_course extends Model
{
    use HasFactory;

    protected $primaryKey = 'dcf_id';

    protected $fillable = [
        'c_id',
        'dcf_name',
        'dcf_file'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'c_id');
    }
}
