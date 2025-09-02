<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BcController;

Route::get('/', function () {
    return view('index');
});

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
        backgroundColor: new Color(255, 255, 255)
    );

    $result = $writer->write($qrcode);
    return response($result->getString())
        ->header('Content-Type', $result->getMimeType());
});
