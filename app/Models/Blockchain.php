<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'previous_hash',
        'current_hash',
        'transaction',    
    ];

    public static function addBlock(string $transData): self
    {
        // Step 1: Ensure genesis block exists
        if (! self::exists()) {
            self::create([
                'timestamp'  => now(),
                'prev_hash'  => '0',
                'curr_hash'  => hash('sha256', now() . '0' . 'Genesis Block'),
                'trans_data' => 'Genesis Block',
            ]);
        }

        // Step 2: Get last block
        $lastBlock = self::latest('id')->first();

        // Step 3: Create new block
        $timestamp = now();
        $prevHash = $lastBlock->curr_hash;

        return self::create([
            'timestamp'  => $timestamp,
            'prev_hash'  => $prevHash,
            'curr_hash'  => hash('sha256', $timestamp . $prevHash . $transData),
            'trans_data' => $transData,
        ]);
    }
}
