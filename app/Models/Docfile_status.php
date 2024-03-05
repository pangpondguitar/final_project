<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docfile_status extends Model
{
    use HasFactory;
    protected $primaryKey = 'dfs_id';

    protected $fillable = [
        'dfs_status',
        'df_id',
    ];
    public function docfile()
    {
        return $this->belongsTo(Docfile::class, 'df_id');
    }
}
