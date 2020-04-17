<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\ItemService;

class ItemController extends Controller
{

    function __construct(ItemService $itemService) {

        $this->middleware('auth');

        $this->itemService = $itemService;
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

        $fields = $request->get('item');
        $fields['user_id'] = $user->id;

        $this->itemService->create($fields);

        return \Redirect::back()->with('success-message', 'Item Added');
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
        $user = auth()->user();

        $itemExists = $this->itemService->query(
            [
                'user_id' => [['=', $user->id]],
                'id' => [['=', $id]],
            ]
        )->results();

        if($itemExists) {
            $this->itemService->delete($id);
        
            return \Redirect::back()->with('success-message', 'Item Removed');
        }


        return \Redirect::back()->with('error-message', 'Oops, something went wrong');

        
    }
}
