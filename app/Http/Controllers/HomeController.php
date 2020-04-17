<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\ItemService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemService $itemService)
    {
        $this->middleware('auth');

        $this->itemService = $itemService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $items = $this->itemService->byField('user_id', $user->id);

        return view('home', compact('items'));
    }
}
