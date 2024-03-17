<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $primaryKey = 'pf_id';

    protected $fillable = [
        'pf_name',
        'pf_date',
        'pf_year',
        'pf_detail',
        'pf_id'

    ];
    public function performance_file()
    {
        return $this->hasMany(PerformanceFile::class,  'pf_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,  'id');
    }
}
