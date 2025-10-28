<?php

namespace App\Data;

use App\Models\RPH;
use App\Models\Ternak;
use App\Models\User;

class TransactionData
{
    public static function builder($transaksi)
    {
        $ternak = Ternak::find($transaksi->ternak_id);

        $data = [
            'id_transaksi' => $transaksi->id,
            'id_csa' => null,
            'nama_rph' => Rph::find($transaksi->rph_id)?->name,
            'nama_lapak' => User::find($transaksi->lapak_id)?->name,
            'nama_juleha' => User::find($ternak?->juleha_id)?->name,
            'nama_peternak' => User::find($ternak?->penyelia_id)?->name,
            'jumlah' => $transaksi->jumlah,
            'waktu_sembelih' => $ternak?->waktu_sembelih,
            'waktu_kirim' => $transaksi->waktu_kirim,
            'waktu_selesai_kirim' => null,
            'suhu_min' => null,
            'suhu_max' => null,
            'kelembapan_min' => null,
            'kelembapan_max' => null,
            'status_validasi' => 'Dalam proses',
            'waktu_upload' => now()->format('Y-m-d H:i:s'),
        ];

        return json_encode($data);
    }
}
