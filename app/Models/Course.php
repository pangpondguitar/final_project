<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Models\Subject;

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

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'c_id');
    }

    public function topic_learn_results()
    {
        return $this->hasMany(Topic_learn_results::class, 'c_id');
    }
}
