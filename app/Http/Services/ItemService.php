<?php

namespace App\Http\Services;

use App\Database;

class ItemService extends Database
{

	public $sql = null;
	
	function __construct()
	{
		parent::__construct(new \App\Items());
		$this->setQueryBase();
	}

	public function setQueryBase() 
	{
		$this->sql = "SELECT * FROM Items";
	}

	public function create($fields) 
	{
		$this->store($fields);
	}


}