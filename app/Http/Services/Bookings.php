<?php

namespace App\Http\Services;

use App\Database;

use App\Http\Services\BookingItems;

class Bookings extends Database
{

	public $sql = null;

	//private 
	
	function __construct()
	{
		parent::__construct(new \App\Bookings());
		$this->setQueryBase();
		
		$this->bookingItems = new BookingItems();
	}

	public function setQueryBase() 
	{
		$this->sql = <<<SQL
			SELECT b.*, c.company_name
			FROM bookings b
			JOIN companies c ON b.company_user_id = c.id 

SQL;
	}

	public function create($fields) 
	{
		//TODO
		//ALERT COMPANY
		//CUSTOMER CONFIMATION

		return $this->store($fields);
	}

	public function items() {

		return $this->bookingItems->byField('booking_id', $this->id);

	}


}