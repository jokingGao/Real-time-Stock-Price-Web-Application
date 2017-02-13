
<?php
//Written by: Siyuan Zhong
//Assisted by: Kaifei Lei
//Debug by: Jianqin Gao

function KDJfunction($StockName){

// get data from database	
$conn = @mysql_connect("localhost","se2","may1994");
if (!$conn){
    die("Fail to connect database：" . mysql_error());
} else {
    
}
mysql_select_db("se2", $conn);	

//select the closing price of the latest day 
$sql = "SELECT close FROM {$StockName}_historical LIMIT 1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$C=mysql_result($query,0);

//select  the latest day 
$sql = "SELECT date FROM {$StockName}_historical LIMIT 1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d1=mysql_result($query,0);

//select the last 9th day
$sql = "SELECT date FROM {$StockName}_historical LIMIT 8,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d9=mysql_result($query,0);

//select the highest price during the last 9 days
$sql = "SELECT MAX(close) FROM {$StockName}_historical WHERE date>='$d9'";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$H9=mysql_result($query,0);

//select the lowest price during the last 9 days
$sql = "SELECT MIN(close) FROM {$StockName}_historical WHERE date>='$d9'";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$L9=mysql_result($query,0);

//set K8 value
$sql = "SELECT K FROM {$StockName}_historical LIMIT 7,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$D8=mysql_result($query,0);
//set D8 value
$sql = "SELECT D FROM {$StockName}_historical LIMIT 7,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$K8=mysql_result($query,0);
//caculate RSV9
$RSV9=($C-$L9)/($H9-$L9)*100;
//calculate K9
$K9=2/3*$K8+1/3*$RSV9;
//calculate D9
$D9=2/3*$D8+1/3*$K9;
//calculate J9
$J9=3*$K9-2*$D9;
//update the D9 and K9 value
$sql = "UPDATE {$StockName}_historical SET D={$D9}, K={$K9}, J={$J9} WHERE date='{$d1}'";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());


echo "RSV= ",$RSV9,"<br>";
echo "K = ",$K9,"<br>";
echo "D = ",$D9,"<br>";
echo "J = ",$J9,"<br>";

if ($K9<20&&$D9<20&&$J9<20){
	echo "It's a Oversold Zone, Suggestion: BUY! ";
}else if ($K9>80&&$D9>80&&$J9>80){
	echo "It's a Overbought Area, Suggestion: SELL! ";
}else if ((20<=$K9)&&($K9<=80)&&(20<=$D9)&&($D9<=80)&&(20<=$J9)&&($J9<=80)){
	echo "It's a Trade Balance Area, Suggestion: HOLD or SITOUT! ";
}else echo "Unable to give suggestion. Suggestion: NONE";
}
?>
