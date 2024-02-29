<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measure_prac_topic extends Model
{
    use HasFactory;
    protected $primaryKey = 'mpt_id';

    protected $fillable = [
        'mpt_title'
    ];

    public function measure_prac_list()
    {
        return $this->hasMany(Measure_prac_list::class, 'mpt_id');
    }
}
