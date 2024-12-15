<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftarBeasiswa extends Model
{
    protected $table = 'pendaftar_beasiswa';
    protected $fillable = ['user_id', 'beasiswa_id', 'transkrip_file', 'email', 'biodata', 'penghasilan_orang_tua', 'status', 'is_read'];

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'beasiswa_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
