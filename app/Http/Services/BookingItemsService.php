<?php

namespace App\Http\Services;

use App\Database;

class BookingItemsService extends Database
{

	public $sql = null;
	
	function __construct()
	{
		parent::__construct(new \App\BookingItems());
		$this->setQueryBase();
	}

	public function setQueryBase() 
	{
		$this->sql = "SELECT * FROM booking_items";
	}

	public function create($fields) 
	{

		$this->store($fields);
	}


}