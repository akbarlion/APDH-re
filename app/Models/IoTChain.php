<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iotchain extends Model
{
    protected $table = 'iotchain';
    public $timestamps = false;
    protected $casts = [
        'transaction' => 'json',
    ];

    protected $fillable = [
        'timestamp',
        'iot_timestamp',
        'previous_hash',
        'current_hash',
        'transaction',
    ];

    public static function addBlock(string $transData, string $iot_stamp): self
    {
        // Step 1: Ensure genesis block exists
        if (self::count() == 0) {
            $genesis = '{"0":"Genesis Block"}';
            self::create([
                'timestamp' => now(),
                'previous_hash' => '0',
                'current_hash' => hash('sha256', now() . '0' . $genesis),
                'transaction' => json_decode($genesis) 
            ]);
        }

        // Step 2: Get last block
        $lastBlock = self::latest('id')->first();

        // Step 3: Create new block
        $timestamp = now();
        $prevHash = $lastBlock->current_hash;

        return self::create([
            'timestamp' => $timestamp,
            'iot_timestamp' => $iot_stamp,
            'previous_hash' => $prevHash,
            'current_hash' => hash('sha256', $timestamp . $prevHash . $transData),
            'transaction' => json_decode($transData),
        ]);
    }

    public static function getLatestBlock(): self
    {
        return self::latest('id')->first();
    }
}
