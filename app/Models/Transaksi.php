<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $fillable = [
        'iot_id',
        'lapak_id',
        'ternak_id',
        'jumlah',
        'waktu_kirim',
        'waktu_selesai_kirim',
        'status_kirim',
    ];

    /*
     * Relasi ke model iot
     * @return BelongsTo
     */
    public function iot(): BelongsTo
    {
        return $this->belongsTo(Iot::class);
    }

    /*
     * Relasi ke model lapak
     * @return BelongsTo
     */
    public function lapak(): BelongsTo
    {
        return $this->belongsTo(Lapak::class);
    }

    /*
     * Relasi ke model ternak
     * @return BelongsTo
     */
    public function ternak(): BelongsTo
    {
        return $this->belongsTo(Ternak::class);
    }

    /*
     * Auto fill 'status_kirim' field with 'dikirim'
     * every time a new record is created
     */

    protected static function booted()
    {
        static::creating(function ($transaksi) {
            $transaksi->status_kirim = 'dikirim';
        });
    }
}
