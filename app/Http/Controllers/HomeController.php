<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Items;
use App\Http\Services\Bookings;
use App\Http\Services\Users;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Items $items, Bookings $bookings, Users $users)
    {
        $this->middleware('auth');

        $this->items = $items;
        $this->bookings = $bookings;
        $this->users = $users;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($link)
    {
        $parent = $this->users->rowByField('customer_link', $link);


        $items = $this->items->byField('user_id', $parent->id);

        $bookings = $this->bookings->byField('company_user_id', $parent->id);

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

        return view('show', compact('items', 'bookingsArray'));

        
    }


}
