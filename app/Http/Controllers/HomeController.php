<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\HomeServiceInterface;
use App\Contracts\Interfaces\RoomServiceInterface;
use Illuminate\View\View;
use Throwable;

class HomeController extends Controller
{
    public function __construct(
        protected HomeServiceInterface $homeService,
        protected RoomServiceInterface $roomService,
    ) {}

    public function index(): View
    {
        try {
            return view('home', [
                'home' => $this->homeService->getHomeData(),
                'rooms' => $this->roomService->getActiveRooms(),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            abort(500, 'Gagal memuat halaman utama.');
        }
    }
}