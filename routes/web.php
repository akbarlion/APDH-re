<?php
declare(strict_types=1);

use App\Http\Controllers\BcController;
use App\Models\Blockchain;
use App\Models\IoT;
use App\Models\IoTChain;
use App\Models\Transaksi;
use App\Services\EndTransactionService;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'));

Route::resource('blocks', BcController::class)->only(['index', 'show']);

Route::get('/qr/{transaksi_id}', function ($transaksi_id) {
    $url = url('blocks/' . $transaksi_id);

    $writer = new PngWriter();
    $qrcode = new QrCode(
        data: $url,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255),
    );

    $result = $writer->write($qrcode);
    return response($result->getString())->header('Content-Type', $result->getMimeType());
});

Route::get('/end/{transaksi_id}', function ($transaksi_id) {
    $transaksi = Transaksi::find($transaksi_id);
    if (!$transaksi) {
        abort(404);
    }
    $temp_humi_csa = EndTransactionService::handle($transaksi->iot->node, $transaksi->waktu_kirim);
    $new_block = Blockchain::findBlock($transaksi_id)->transactions;
    $new_block['waktu_selesai_kirim'] = now()->format('Y-m-d H:i:s');
    $new_block['suhu_min'] = $temp_humi_csa?->temp->min;
    $new_block['suhu_max'] = $temp_humi_csa?->temp->max;
    $new_block['kelembapan_min'] = $temp_humi_csa?->humi->min;
    $new_block['kelembapan_max'] = $temp_humi_csa?->humi->max;
    Blockchain::addBlock(json_encode($new_block));
});

Route::get('/insert', function (Request $request) {
    $node = IoT::firstWhere('node', $request->node);

    if (!$node) {
        abort(404);
    }

    $req = $request->only('node', 'humi', 'temp');
    // Cast 'humi' and 'temp' to integers
    $req['humi'] = (int) $req['humi'];
    $req['temp'] = (int) $req['temp'];
    $stamp = $request->input('stamp');

    IoTChain::addBlock(json_encode($req), $stamp);
    return IoTChain::getLatestBlock();
});
