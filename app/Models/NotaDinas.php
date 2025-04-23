<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaDinas extends Model
{
    protected $fillable = [
        'skpd_id', 'nomor_nota', 'perihal', 'anggaran', 'tanggal_pengajuan',
        'status', 'tahap_saat_ini', 'asisten_id'
    ];

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }

    public function lampirans()
    {
        return $this->hasMany(NotaLampiran::class, 'nota_dinas_id');
    }

    public function pengirimans()
    {
        return $this->hasMany(NotaPengiriman::class, 'nota_dinas_id');
    }
    public function persetujuans()
    {
        return $this->hasMany(NotaPersetujuan::class);
    }
    
}
