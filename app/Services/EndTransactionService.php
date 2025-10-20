<?php

namespace App\Services;

class EndTransactionService
{
    /**
     * Create a new class instance.
     */
    public static function handle($node_id, $from)
    {
        $transactions = IoTChain::query()
            ->where('transaction->node', '=', $node_id)
            ->whereBetween('timestamp', [$from, $to])
            ->get(['transaction']);

        dd($transactions);
    }
}
