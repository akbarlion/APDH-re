<?php

namespace App\Models;

use App\Models\Blockchain;
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

        static::created(function ($transaksi) {
            Blockchain::addBlock($transaksi->toJson()); 
        });
    }

}

class TransData {
    public $id_transaksi;
    public $id_csa;
    public $nama_rph;
    public $nama_lapak;
    public $nama_juleha;
    public $nama_peternak;
    public $jumlah;
    public $waktu_sembelih;
    public $waktu_kirim;
    public $waktu_selesai_kirim;
    public $suhu_min;
    public $suhu_max;
    public $kelembapan_min;
    public $kelembapan_max;
    public $status_validasi;
    public $waktu_upload;

    public function __construct($transaksi) {
        $this->id_transaksi = $transaksi->id;
        $this->id_csa = $transaksi->iot->id_csa;
        $this->nama_rph = $transaksi->iot->rph->nama_rph;
        $this->nama_lapak = $transaksi->lapak->user->name;
        $this->nama_juleha = $transaksi->ternak->juleha->nama_juleha;
        $this->nama_peternak = $transaksi->ternak->peternak->name;
        $this->jumlah = $transaksi->jumlah;
        $this->waktu_sembelih = $transaksi->waktu_sembelih;
        $this->waktu_kirim = $transaksi->waktu_kirim;
        $this->waktu_selesai_kirim = $transaksi->waktu_selesai_kirim;
        $this->suhu_min = $transaksi->suhu_min;
        $this->suhu_max = $transaksi->suhu_max;
        $this->kelembapan_min = $transaksi->kelembapan_min;
        $this->kelembapan_max = $transaksi->kelembapan_max;
        $this->status_validasi = $transaksi->status_validasi;
        $this->waktu_upload = $transaksi->created_at;
    }
}
