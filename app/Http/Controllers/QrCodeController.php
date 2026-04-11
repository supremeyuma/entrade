<?php

namespace App\Http\Controllers;

use App\Services\QrCodeService;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService
    ) {
    }

    public function show(Request $request)
    {
        $text = (string) $request->query('text', '');

        abort_if($text === '', 422, 'The text query parameter is required.');

        $qrCode = $this->qrCodeService->generatePng($text);

        return response($qrCode['content'], 200)
            ->header('Content-Type', $qrCode['mime_type']);
    }
}
