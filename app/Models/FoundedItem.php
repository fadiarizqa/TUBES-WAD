<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundedItem extends Model
{
    use HasFactory;

    protected $table = 'found_items';

    protected $fillable = ['user_id',
     'title',
     'description',
     'location',
     'found_date',
     'status',
     'claimed_by'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function foundedItem() {
        return $this->belongsTo(FoundedItem::class);
    }
}
