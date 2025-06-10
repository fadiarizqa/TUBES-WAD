<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $fillable = [
        'user_id', 'post_id', 'post_type', 'reason', 'status',
    ];

    public function post()
    {
        return $this->morphTo(__FUNCTION__, 'post_type', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
