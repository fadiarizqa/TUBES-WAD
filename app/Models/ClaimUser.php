<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClaimUser extends Model
{
    use HasFactory;

    protected $table = 'claim_users'; // opsional kalau nama tabel sesuai konvensi

    protected $fillable = [
        'nama_lengkap',
        'nomor_telepon',
        'media_sosial',
        'lokasi_kehilangan',
        'waktu_kehilangan',
        'bukti_kepemilikan',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function response()
    {
        return $this->hasOne(ClaimResponse::class);
    }
}
