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
	}


	public function item() {

		return $this->items->rowByField('id', $this->item_id);

	}

}