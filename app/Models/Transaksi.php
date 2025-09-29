<?php

namespace App\Models;

use App\Models\Blockchain;
use App\Models\Lapak;
use App\Models\Rph;
use App\Models\Ternak;
use App\Models\User;
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
            $transdata = new TransData($transaksi);
            $ternak = Ternak::find($transaksi->ternak_id);
            $ternak->decrement('sisa_karkas', $transaksi->jumlah);   
            Blockchain::addBlock($transdata->json());
        });
    }
}

class TransData
{
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

    public function __construct($transaksi)
    {
        $this->id_transaksi = $transaksi->id;
        $this->nama_rph = Rph::find($transaksi->rph_id)?->name;
        $this->nama_lapak = User::find($transaksi->lapak_id)?->name;
        $this->nama_juleha = User::find(Ternak::find($transaksi->ternak_id)?->juleha_id)?->name;
        $this->nama_peternak = User::find(Ternak::find($transaksi->ternak_id)?->penyelia_id)?->name;
        $this->jumlah = $transaksi->jumlah;
        $this->waktu_sembelih = Ternak::find($transaksi->ternak_id)?->waktu_sembelih;
        $this->waktu_kirim = $transaksi->waktu_kirim;
        $this->waktu_selesai_kirim = null;
        $this->id_csa = null;
        $this->suhu_min = null;
        $this->suhu_max = null;
        $this->kelembapan_min = null;
        $this->kelembapan_max = null;
        $this->status_validasi = 'Dalam proses';
        $this->waktu_upload = date('Y-m-d H:i:s');
    }

    public function json()
    {
        return json_encode($this);
    }
}
