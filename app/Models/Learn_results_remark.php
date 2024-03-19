<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learn_results_remark extends Model
{
    use HasFactory;
    protected $primaryKey = 'lrr_id';

    protected $fillable = [
        'lrl_id',
        'lrd_id'
    ];

    public function learn_result_list()
    {
        return $this->belongsTo(Learn_results_list::class, 'lrl_id');
    }
}
