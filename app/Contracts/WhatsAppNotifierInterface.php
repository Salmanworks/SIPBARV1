<?php

namespace App\Contracts;

use App\Models\Peminjaman;

/**
 * Interface untuk pengiriman notifikasi WhatsApp (Gateway abstrak).
 * Concrete implementasi: LogWhatsAppNotifierService (dummy) / Fonnte / Wablas / dll.
 * Prinsip: Dependency Inversion — Command tidak bergantung pada vendor gateway.
 */
interface WhatsAppNotifierInterface
{
    /**
     * Kirim pesan WhatsApp via channel gateway manapun.
     *
     * @param  non-empty-string  $toNumber  Nomor HP target (format 62xxx atau 0xx otomatis dinormalisasi)
     * @param  non-empty-string  $message   Pesan teks mentah untuk dikirim
     * @param  Peminjaman|null  $context    Data peminjaman untuk logging / payload tambahan
     * @return array{success:bool,gateway:string,message_id?:string,error?:string,raw?:mixed}
     */
    public function send(string $toNumber, string $message, ?Peminjaman $context = null): array;
}
