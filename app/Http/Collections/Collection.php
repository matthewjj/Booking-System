<?php

namespace App\Http\Collections;

class Collection {

	public $collection;

	public function __construct() {
		$this->map();
	}


	public function map($results) {

		$map = [];
		foreach($results as $row) {

			//$this->fields = $row;

			$child = new $this;

			foreach ($row as $key => $value) {
				$child->{$key} = $value;
			}

			$map[] = $child;
		}

		return $map;
	}



}