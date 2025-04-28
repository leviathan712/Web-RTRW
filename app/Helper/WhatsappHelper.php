<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsappHelper
{
    public static function sendToWhatsapp($phone, $message)
    {
        $token = '2QwGWUJ5j3coUuBRUfAik17UYgxkDltJX3s7BZMgZVccoNlAWSj7xPv'; // Ganti dengan token kamu
        $url = 'https://kirim.pesan.biz/api/v2/send-message';

        // Request ke API Wablas
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post($url, [
            'phone' => $phone,
            'message' => $message,
        ]);

        return $response->json(); // Mengembalikan response dari API
    }
}
