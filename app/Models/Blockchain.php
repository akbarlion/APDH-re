<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{
    protected $table = 'blockchain';
    public $timestamps = false;
    protected $casts = [
        'transaction' => 'json'
    ];

    protected $fillable = [
        'timestamp',
        'previous_hash',
        'current_hash',
        'transaction',    
    ];

    public static function addBlock(string $transData): self
    {
        // Step 1: Ensure genesis block exists
        if (self::count() == 0) {
            self::create([
                'timestamp'  => now(),
                'previous_hash'  => '0',
                'current_hash'  => hash('sha256', now() . '0' . 'Genesis Block'),
                'transaction' => '{"0":"Genesis Block"}',
            ]);
        }

        // Step 2: Get last block
        $lastBlock = self::latest('id')->first();

        // Step 3: Create new block
        $timestamp = now();
        $prevHash = $lastBlock->current_hash;

        return self::create([
            'timestamp'  => $timestamp,
            'previous_hash'  => $prevHash,
            'current_hash'  => hash('sha256', $timestamp . $prevHash . $transData),
            'transaction' => $transData,
        ]);
    }
}
