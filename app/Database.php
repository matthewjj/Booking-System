<?php

namespace App;

use DB;
use App\Http\Collections\Collection;

class Database extends Collection
{
	public $connection = 'mysql';

	//private $queryResults = null;
	public $where;
	public $params = [];
	
	function __construct($table)
	{
		$this->table = $table;	
	}

	public function store($fields) 
	{
		$table = new $this->table;

		foreach ($fields as $field => $value) 
		{
			$table->{$field} = $value;

		}
		
		$table->save();
		return $table;
	}

	public function update($fields, $id) 
	{
		$row = $this->table::where('id', $id)->first();

		foreach ($fields as $field => $value) 
		{
			$row->{$field} = $value;

		}
		
		$row->save();
		return $row;
	}

	public function delete($id) 
	{

		try {

			$row = $this->table::where('id', $id)->delete();

			return true;

		}
		catch(\Exception $e) {
			return false;
		}

	}

	public function byField($field, $value) 
	{
		$this->buildWhere(
			[
				$field => [['=', $value]] 
			]
		);

		return $this->fire();
	}

	public function rowByField($field, $value) 
	{
		$this->buildWhere(
			[
				$field => [['=', $value]] 
			]
		);

		$fire = $this->fire();

		return isset($fire[0]) ? $fire[0] : null;
	}

	public function query($conditions) 
	{

		$this->buildWhere($conditions);

		return $this->fire();
	}

	// 


	// public function byKey($key) 
	// {
	// 	$newArray = [];
	// 	foreach($this->queryResults as $result) {
	// 		$newArray[$result->{$key}] = $result;
	// 	}
	// 	return $newArray;
	// }

	private function buildWhere($where) 
	{

		foreach ($where as $key => $values) {

			foreach ($values as $value) {

				$addParam = true;

				switch ($value[0]) {
					case '=':
						$buildWhere[] = "AND {$key} = ?";
						break;

					case '!=':
						$buildWhere[] = "AND {$key} != ?";
						break;

					case '<':
						$buildWhere[] = "AND {$key} < ?";
						break;

					case '>':
						$buildWhere[] = "AND {$key} > ?";
						break;

					case '<=':
						$buildWhere[] = "AND {$key} <= ?";
						break;

					case '>=':
						$buildWhere[] = "AND {$key} >= ?";
						break;

					case 'IS NOT NULL':
						$buildWhere[] = "AND {$key} IS NOT NULL";

						$addParam = false;
						break;

					case 'IS NULL':
						$buildWhere[] = "AND {$key} IS NULL";

						$addParam = false;
						break;

					case 'LIKE':
						$buildWhere[] = "AND {$key} LIKE ?";

						$this->params[] = "%{$value[1]}%";

						$addParam = false;

						break;

					case 'NOT LIKE':
						$buildWhere[] = "AND {$key} NOT LIKE ?";

						$this->params[] = "%{$value[1]}%";

						$addParam = false;

						break;

					case 'IN':
						
						foreach($value[1] as $in) {
							$this->params[] = $in;
						}

						$arr = array_map(function ($e) { return "?";}, range(1, count($value[1])));
						$buildWhere[] = "AND {$key} IN (" . implode(',', $arr) . ")";

						$addParam = false;
						
						break;

					case 'NOT IN':
						
						foreach($value[1] as $in) {
							$this->params[] = $in;
						}

						$arr = array_map(function ($e) { return "?";}, range(1, count($value[1])));
						$buildWhere[] = "AND {$key} NOT IN (" . implode(',', $arr) . ")";

						$addParam = false;
						
						break;
					
					case 'CUSTOM':

						$buildWhere[] = $value[1];
						$addParam = false;

						break;

					default:
						$addParam = false;

						throw new \Exception("Query type `{$value[0]}` not recognized, may need adding", 1);
						break;
				}


				if($addParam) {
					$this->params[] = $value[1];

				}

			}

		}
		
		$this->where = "\r\n" . implode("\r\n", $buildWhere);

	}

	public function fire() 
	{

		//1 = 1 to set the where off
		$query = "{$this->sql} WHERE 1 = 1 {$this->where}";

		$fire = $this->newQuery($query, $this->params);

		//reset here ready for the next query
		$this->resetQuery();

		//$this->queryResults = $fire;
		
		return $this->map($fire);
	}

	public function resetQuery() {
		$this->params = [];
		$this->where = null;
	}

	public function newQuery($sql, $params) 
	{

		return DB::connection($this->connection)->select($sql, $params);

	}

	// public function toJson($map) {

	// 	$newArray = [];
	// 	foreach($this->queryResults as $result) {

	// 		$innerArray = [];

	// 		foreach ($map as $jsonName => $sqlNames) {
	// 			$concatable = [];
	// 			foreach ($sqlNames as $sqlName) {
	// 				$concatable[] = $result->{$sqlName};

	// 			}

	// 			$innerArray[$jsonName] = implode(' ', $concatable);
	// 		}

	// 		$newArray[] = $innerArray;
	// 	}
	// 	return json_encode($newArray);
	// }

	


}