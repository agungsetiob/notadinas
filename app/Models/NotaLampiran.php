<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaLampiran extends Model
{
    use HasFactory;

    protected $table = 'nota_lampirans';

    protected $fillable = [
        'nota_dinas_id',
        'nota_pengiriman_id',
        'nama_file',
        'path'
    ];

    /**
     * Relasi ke model NotaDinas
     */
    public function notaDinas()
    {
        return $this->belongsTo(NotaDinas::class);
    }
    public function pengirimans()
    {
        return $this->belongsToMany(NotaPengiriman::class, 'nota_pengiriman_lampiran', 'nota_lampiran_id', 'nota_pengiriman_id')
                    ->withTimestamps();
    }    
   
}
