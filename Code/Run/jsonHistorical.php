<?php  
//Written by: Siyuan Zhong
//Assisted by: Kaifei Lei
//Debug by: Jianqin Gao
function jsonHistorical(){

$con = mysql_connect("localhost","se2","may1994");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("se2", $con);

$sql="SELECT name FROM stocks";
$result=mysql_query($sql);
while ($name=mysql_fetch_assoc($result)){
$sql="SELECT date,open,high,low,close,volume FROM {$name['name']}_historical ORDER BY `date` ASC";  
$countt=mysql_query("SELECT count(*) FROM {$name['name']}_historical ORDER BY `date` ASC");
$countt=mysql_fetch_assoc($countt);
//echo $countt['count(*)'];
$result2 = mysql_query($sql);   
if ($result2)
{
    $i=0; 
	$fp=fopen("json/Historical/{$name['name']}.json","w");
	fwrite($fp,"[");
    for ($i=0;$i<$countt['count(*)'];$i++){ 
		$row=mysql_fetch_assoc($result2);
		$year=((int)substr($row['date'],0,4));
		$month=((int)substr($row['date'],5,2));
		$day=((int)substr($row['date'],8,2));
			$row['date']=mktime(0,0,0,$month,$day,$year).'000';
		$str="[".$row['date'].",".$row['open'].",".$row['high'].",".$row['low'].",".$row['close'].",".$row['volume']."],";
		if ($i!=$countt['count(*)']-1) $str="[".$row['date'].",".$row['open'].",".$row['high'].",".$row['low'].",".$row['close'].",".$row['volume']."],";
		else  $str="[".$row['date'].",".$row['open'].",".$row['high'].",".$row['low'].",".$row['close'].",".$row['volume']."]";
			fwrite($fp,$str);
			fwrite($fp,"\n");
    } 
	        
}
   
  fwrite($fp,']');
fclose($fp);
    /*  
  
    $row=mysql_fetch_row($result,MYSQL_ASSOC);  
      
    echo json_encode(array('jsonObj'=>$row));  */
}   

mysql_close($con);

}
?>  