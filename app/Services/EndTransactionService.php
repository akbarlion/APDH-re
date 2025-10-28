<?php

namespace App\Services;

use App\Models\IoTChain;
use App\Services\CSAService;

class EndTransactionService
{
    /**
     * Create a new class instance.
     */
    public static function handle($node_id, $from)
    {
        $transactions = IoTChain::where('transaction->node', '=', $node_id)
            ->whereBetween('timestamp', [$from, now()->format('Y-m-d H:i:s')])
            ->pluck('transaction');

        /**
         * In case someone forgot to turn on the sensor, the app should still run
         * okay. Just the csa won't run, temp and humi will be null
         */
        if ($transactions->isEmpty()) {
            return null;
        }

        $humi_list = $transactions->pluck('humi')->all();
        $temp_list = $transactions->pluck('temp')->all();

        $csa = new CSAService();

        return json_decode(json_encode([
            'humi' => [
                'max' => $csa->run($humi_list, mode: 'max'),
                'min' => $csa->run($humi_list, mode: 'min'),
            ],
            'temp' => [
                'max' => $csa->run($temp_list, mode: 'max'),
                'min' => $csa->run($temp_list, mode: 'min'),
            ],
        ]));
    }
}
