<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\BookingService;
use App\Http\Services\BookingItemSservice;

class BookingController extends Controller
{
    function __construct(BookingService $bookingService, BookingItemsService $bookingItemsService) {

        $this->middleware('auth');

        $this->bookingService = $bookingService;
        $this->bookingItemsService = $bookingItemsService;
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
        $fields['user_id'] = $user->id;

        $booking = $this->bookingService->create($fields);

        if($request->has('items_quantity')) {

            foreach ($request->get('items') as $id => $value) {
            
                $this->bookingItemsService->create(
                    [
                        'item_id' => $id,
                        'quantity' => $request->has("items_quantity") && 
                            isset($request->get("items_quantity")[$id]) ? $request->get("items_quantity")[$id] : 0,
                        'booking_id' => $booking->id
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
