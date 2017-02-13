<?php
//written by: Siyuan Zhong
//Asissted by: Jianqin Gao
//Debug by: Wangzhe Chen
    include_once "DataBase.php";
	include_once "query.php";
	date_default_timezone_set('America/New_York');
    class current_sql {
        private $DataBase;
        private $query;
        private $current_URL = "http://download.finance.yahoo.com/d/quotes.csv?s=";
        private $CSV;
        
        public function __construct() {
			$this->DataBase = new DataBase();
			$this->query = new query();
		}
        
        public function get_content($URL) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $URL);
                    $data = curl_exec($ch);
                    curl_close($ch);
                    return $data;
                }	

        //retrieve current price
        public function downloadCurrentPrice($ticker) {
                    //create URL
                    $URL = $this->current_URL.$ticker."&f=l1v";
                    //echo $URL;
                    //return CSV file
                    $this->CSV = $this->get_content($URL);
        }

        public function saveCurrentPrice($stockID,$ticker,$name) {
            
                    $contents = str_getcsv($this->CSV);
                    //print_r ($contents);
                    //connect to database
                    $this->DataBase->connect();
                    // realtime update
                    echo $name;
                    $this->DataBase->prepare($this->query->update_realtime($name));
                    //echo "heoo";
                    //bind values to SQL statement
                    $this->DataBase->bind(1, $stockID);
                    $this->DataBase->bind(2, $ticker);
                    $this->DataBase->bind(3, date("Y/m/d",time()));
                    $this->DataBase->bind(4, date("H:i:s",time()));
                    $this->DataBase->bind(5, $contents[0]);
                    $this->DataBase->bind(6, $contents[1]);
                    $this->DataBase->execute();
                    //disconnect from database
                    $this->DataBase->disconnect();
                }
        
}
?>