<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terms_sub extends Model
{
    use HasFactory;
    protected $primaryKey = 'ts_id';

    protected $fillable = [
        't_id',
        's_id'
    ];

    protected $relations = ['subjects'];

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 's_id');
    }
}
