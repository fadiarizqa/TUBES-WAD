<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'histories';

    protected $fillable = ['user_id', 'item_type', 'action'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function history() {
        return $this->belongsTo(History::class);
    }
}
