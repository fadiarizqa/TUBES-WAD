<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClaimUser extends Model
{
    use HasFactory;

    protected $table = 'claim_users'; // opsional kalau nama tabel sesuai konvensi

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nomor_telepon',
        'media_sosial',
        'lokasi_kehilangan',
        'waktu_kehilangan',
        'deskripsi_claim',
        'bukti_kepemilikan',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function claimResponse()
    {
        return $this->hasOne(ClaimResponse::class);
    }

    public function foundedItem()
    {
        return $this->belongsTo(FoundedItem::class);
    }

}
