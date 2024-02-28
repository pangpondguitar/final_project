<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning_week_hour extends Model
{
    use HasFactory;
    protected $primaryKey = 'pw_id';

    protected $fillable = [
        'pw_week',
        'pw_hour',
        'ts_id'
    ];

    public function planing_week_list()
    {
        return $this->hasMany(Planning_week_list::class,  'pw_id');
    }
}
