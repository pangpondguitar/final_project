<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_detail extends Model
{
    protected $primaryKey = 'user_d_id';
    protected $relation = ['users'];
    use HasFactory;
    protected $fillable = [
        'user_d_name',
        'user_d_name2',
        'user_d_add',
        'user_d_email',
        'user_d_phone',
        'id',
        'p_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
