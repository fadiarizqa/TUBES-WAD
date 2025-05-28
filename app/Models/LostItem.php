<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    protected $table = 'lost_items';

    protected $fillable = ['user_id', 'title', 'description', 'location', 'lost_date', 'status', 'title', 'claimed_by'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lostItem() {
        return $this->belongsTo(LostItem::class);
    }
}
