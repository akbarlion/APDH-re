<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class BcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Blockchain::all();
    }

    /**
     * Display the specified resource.
     */
    public function show($transaksi_id)
    {
        $block = Blockchain::whereRaw('json_extract(
                    "transaction",
                    "$.id_transaksi"
                ) = CAST(? AS INTEGER)', [$transaksi_id])->get();

        return $block;
    }
}
