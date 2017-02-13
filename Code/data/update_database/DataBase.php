<?php
//written by: Siyuan Zhong
//Asissted by: Jianqin Gao
//Debug by: Wangzhe Chen
	class DataBase {
		private $connection; //database connection
		private $tempdata; //store the temp data
		
		//necessary credentials
		private $host = "localhost";
		private $user = "se2";
		private $password = "may1994";
		private $db = "se2";
				
		//connect to database
		public function connect() {
			$this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8', $this->user, $this->password);
			//turn on errors and exceptions
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		
		//prepare a tempdata (prevents SQL injection) where $query is the sql query
		public function prepare($query) {
			$this->tempdata = $this->connection->prepare($query);
		}
		
		//bind values to prepared tempdata where:
		//$param is a parameter of the tempdata
		//$value is the corresponding value
		//$type is the data type of the value
		public function bind($param, $value, $type = null) {
			//set type
			if (is_null($type)) {
				switch (true) {
					case is_int($value):
						$type = PDO::PARAM_INT; //integer
						break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL; //bool
						break;
					case is_null($value):
						$type = PDO::PARAM_NULL; //null
						break;
					default:
						$type = PDO::PARAM_STR; //string
				}
			}
			
			//bind tempdata
			$this->tempdata->bindValue($param, $value, $type);
		}
		
		//execute query
		public function execute(){
			try {
				return $this->tempdata->execute();
			}
			catch(PDOException $ex) {
				echo "An Error occured! ".$ex->getMessage(); //user friendly error message
			}
		}
		
		//get results
		public function resultset(){
			$this->execute();
			return $this->tempdata->fetchAll(PDO::FETCH_ASSOC);
		}
		
		//disconnect from database
		public function disconnect() {
			$this->connection = null;
		}
	}
?>