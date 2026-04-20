<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    /**
     * Generate a PNG QR code payload for the provided text.
     *
     * @return array{content: string, mime_type: string}
     */
    public function generatePng(string $text, int $size = 200, int $margin = 10): array
    {
        $qrCode = QrCode::create($text)
            ->setSize($size)
            ->setMargin($margin);

        $result = (new PngWriter())->write($qrCode);

        return [
            'content' => $result->getString(),
            'mime_type' => $result->getMimeType(),
        ];
    }
}
