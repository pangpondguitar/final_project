<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terms_sub_teach extends Model
{
    use HasFactory;
    protected $primaryKey = 'tst_id';

    protected $fillable = [
        'id',
        'ts_id'
    ];
    protected $relations = ['terms_sub', 'users'];
    // public function terms_sub(): HasMany
    // {
    //     return $this->hasMany(terms_sub::class, 'ts_id');
    // }

    public function terms_sub()
    {
        return $this->belongsTo(terms_sub::class, 'ts_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
