<?php

namespace App\Services;

use BaconQrCode\Encoder\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QRCodeService
{
    public function generate(string $data, string $filename = null): string
    {
        $filename = $filename ?? 'qr-' . Str::uuid() . '.png';
        $path = 'qrcodes/' . $filename;

        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );

        $qrCode = QrCode::encode($data);
        $tempPath = sys_get_temp_dir() . '/' . $filename;
        
        // Generate QR code to temp file
        file_put_contents($tempPath, $renderer->render($qrCode));
        
        // Store in public storage
        Storage::disk('public')->put($path, file_get_contents($tempPath));
        
        // Clean up temp file
        unlink($tempPath);

        return $path;
    }

    public function generateForPeminjaman(int $peminjamanId): string
    {
        $data = route('peminjaman.show', $peminjamanId);
        return $this->generate($data, "peminjaman-{$peminjamanId}.png");
    }

    public function delete(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
