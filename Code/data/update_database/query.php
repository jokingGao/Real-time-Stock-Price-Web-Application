<?php
//written by: Siyuan Zhong
//Asissted by: Jianqin Gao
//Debug by: Wangzhe Chen
	class query {
		
		//insert into the historical prices table
		public function insert_historical($name) {
			return "INSERT INTO {$name}_historical (StockID, Ticker, Date, Open, High, Low, Close, Volume) VALUES (?, ?, STR_TO_DATE(?,'%Y-%m-%d'), ?, ?, ?, ?, ?)";
		}
		
		//get all stockIDs and tickers
		public function get_stockID_ticker_name() {
			return "SELECT StockID,Ticker, name FROM stocks";
		}
		
        //get last insert date for a given stockID
		public function get_last_date() {
			return "SELECT  MAX(Date) AS recentDate from facebook_historical GROUP BY StockID";
		}
		
		public function update_realtime($name) {
			return "INSERT INTO {$name}_realtime (stockID,Ticker, date, time, price, volume) VALUES (?, ?, ?, ?, ?, ?)";
		}

	}
?>