<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\ItemService;
use App\Http\Services\BookingService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemService $itemService, BookingService $bookingService)
    {
        $this->middleware('auth');

        $this->itemService = $itemService;
        $this->bookingService = $bookingService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $items = $this->itemService->byField('user_id', $user->id)->results();

        $bookings = $this->bookingService->byField('company_user_id', $user->id)->toJson(['title' => ['name', 'email', 'information'], 'start' => ['date'] ]);

        return view('home', compact('items', 'bookings'));
    }
}
