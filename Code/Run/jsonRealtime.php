<?php 
//Written by: Siyuan Zhong
//Debug by: Jianqin Gao
//Assisted by: Kaifei Lei
function jsonRealtime(){

date_default_timezone_set('America/New_York');
$con = mysql_connect("localhost","se2","may1994");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("se2", $con);


$sql="SELECT name FROM stocks";
$result=mysql_query($sql);
while ($row=mysql_fetch_assoc($result))
{
    $sql="SELECT Date,Time,Price,Volume FROM {$row['name']}_realtime ORDER BY `Date` DESC,`time` DESC   LIMIT 300";  
    $result2 = mysql_query($sql);   
    if ($result2)
    {
        $fp=fopen("json/Realtime/{$row['name']}_realtime.json","w");
        fwrite($fp,"[");
        for($i=0;$i<300;$i++){
            $row2=mysql_fetch_assoc($result2);
            $year=((int)substr($row2['Date'],0,4));
            $month=((int)substr($row2['Date'],5,2));
            $day=((int)substr($row2['Date'],8,2));
            $hour=((int)substr($row2['Time'],0,2));// hour
            $minute=((int)substr($row2['Time'],3,2));// minute
            $second=((int)substr($row2['Time'],6,2));//second
            $Utime=mktime($hour,$minute,$second,$month,$day,$year);
            $Utime=((int)strval($Utime)-4*3600);
            $Utime=$Utime;
            $Utime=((string)intval($Utime))."000";
            $str="[".$Utime.",".$row2['Price'].",".$row2['Price'].",".$row2['Price']."],";
            if($i==299)
                $str="[".$Utime.",".$row2['Price'].",".$row2['Price'].",".$row2['Price']."]";
            fwrite($fp,$str);
            fwrite($fp,"\n");
        }
		fwrite($fp,']');				
        fclose($fp);
    }   
	
}
    


mysql_close($con);
    
}
  
?>  