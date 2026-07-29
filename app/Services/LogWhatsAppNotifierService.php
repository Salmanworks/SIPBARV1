<?php

namespace App\Services;

use App\Contracts\WhatsAppNotifierInterface;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * DUMMY / FALLBACK implementasi WhatsApp Notifier.
 * Tidak memerlukan API key eksternal — semua pesan WA disimpan di storage/logs/laravel.log
 * (channel: whatsapp-dummy channel) beserta context timestamp & peminjaman ID.
 *
 * Nanti bisa diganti concrete gateway asli (Fonnte, Wablas, dll) tanpa mengubah consumer code.
 */
class LogWhatsAppNotifierService implements WhatsAppNotifierInterface
{
    final public const GATEWAY_NAME = 'log-dummy';

    public function send(string $toNumber, string $message, ?Peminjaman $context = null): array
    {
        $normalizedNo = $this->normalizePhoneNumber($toNumber);
        $messageId = 'WA-' . Str::upper(Str::random(10));

        $payload = [
            'success' => true,
            'gateway' => self::GATEWAY_NAME,
            'message_id' => $messageId,
            'to_normalized' => $normalizedNo,
            'to_raw' => $toNumber,
            'peminjaman_id' => $context?->id,
            'sent_at' => now()->toIso8601String(),
            'message_length' => mb_strlen($message),
            'preview' => mb_strimwidth($message, 0, 140, '…'),
        ];

        // Tulis ke log channel khusus (bisa dilihat di storage/logs/laravel.log level info)
        Log::channel('stack')->info(
            '[WHATSAPP DUMMY GATEWAY] Pesan dikirim ke: ' . $normalizedNo .
            ($context?->id ? " (Peminjaman #{$context->id})" : ''),
            $payload + ['full_message' => $message]
        );

        return $payload;
    }

    /**
     * Normalisasi nomor HP ke format 628xxx (standard internasional Indonesia)
     * untuk kompatibilitas gateway WA production nantinya.
     */
    private function normalizePhoneNumber(string $rawNumber): string
    {
        $onlyDigits = preg_replace('/\D+/', '', (string) $rawNumber) ?? '';

        if (str_starts_with($onlyDigits, '62')) {
            return $onlyDigits;
        }
        if (str_starts_with($onlyDigits, '0')) {
            return '62' . substr($onlyDigits, 1);
        }

        // Default anggap nomor Indonesia, tambah prefix 62
        return '62' . ltrim($onlyDigits, '+');
    }
}
