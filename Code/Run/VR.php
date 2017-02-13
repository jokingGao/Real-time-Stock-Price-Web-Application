<?php
//Written by: Siyuan Zhong
//Debug by: Jianqin Gao
//Assisted by: Wangzhe Chen

class VR{
	public function CalculateVR($name){
	$conn = @mysql_connect("localhost","se2","may1994");
	if (!$conn){
		die("Failed to connect database£º" . mysql_error());
	}
	$db=mysql_select_db("se2", $conn);
	if(!$db)
	{
		die("Failed to connect to MySQL:". mysql_error());
	}
	$data=mysql_query("SELECT open,close,volume FROM {$name}_historical ORDER BY `date` DESC LIMIT 24");
	$AVS=$BVS=$CVS=0;
	while($day=mysql_fetch_assoc($data))
	{
		if ($day['close']>$day['open']) $AVS=$AVS+$day['volume'];
		if ($day['close']<$day['open']) $BVS=$BVS+$day['volume'];
		if ($day['close']==$day['open']) $CVS=$CVS+$day['volume'];
	}
	$VR=($AVS+0.5*$CVS)/($BVS+0.5*$CVS);
	return $VR;
	}
	public function Analysis($index){
		if ($index<0.7) echo "It's very likely to form a bottom. Suggestion: BUY.";
		if ($index>=0.7 && $index<1.5) echo " It's safe to buy or to sell. Suggestion: HOLD OR SIT OUT.";
		if ($index>=1.5) echo "It's very likely to form a top. Suggestion: SELL."; 
	}
}
?>
