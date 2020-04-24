<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Items;
use App\Http\Services\Bookings;
use App\Http\Services\Users;

class CustomerBookingController extends Controller
{

    public function __construct(Items $items, Bookings $bookings, Users $users)
    {
        //$this->middleware('guest');

        $this->items = $items;
        $this->bookings = $bookings;
        $this->users = $users;
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
        //
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

        
            $bookingsArray[] = [
                'title' => "", 
                'start' => $booking->date
            ];
        }

        return view('customer.bookings.show', compact('items', 'bookingsArray', 'parent'));
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
