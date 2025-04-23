<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_skpd',
        'status',
        'asisten_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'skpd_id');
    }
    public function persetujuan()
    {
        return $this->hasMany(NotaPersetujuan::class);
    }

    public function asisten()
    {
        return $this->belongsTo(User::class, 'asisten_id');
    }
}
