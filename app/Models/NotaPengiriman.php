<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaPengiriman extends Model
{
    use HasFactory;

    protected $table = 'nota_pengirimen';

    protected $fillable = [
        'nota_dinas_id',
        'dikirim_dari',
        'dikirim_ke',
        'pengirim_id',
        'tanggal_kirim',
        'catatan'
    ];

    /**
     * Relasi ke model NotaDinas
     */
    public function notaDinas()
    {
        return $this->belongsTo(NotaDinas::class);
    }

    /**
     * Relasi ke model User
     */
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function lampirans()
    {
        return $this->belongsToMany(NotaLampiran::class, 'nota_pengiriman_lampiran', 'nota_pengiriman_id', 'nota_lampiran_id')
                    ->withTimestamps();
    }

    protected $casts = [
        'lampiran' => 'array',
    ];    

}
