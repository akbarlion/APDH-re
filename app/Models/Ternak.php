<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Ternak extends Model
{
	 use HasFactory;

    protected $table = 'ternak';

    protected $fillable = [
        'peternak_id',
        'juleha_id',
        'penyelia_id',
        'img',
        'karkas',
        'jenis',
        'kesehatan',
        'waktu_sembelih',
        'validasi_1',
        'validasi_2',
        'bobot',
        'waktu_daftar',
        'no_antri',
    ];

    protected $casts = [
        'peternak_id' => 'integer',
        'juleha_id' => 'integer',
        'penyelia_id' => 'integer',
        'karkas' => 'float',
        'validasi_1' => 'boolean',
        'validasi_2' => 'boolean',
        'bobot' => 'float',
        'no_antri' => 'integer', // Ensure no_antri is cast to integer
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (Ternak $ternak) {
            $ternak->waktu_daftar = Carbon::now('Asia/Jakarta'); // Use Indonesian timezone
            $today = Carbon::now('Asia/Jakarta')->toDateString();

            // Get the last assigned no_antri for today
            $lastAntri = self::whereDate('created_at', $today)
                ->max('no_antri');

            $ternak->no_antri = $lastAntri ? $lastAntri + 1 : 1;

            // input NULL to juleha_id and penyelia_id if they are not inserted
            $ternak->juleha_id = $ternak->juleha_id ?? null;
            $ternak->penyelia_id = $ternak->penyelia_id ?? null;
        });
    }

    /**
     * Get the peternak that owns the ternak.
     */
    public function peternak(): BelongsTo
    {
        return $this->belongsTo(Peternak::class);
    }

    /**
     * Get the juleha that processed the ternak.
     */
    public function juleha(): BelongsTo
    {
        return $this->belongsTo(Juleha::class);
    }

    /**
     * Get the penyelia that supervised the ternak.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penyelia(): BelongsTo
    {
        return $this->belongsTo(Penyelia::class);
    }
}
