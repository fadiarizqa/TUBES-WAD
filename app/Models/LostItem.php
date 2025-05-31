<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    use HasFactory;

    protected $table = 'lost_items';

    protected $fillable = [
        'posting_type',
        'full_name',
        'lost_item_name',
        'item_type',
        'item_description',
        'phone_number',
        'social_media',
        'item_photo',
        'status',
        'lost_location',
        'lost_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}