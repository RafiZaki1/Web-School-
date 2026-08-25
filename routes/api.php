<?php

use App\Http\Controllers\Api\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Api\Admin\HeroController as AdminHeroController;
use App\Http\Controllers\Api\Admin\SchoolProfileController as AdminSchoolProfileController;
use App\Http\Controllers\Api\Public\GalleryPublicController;
use App\Http\Controllers\Api\Public\HomeController;
use App\Http\Controllers\Api\Public\HeroPublicController;
use App\Http\Controllers\Api\Public\RoomPublicController;
use App\Http\Controllers\Api\Public\SchoolProfilePublicController;
use App\Http\Controllers\Api\Public\StatisticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    // ==========================================
    // PUBLIC ROUTES
    // ==========================================
    Route::prefix('public')->group(function () {
        Route::get('/home', [HomeController::class, 'index']);
        Route::get('/statistics', [StatisticController::class, 'index']);
        Route::get('/heroes', [HeroPublicController::class, 'index']);
        Route::get('/galleries', [GalleryPublicController::class, 'index']);
        Route::get('/school-profile', [SchoolProfilePublicController::class, 'show']);

        // Rooms & Interactive Floor Plan
        Route::get('/rooms', [RoomPublicController::class, 'index']);
        Route::get('/rooms/{room}', [RoomPublicController::class, 'show']);
        Route::get('/rooms/{room}/facilities', [RoomPublicController::class, 'facilities']);
    });

    // ==========================================
    // ADMIN ROUTES
    // ==========================================
    Route::prefix('admin')->middleware('auth')->group(function () {
        // Heroes
        Route::get('/heroes', [AdminHeroController::class, 'index']);
        Route::post('/heroes', [AdminHeroController::class, 'store']);
        Route::get('/heroes/{id}', [AdminHeroController::class, 'show']);
        Route::match(['put', 'patch', 'post'], '/heroes/{id}', [AdminHeroController::class, 'update']);
        Route::delete('/heroes/{id}', [AdminHeroController::class, 'destroy']);

        // Galleries
        Route::get('/galleries', [AdminGalleryController::class, 'index']);
        Route::post('/galleries', [AdminGalleryController::class, 'store']);
        Route::get('/galleries/{id}', [AdminGalleryController::class, 'show']);
        Route::match(['put', 'patch', 'post'], '/galleries/{id}', [AdminGalleryController::class, 'update']);
        Route::delete('/galleries/{id}', [AdminGalleryController::class, 'destroy']);

        // School Profile
        Route::get('/school-profile', [AdminSchoolProfileController::class, 'show']);
        Route::match(['put', 'patch', 'post'], '/school-profile', [AdminSchoolProfileController::class, 'update']);
    });
});
