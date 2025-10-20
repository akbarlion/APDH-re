<?php

namespace App\Services;

use App\Models\IoTChain;

class EndTransactionService
{
    /**
     * Create a new class instance.
     */
    public static function handle($node_id, $from)
    {
        $transactions = IoTChain::select('transaction')
            ->where('transaction->node', '=', $node_id)
            ->whereBetween('timestamp', [$from, now()->format('Y-m-d H:i:s')])
            ->get();

        $res = collect($transactions)->flatMap(fn($sublist) => collect($sublist));

        $humi_list = $res->pluck('humi')->all();
        $temp_list = $res->pluck('temp')->all();
        dd($transactions);
    }
}
