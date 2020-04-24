<?php

namespace App\Http\Services;

use App\Database;
use App\Http\Services\Items;

class Users extends Database
{

	public $sql = null;
	
	function __construct()
	{
		parent::__construct(new \App\User());
		$this->setQueryBase();

	}

	public function setQueryBase() 
	{
		$this->sql = "SELECT * FROM users";
	}


}