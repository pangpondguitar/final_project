<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docfile extends Model
{
    use HasFactory;
    protected $primaryKey = 'df_id';

    protected $fillable = [
        'df_name',
        'ts_id',
        'id'
    ];
    public function term_sub()
    {
        return $this->belongsTo(Terms_sub::class, 'ts_id');
    }
    public function docfile_status()
    {
        return $this->hasMany(Docfile_status::class, 'df_id');
    }
}
