<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Bookings;
use App\Http\Services\BookingItems;
use App\Http\Services\Items;


class BookingController extends Controller
{
    function __construct(Bookings $bookings, BookingItems $bookingItems, Items $items) {

        $this->middleware('auth:company');

        $this->bookings = $bookings;
        $this->bookingItems = $bookingItems;
        $this->items = $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();


        $fields = $request->get('booking');

        //manual override these fields to ensure correct booking allocation
        $fields['user_id'] = $fields['company_user_id'] = $user->id;  

        $booking = $this->bookings->create($fields);

        if($request->has('items')) {

            foreach ($request->get('items') as $id => $value) {
            
                //find name of item for recording
                $item = $this->items->rowByField('id', $id);

                $this->bookingItems->create(
                    [
                        'item_id' => $id,
                        'quantity' => $request->has("items_quantity") && 
                            isset($request->get("items_quantity")[$id]) ? $request->get("items_quantity")[$id] : 0,
                        'booking_id' => $booking->id,
                        'recorded_name' => $item->name
                    ]
                );
            }
        
        }

        return \Redirect::back()->with('success-message', 'Booking Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
