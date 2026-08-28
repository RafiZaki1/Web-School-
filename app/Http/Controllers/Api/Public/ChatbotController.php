<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\Interfaces\ChatbotServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ChatbotController extends Controller
{
    public function __construct(
        protected ChatbotServiceInterface $chatbotService
    ) {}

    /**
     * Send message to Chatbot with multi-layer anti-spam security.
     */
    public function send(Request $request): JsonResponse
    {
        // 1. Layer 1 Anti-Bot: Honeypot Trap Check
        if (!empty($request->input('sada_security_code'))) {
            // Silently reject automated bot bots
            return ApiResponse::error(
                'Permintaan tidak valid terdeteksi.',
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // 2. Layer 2 Anti-Spam: Rate Limiter per IP (Max 12 requests per minute)
        $ip = $request->ip() ?? 'unknown';
        $rateLimitKey = 'chatbot_ip:' . $ip;
        $maxAttempts = 12;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($rateLimitKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return ApiResponse::error(
                "Aktivitas terlalu cepat. Harap tunggu {$seconds} detik sebelum mengirim pesan lagi.",
                ['retry_after' => $seconds],
                Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        $validated = $request->validate([
            'message' => 'required|string|min:2|max:500',
            'history' => 'nullable|array',
            'history.*.role' => 'nullable|string|in:user,bot,model,assistant',
            'history.*.content' => 'nullable|string|max:2000',
        ]);

        $message = trim($validated['message']);

        // 3. Layer 3 Anti-Spam: Duplicate Message Check within 30 seconds per IP
        $hashKey = 'chatbot_msg_hash:' . md5($ip . '_' . strtolower($message));
        if (Cache::has($hashKey)) {
            return ApiResponse::error(
                'Pertanyaan yang sama baru saja diajukan. Mohon variasikan pertanyaan Anda atau tunggu sejenak.',
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // 4. Layer 4 Anti-Spam: Gibberish & Character Flooding Check (e.g. aaaaaa, 111111)
        if (preg_match('/(.)\1{9,}/u', $message)) {
            return ApiResponse::error(
                'Pesan mengandung karakter berulang yang tidak wajar. Mohon tuliskan pertanyaan yang jelas.',
                null,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // Hit Rate Limiter & Cache last message hash for 30s
        RateLimiter::hit($rateLimitKey, $decaySeconds);
        Cache::put($hashKey, true, 30);

        try {
            $history = $validated['history'] ?? [];
            $result = $this->chatbotService->sendMessage($message, $history);

            return ApiResponse::success(
                $result,
                'Chatbot response received successfully'
            );
        } catch (Throwable $th) {
            return ApiResponse::error(
                'Gagal memproses pesan: ' . $th->getMessage(),
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
