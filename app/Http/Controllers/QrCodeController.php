<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends Controller
{
    public function show(Request $request)
    {
        $text = $request->query('text');

        $qr = QrCode::create($text)
            ->setSize(200)
            ->setMargin(10);

        $writer = new PngWriter();
        $result = $writer->write($qr);

        return response($result->getString(), 200)
            ->header('Content-Type', $result->getMimeType());
    }
}
