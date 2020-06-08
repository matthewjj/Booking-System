<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Items;
use App\Http\Services\Bookings;
use App\Http\Services\Users;
use App\Http\Services\Companies;

use App\Globals\Constants;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Items $items, Bookings $bookings, Users $users, Companies $companies)
    {
        $this->middleware('auth:company');

        $this->items = $items;
        $this->bookings = $bookings;
        $this->users = $users;
        $this->companies = $companies;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // //send customer to appropriate page
        // if($user->type == Constants::TYPE_CUSTOMER) {

        //     $parent = $this->users->rowByField('id', $user->parent_id);

        //     return \Redirect::to("/bookings/customer/{$parent->customer_link}");
        // }
        
        $items = $this->items->byField('user_id', $user->id);

        $bookings = $this->bookings->byField('company_user_id', $user->id);

        $bookingsArray = [];
        foreach ($bookings as $booking) {
            $itemsMap = [];

            if($booking->items()) {
                
                foreach($booking->items() as $item) {
                    $itemsMap[] = "{$item->recorded_name} x {$item->quantity}";
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
    public function show()
    {
        
    }


    public function update(Request $request, $id)
    {

        $fields = $request->get('company');

        $this->companies->update($fields, $id);

        return \Redirect::back()->with('success-message', 'Item Updated');
        
    }


}
