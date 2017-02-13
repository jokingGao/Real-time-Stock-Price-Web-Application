<?php
//written by: Siyuan Zhong
//Asissted by: Jianqin Gao
//Debug by: Wangzhe Chen
	include_once 'DataBase.php';
	include_once 'query.php';
	include_once 'current_sql.php';
	set_time_limit(0);
	ignore_user_abort(false);
	//instantiate necessary objects
	$DataBase = new DataBase();
	$query = new query();
	$current_sql = new current_sql();
	//conect to database
	$DataBase->connect();
	//get stockID , ticker and  of all stocks
	$DataBase->prepare($query->get_stockID_ticker_name());
	$results = $DataBase->resultset();
	//disconnect from database
	$DataBase->disconnect();
	// every 50s update data
	while (true){		
		//for each stocks
		foreach ($results as $stock) {
			//download current price
			$current_sql->downloadCurrentPrice($stock['Ticker']);
			//save current price
			$current_sql->saveCurrentPrice( $stock['StockID'],$stock['Ticker'],$stock['name']);
            echo "1";
		}
		usleep(50000000);
	};
	
?>