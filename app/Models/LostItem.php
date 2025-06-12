<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    protected $table = 'lost_items';

    protected $fillable = [
        'user_id',
        'posting_type',
        'full_name',
        'lost_item_name',
        'item_type',
        'item_description',
        'phone_number',
        'social_media',
        'item_photo',
        'lost_location',
        'lost_date',
        'status' => 'none',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'post');
    }
    
    public function reports() {
        return $this->morphMany(Reports::class, 'post', 'post_type', 'post_id');
    }

}