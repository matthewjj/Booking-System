<?php

namespace App\Http\Services;

use App\Database;

use App\Http\Services\Items;

class BookingItems extends Database
{

	public $sql = null;
	
	function __construct()
	{
		parent::__construct(new \App\BookingItems());
		$this->setQueryBase();
	
		$this->items = new Items();
	}

	public function setQueryBase() 
	{
		$this->sql = "SELECT * FROM booking_items";
	}

	public function create($fields) 
	{

		$this->store($fields);

		//get item
		$item = $this->items->rowByField('id', $fields['item_id']);

		//decrement count by quantity used
		$this->items->update(
			[
				'quantity' => $item->quantity - $fields['quantity']
			], 
			$item->id
		);
	}


	public function item() {

		return $this->items->rowByField('id', $this->item_id);

	}

}