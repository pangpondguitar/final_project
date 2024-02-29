<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prep_plan_topic extends Model
{
    use HasFactory;
    protected $primaryKey = 'ppt_id';

    protected $fillable = [
        'ppt_title'
    ];

    public function prep_plan_list()
    {
        return $this->hasMany(Prep_plan_list::class, 'ppt_id');
    }
}
