<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    protected $table = 'beasiswa';
    protected $fillable = ['nama', 'deskripsi', 'instansi', 'min_ipk', 'tingkat_pendidikan', 'thumbnail', 'banner', 'logo_instansi'];

    public function penerima()
    {
        return $this->hasMany(PendaftarBeasiswa::class, 'beasiswa_id', 'id');
    }

}
