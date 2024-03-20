<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective_remark extends Model
{
    use HasFactory;

    protected $primaryKey = 'ojr_id';
    protected $fillable = [
        'obj_id',
        'lrl_id'
    ];

    public function learn_result_list()
    {
        return $this->belongsTo(Learn_results_list::class, 'lrl_id');
    }
}
