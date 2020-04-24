<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Items;
use App\Http\Services\Bookings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Items $items, Bookings $bookings)
    {
        $this->middleware('auth');

        $this->items = $items;
        $this->bookings = $bookings;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $items = $this->items->byField('user_id', $user->id);

        $bookings = $this->bookings->byField('company_user_id', $user->id);

        $bookingsArray = [];
        foreach ($bookings as $booking) {
            $itemsMap = [];

            if($booking->items()) {
                
                foreach($booking->items() as $item) {
                    $itemsMap[] = "{$item->recorded_name} * {$item->quantity}";
                }
            
            }
        
            $bookingsArray[] = [
                'title' => "{$booking->name}  {$booking->email}  {$booking->information}" . ($itemsMap ? ' *Items* '. implode(", ", $itemsMap) : ''), 
                'start' => $booking->date
            ];
        }

        return view('home', compact('items', 'bookingsArray', 'user'));
    }
}
