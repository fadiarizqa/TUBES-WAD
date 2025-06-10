<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundedItem extends Model
{
    use HasFactory;

    protected $table = 'found_items';

    protected $fillable = [
        'user_id',
        'posting_type', 
        'full_name',
        'found_item_name',
        'item_type',
        'item_description',
        'phone_number',
        'social_media',
        'item_photo', 
        'found_location',
        'found_date',
        'status' => 'none'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // public function foundedItem() {
    //     return $this->belongsTo(FoundedItem::class);
    // }
}
