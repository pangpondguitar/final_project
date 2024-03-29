<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measure_prac_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'mpl_id';

    protected $fillable = [
        'mpl_title',
        'mpt_id',
        'ts_id',
    ];
    public function measure_prac_topic()
    {
        return $this->belongsTo(measure_prac_topic::class, 'mpt_id');
    }
}
