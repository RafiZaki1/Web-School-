<?php

namespace App\Http\Controllers\Api\Public;

use App\Contracts\Interfaces\ChatbotServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ChatbotController extends Controller
{
    public function __construct(
        protected ChatbotServiceInterface $chatbotService
    ) {}

    /**
     * Send message to Chatbot.
     */
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
            'history.*.role' => 'nullable|string|in:user,bot,model,assistant',
            'history.*.content' => 'nullable|string|max:2000',
        ]);

        try {
            $message = $validated['message'];
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
