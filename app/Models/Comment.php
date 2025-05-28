<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['user_id', 'post_type', 'post_id', 'content'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->belongsTo(Comments::class);
    }
}
