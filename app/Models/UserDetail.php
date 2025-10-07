<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'no_hp',
        'foto_user',
        'alamat',
        'jenis_kelamin',
        'tanggal_lahir',
        'tinggi_badan',
        'berat_badan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
