<?php

namespace App\Data;

use App\Models\RPH;
use App\Models\Ternak;
use App\Models\User;

class TransactionData
{
    public static function builder($transaksi)
    {
        // We need the next 3 lines since we'll handle casted data from model
        // that returned as array, and object from Filament Form.
        // My skill issue I guess.
        if (is_array($transaksi)) {
            $data = json_decode(json_encode($transaksi));
        }

        $ternak = Ternak::find($transaksi->ternak_id);

        // Only to be returned as array again. La vida es un carrusele I guess.
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
            'waktu_selesai_kirim' => $transaksi->waktu_selesai_kirim ?? null,
            'suhu_min' => $transaksi->suhu_min ?? null,
            'suhu_max' => $transaksi->suhu_max ?? null,
            'kelembapan_min' => $transaksi->kelembapan_min ?? null,
            'kelembapan_max' => $transaksi->kelembapan_max ?? null,
            'status_validasi' => $transaksi->status_validasi ?? 'Dalam proses',
            'waktu_upload' => now()->format('Y-m-d H:i:s'),
        ];

        return json_encode($data);
    }
}
