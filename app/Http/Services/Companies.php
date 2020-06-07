<?php

namespace App\Http\Services;

use App\Database;
use App\Http\Services\Items;

class Companies extends Database
{

	public $sql = null;
	
	function __construct()
	{
		parent::__construct(new \App\Company());
		$this->setQueryBase();

	}

	public function setQueryBase() 
	{
		$this->sql = "SELECT * FROM companies";
	}


}