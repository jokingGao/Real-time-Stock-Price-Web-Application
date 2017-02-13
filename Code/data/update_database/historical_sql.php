<?php
//written by: Siyuan Zhong
//Asissted by: Jianqin Gao
//Debug by: Wangzhe Chen
	include_once "DataBase.php";
	include_once "query.php";
	date_default_timezone_set('America/New_York');
	class historical_sql {
        private $DataBase;
        private $query;
		//use yahoo finace api to get the historical and current data
		private $historical_URL = "http://ichart.yahoo.com/table.csv?s=";
		private $CSV;
        
        public function __construct() {
			$this->DataBase = new DataBase();
			$this->query = new query();
		}

		//get file from outside URL
		public function get_content($URL) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $URL);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}	
		
        //get the historical price from the download file, you need to supply ticker, startDate, endDate
		public function downloadHistorical($ticker, $startDate, $endDate) {
			//parse start date to y/m/d
			$start_date_ymd = explode("/", $startDate);
			//parse end date to y/m/d
			$end_date_ymd = explode("-", $endDate);
			//create URL
			$URL = $this->historical_URL.$ticker."&a=".($start_date_ymd[1] - 1)."&b=".$start_date_ymd[2]."&c=".$start_date_ymd[0]."&d=".($end_date_ymd[1] - 1)."&e=".$end_date_ymd[2]."&f=".$end_date_ymd[0];
			//get CSV file
			$this->CSV = $this->get_content($URL);
            //return $this->get_content($URL);
		}	
		
        //use the content from the CSV file
		public function saveHistorical($stockID,$ticker,$name) {			
			//ignore first line of CSV file
			$isFirst = true;
			//parse CSV file into lines
			$sourceLines = str_getcsv($this->CSV, "\n");
			//connect to database
			$this->DataBase->connect();
			//prepare insertion statement
			$this->DataBase->prepare($this->query->insert_historical($name));
			//for each line
			foreach($sourceLines as $line) {
				//parse contents of each line into an array
				$contents = str_getcsv( $line );
				//skip first line
				if ($isFirst) {
					$isFirst = false;
					continue;
				}				
				//bind necessary values to SQL statement
				$this->DataBase->bind(1, $stockID);
                $this->DataBase->bind(2, $ticker);
				$this->DataBase->bind(3, $contents[0]);
				$this->DataBase->bind(4, $contents[1]);
				$this->DataBase->bind(5, $contents[2]);
				$this->DataBase->bind(6, $contents[3]);
				$this->DataBase->bind(7, $contents[4]);
				$this->DataBase->bind(8, $contents[5]);			
				//execute query
				$this->DataBase->execute();
			}
			//disconnect from databases
			$this->DataBase->disconnect();
		}
        
	}
	
	?>