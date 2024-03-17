<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceFile extends Model
{
    use HasFactory;
    protected $primaryKey = 'pff_id';

    protected $fillable = [
        'pff_name',
        'pf_id'
    ];
    public function performance()
    {
        return $this->belongsTo(Performance::class,  'pf_id');
    }
}
