<?php
//written by: Siyuan Zhong
//Asissted by: Jianqin Gao
//Debug by: Wangzhe Chen
	include_once 'DataBase.php';
	include_once 'query.php';
	include_once 'historical_sql.php';
	//set time zone
	date_default_timezone_set('America/New_York');
	//instantiate necessary objects
	$DataBase = new DataBase();
	$query = new query();
	$historical_sql = new historical_sql();
	
	//connect to database
	$DataBase->connect();
 	//get last date of historical prices for every stock
    //$last_date = "2015-2-23";
    $DataBase->prepare($query->get_last_date());
	$date = $DataBase->resultSet();    
	$last_date=$date[0]['recentDate'];
    // get stock id, ticker and name
	$DataBase->prepare($query->get_stockID_ticker_name());
	$results = $DataBase->resultset();
	//for each stock
	foreach ($results as $stock) {
        
		//if the most recent date does not equal todays date
		if ($last_date != date('Y-m-d', strtotime("-1day", strtotime(date('Y-m-d'))))) {
			//startdate from last date
			$startDate = date('Y/m/d',strtotime("+1day",strtotime($last_date)));
            //echo strtotime("+1day", $last_date('Y-m-d'));
			//$startDate = date("Y/m/d", $startDate);
			//download historical prices
			$historical_sql->downloadHistorical($stock['Ticker'], $startDate, date('Y-m-d'));
            
			//save historical prices
			$historical_sql->saveHistorical(
                $stock['StockID'],$stock['Ticker'],$stock['name']);
		}
	}
	//disconnect from database
	$DataBase->disconnect();
?>