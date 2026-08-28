<?php

namespace App\Contracts\Interfaces;

interface ChatbotServiceInterface
{
    /**
     * Send a user message to the AI chatbot and get a reply.
     *
     * @param string $message
     * @param array $history
     * @return array
     */
    public function sendMessage(string $message, array $history = []): array;
}
