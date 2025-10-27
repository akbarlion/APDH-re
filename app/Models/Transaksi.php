<?php

namespace App\Models;

use App\Data\TransactionData;
use App\Models\Blockchain;
use App\Models\Lapak;
use App\Models\Ternak;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $fillable = [
        'iot_id',
        'lapak_id',
        'ternak_id',
        'rph_id',
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
        return $this->belongsTo(IoT::class);
    }

    /*
     * Relasi ke model lapak
     * @return BelongsTo
     */
    public function lapak(): BelongsTo
    {
        return $this->belongsTo(Lapak::class, 'lapak_id', 'user_id');
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
     * @return void
     */

    protected static function booted(): void
    {
        static::creating(function ($transaksi) {
            $transaksi->status_kirim = 'dikirim';
        });

        static::saved(function ($transaksi) {
            $ternak = Ternak::find($transaksi->ternak_id);
            $ternak->decrement('sisa_karkas', $transaksi->jumlah);
            Blockchain::addBlock(TransactionData::builder($transaksi));
        });
    }
}
