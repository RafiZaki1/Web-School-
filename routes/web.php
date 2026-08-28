<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chatbot/send', [\App\Http\Controllers\Api\Public\ChatbotController::class, 'send'])->name('chatbot.send');

