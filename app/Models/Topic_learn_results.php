<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic_learn_results extends Model
{
    protected $primaryKey = 'tlr_id';


    use HasFactory;
    protected $fillable = [
        'tlr_title',
        'doc_type'
    ];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'c_id');
    }

    public function learn_results_detail()
    {
        return $this->hasMany(learn_results_detail::class,  'tlr_id');
    }
}
