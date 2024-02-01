<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $primaryKey = 's_id';

    use HasFactory;
    protected $fillable = [
        's_num',
        's_name',
        's_name2',
        'c_id',
        'p_id'
    ];
    protected $relation = ['terms_subs'];

    // public function term_sub():HasMany
    // {
    //     return $this->belongsTo(Terms_sub::class, 's_id');
    // }


    public function term_sub(): HasMany
    {
        return $this->hasMany(Terms_sub::class, 's_id');
    }
}
