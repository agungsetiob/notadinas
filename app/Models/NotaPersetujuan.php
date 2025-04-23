<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaPersetujuan extends Model
{
    protected $table = 'nota_persetujuans';
    protected $fillable = [
        'nota_dinas_id',
        'approver_id',
        'role_approver',
        'urutan',
        'status',
        'catatan_terakhir',
        'tanggal_update',
        'skpd_id'
    ];

    public function notaDinas(): BelongsTo
    {
        return $this->belongsTo(NotaDinas::class);
    }
    public function skpd(): BelongsTo
    {
        return $this->belongsTo(Skpd::class);
    }
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
