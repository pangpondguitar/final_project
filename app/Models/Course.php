<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'c_id';
    protected $relation = ['program'];

    protected $fillable = [
        'c_name',
        'c_name2',
        'c_file',
        'p_id'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'p_id');
    }
}
