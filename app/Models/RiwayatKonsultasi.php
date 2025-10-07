<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKonsultasi extends Model
{
    use HasFactory;
    protected $table = 'riwayat_konsultasi';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'diagnosa',
        'obat',
        'keterangan'
    ];
}
