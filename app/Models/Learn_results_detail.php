<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learn_results_detail extends Model
{
    use HasFactory;

    protected $primaryKey = 'lrd_id';

    protected $fillable = [
        'lrd_title',
        'tlr_id',
        'ts_id',
        'lrd_remark'
    ];

    public function topic_learn_results()
    {
        return $this->belongsTo(Topic_learn_results::class,  'tlr_id');
    }
    public function term_sub()
    {
        return $this->belongsTo(Terms_sub::class, 'ts_id');
    }
}
