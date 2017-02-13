<?php
//Written by: Siyuan Zhong
//Assisted by: Wangzhe Chen
//Debug by: Jianqin Gao
class search{
	public function connect(){
	$conn = @mysql_connect("localhost","se2","may1994");
	if (!$conn){
		die("Failed to connect database£º" . mysql_error());
	}
	$db=mysql_select_db("se2", $conn);
	if(!$db)
	{
		die("Failed to connect to MySQL:". mysql_error());
	}
	}

	public function findhighest($name){
    $date = date('Y-m-d', strtotime("-1year", strtotime(date('Y-m-d'))));
	$query=mysql_query("SELECT MAX(close) FROM {$name}_historical WHERE date>='$date'");
	$highest = mysql_result($query,0);
	return $highest;
	}

	public function findaverage($name){
	$date = date('Y-m-d', strtotime("-1year", strtotime(date('Y-m-d'))));
	$query=mysql_query("SELECT AVG(close) FROM {$name}_historical WHERE date>='$date'");
	$avg = mysql_result($query,0);
	return $avg;
	}

	public function findlowest($name){
    $date = date('Y-m-d', strtotime("-1year", strtotime(date('Y-m-d'))));
	$query=mysql_query("SELECT MIN(close) FROM {$name}_historical WHERE date>='$date'");
	$lowest = mysql_result($query,0);
	return $lowest;
	}
}
?>
