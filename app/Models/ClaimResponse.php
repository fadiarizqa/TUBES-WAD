<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClaimResponse extends Model
{
    use HasFactory;

    protected $table = 'claim_responses'; // opsional kalau nama tabel sesuai konvensi

    protected $fillable = [
        'claim_user_id',
        'status',
        'message',
    ];

    public function claimUser()
    {
        return $this->belongsTo(ClaimUser::class);
    }
}
