<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $primaryKey = 'p_id';
    protected $relation = ['courses'];
    protected $fillable = [
        'c_id'
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'p_id');
    }
}
