<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TelegramNotification
{
    public function send($message): void
    {
        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (empty($botToken)) {
            Log::warning('[TelegramNotification] BOT_TOKEN is not set in config');
            return;
        }

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        try {
            $response = Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($response->failed()) {
                Log::error('[TelegramNotification] Failed to send message', [
                    'chat_id' => $chatId,
                    'response' => $response->body(),
                ]);
            } else {
                Log::info('[TelegramNotification] Message sent successfully', [
                    'chat_id' => $chatId,
                    'message' => $message,
                ]);
            }
        } catch (Exception $e) {
            Log::error('[TelegramNotification] Exception occurred while sending message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}
