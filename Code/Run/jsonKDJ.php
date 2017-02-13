<?php  
//Written by: Siyuan Zhong
//Assisted by: Kaifei Lei
//Debug by: Jianqin Gao
function jsonKDJ(){

$con = mysql_connect("localhost","se2","may1994");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("se2", $con);

$sql="SELECT name FROM stocks";
$result=mysql_query($sql);
while ($name=mysql_fetch_assoc($result)){
$sql="SELECT date,K,D,J FROM {$name['name']}_historical ORDER BY `date` DESC";  
$result2 = mysql_query($sql);   
if ($result2)
{
    $i=0; 
	$kfp=fopen("json/KDJ/{$name['name']}_k.json","w");
	$dfp=fopen("json/KDJ/{$name['name']}_d.json","w");
	$jfp=fopen("json/KDJ/{$name['name']}_j.json","w");
	fwrite($kfp,"[");
	fwrite($dfp,"[");
	fwrite($jfp,"[");
    for ($i=0;$i<9;$i++){ 
		$row=mysql_fetch_assoc($result2);
		$year=((int)substr($row['date'],0,4));
		$month=((int)substr($row['date'],5,2));
		$day=((int)substr($row['date'],8,2));
		$row['date']=mktime(0,0,0,$month,$day,$year)."000";
		if ($i!=8) 
		{
			$str1="[".$row['date'].",".$row['K']."],";
			$str2="[".$row['date'].",".$row['D']."],";
			$str3="[".$row['date'].",".$row['J']."],";
		}
		else  
		{	
			$str1="[".$row['date'].",".$row['K']."]";
			$str2="[".$row['date'].",".$row['D']."]";
			$str3="[".$row['date'].",".$row['J']."]";
		}
		    fwrite($kfp,$str1);
			fwrite($dfp,$str2);
			fwrite($jfp,$str3);
			fwrite($kfp,"\n");
			fwrite($dfp,"\n");
			fwrite($jfp,"\n");
		

    } 
	fwrite($kfp,']');
			fwrite($dfp,']');
			fwrite($jfp,']');
			fclose($kfp);
			fclose($dfp);
			fclose($jfp);
	        
}
   
}  
    /*  
  
    $row=mysql_fetch_row($result,MYSQL_ASSOC);  
      
    echo json_encode(array('jsonObj'=>$row));  */


mysql_close($con);

}
?>  