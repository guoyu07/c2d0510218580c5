<?php

class MySql_Query
{
	public $servername = "localhost";
	public $dbname = 'api_flygoldfinch';
	public $username = 'root';
	public $password = 'Goldfinch^1';

	public function Execute($sql, $lastInsertId = TRUE){
		try {
			$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8mb4", $this->username, $this->password);
			$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$lastId = $conn->lastInsertId();
			$count=$stmt->rowCount();
			$data_array = [];

			if ($lastInsertId) {
				$data_array['lastInsertId'] = $lastId;
			};

			if($count>0){
				while($row = $stmt->fetch()) {
					$data_array[] = $row;			
				}
				return $data_array;
			}
			else{
				return FALSE;
			}

			
		}
		
		catch(PDOException $e) {
		  // $Error = 'SQL_ERROR:' . var_dump($e->getMessage());
		  return FALSE;
		}
	}

	public function Row($Sql){
		$Result = $this->Execute($Sql,FALSE);
		$Result = isset($Result[0]) ? $Result[0] : FALSE;
		return $Result;
	}

	function __construct()
	{
	}
}

?>