<?php

use App\Http\Controllers\Api\Admin\AdminFacilityController;
use App\Http\Controllers\Api\Admin\AdminMapEdgeController;
use App\Http\Controllers\Api\Admin\AdminMapNodeController;
use App\Http\Controllers\Api\Admin\AdminRoomCategoryController;
use App\Http\Controllers\Api\Admin\AdminRoomController;
use App\Http\Controllers\Api\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Api\Admin\HeroController as AdminHeroController;
use App\Http\Controllers\Api\Admin\SchoolProfileController as AdminSchoolProfileController;
use App\Http\Controllers\Api\Public\ChatbotController as PublicChatbotController;
use App\Http\Controllers\Api\Public\GalleryPublicController;
use App\Http\Controllers\Api\Public\HomeController;
use App\Http\Controllers\Api\Public\HeroPublicController;
use App\Http\Controllers\Api\Public\MapPublicController;
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

        // Chatbot AI
        Route::post('/chatbot', [PublicChatbotController::class, 'send']);

        // Interactive Map & Routing
        Route::get('/map/route', [MapPublicController::class, 'route']);
        Route::get('/map/categories', [MapPublicController::class, 'categories']);
        Route::get('/map/nodes', [MapPublicController::class, 'nodes']);

        // Rooms & Facilities
        Route::get('/rooms/search', [RoomPublicController::class, 'search']);
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

        // Rooms CRUD
        Route::get('/rooms', [AdminRoomController::class, 'index']);
        Route::post('/rooms', [AdminRoomController::class, 'store']);
        Route::get('/rooms/{room}', [AdminRoomController::class, 'show']);
        Route::match(['put', 'patch', 'post'], '/rooms/{room}', [AdminRoomController::class, 'update']);
        Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy']);

        // Facilities per Room CRUD
        Route::get('/rooms/{room}/facilities', [AdminFacilityController::class, 'index']);
        Route::post('/rooms/{room}/facilities', [AdminFacilityController::class, 'store']);
        Route::match(['put', 'patch'], '/rooms/{room}/facilities/{facility}', [AdminFacilityController::class, 'update']);
        Route::delete('/rooms/{room}/facilities/{facility}', [AdminFacilityController::class, 'destroy']);

        // Room Categories CRUD
        Route::get('/room-categories', [AdminRoomCategoryController::class, 'index']);
        Route::post('/room-categories', [AdminRoomCategoryController::class, 'store']);
        Route::get('/room-categories/{room_category}', [AdminRoomCategoryController::class, 'show']);
        Route::match(['put', 'patch'], '/room-categories/{room_category}', [AdminRoomCategoryController::class, 'update']);
        Route::delete('/room-categories/{room_category}', [AdminRoomCategoryController::class, 'destroy']);

        // Map Nodes CRUD
        Route::get('/map/nodes', [AdminMapNodeController::class, 'index']);
        Route::post('/map/nodes', [AdminMapNodeController::class, 'store']);
        Route::get('/map/nodes/{node}', [AdminMapNodeController::class, 'show']);
        Route::match(['put', 'patch'], '/map/nodes/{node}', [AdminMapNodeController::class, 'update']);
        Route::delete('/map/nodes/{node}', [AdminMapNodeController::class, 'destroy']);

        // Map Edges CRUD
        Route::get('/map/edges', [AdminMapEdgeController::class, 'index']);
        Route::post('/map/edges', [AdminMapEdgeController::class, 'store']);
        Route::get('/map/edges/{edge}', [AdminMapEdgeController::class, 'show']);
        Route::match(['put', 'patch'], '/map/edges/{edge}', [AdminMapEdgeController::class, 'update']);
        Route::delete('/map/edges/{edge}', [AdminMapEdgeController::class, 'destroy']);
    });
});
