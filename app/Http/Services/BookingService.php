<?php

namespace App\Http\Services;

use App\Database;

class BookingService extends Database
{

	public $sql = null;
	
	function __construct()
	{
		parent::__construct(new \App\Bookings());
		$this->setQueryBase();
	}

	public function setQueryBase() 
	{
		$this->sql = "SELECT * FROM bookings";
	}

	public function create($fields) 
	{
		//TODO
		//ALERT COMPANY
		//CUSTOMER CONFIMATION

		$this->store($fields);
	}


}