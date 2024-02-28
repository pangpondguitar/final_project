<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Terms extends Model
{
    use HasFactory;
    protected $primaryKey = 't_id';

    protected $fillable = [
        't_name',
        't_year'
    ];
    public function term_sub()
    {
        return $this->hasMany(Terms_sub::class, 't_id');
    }
}
