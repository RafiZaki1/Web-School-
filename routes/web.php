<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/denah', [HomeController::class, 'denah'])->name('denah');
Route::post('/chatbot/send', [\App\Http\Controllers\Api\Public\ChatbotController::class, 'send'])->name('chatbot.send');

https://127.0.0.1:50142/static/artifacts/4b4156fe-b62f-474e-a9a2-737ae5e556cc/.user_uploaded/media_1787985147215.png?csrf=44398169-70a8-4301-99dd-f1318f769d43