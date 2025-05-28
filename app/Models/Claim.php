<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    
    protected $table = 'claim_requests';

    protected $fillable = ['item_type', 'action', 'item_id', 'message', 'status'];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function claims() {
        return $this->hasMany(Claim::class);
    }
}
