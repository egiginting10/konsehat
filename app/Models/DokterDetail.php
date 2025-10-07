<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterDetail extends Model
{
    use HasFactory;
    protected $table = 'dokter_profiles';

    protected $fillable = [
        'user_id',
        'no_hp',
        'foto_dokter',
        'alamat',
        'jenis_kelamin',
        'tanggal_lahir',
        'spesialisasi',
        'status_online',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
