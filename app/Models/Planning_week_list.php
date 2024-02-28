<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_week_list extends Model
{
    use HasFactory;
    protected $primaryKey = 'pwl_id';

    protected $fillable = [
        'pwl_title',
        'pw_id',
        'pt_id'
    ];


    public function planing_topic()
    {
        return $this->belongsTo(Planning_topic::class,  'pt_id');
    }

    public function planing_week_hour()
    {
        return $this->belongsTo(Planning_week_hour::class,  'pw_id');
    }
}
