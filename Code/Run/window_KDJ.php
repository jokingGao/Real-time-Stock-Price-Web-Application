<?php 
//Written by: Siyuan Zhong
//Assisted by: Wangzhe Chen
//Debug by: Jianqin Gao
session_start();
include_once 'VR.php';
$stockname=$_SESSION["stockname"];

include_once 'jsonKDJ.php';
jsonKDJ();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highstock Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
<?php
function VRfunction($stockname){
	$VR=new VR();
	$VRpridiction=$VR->CalculateVR($stockname);
	echo "The VR is ",$VRpridiction,"</br>";
	$VR->Analysis($VRpridiction);
	echo "</br></br>";
}
function KDJfunction($StockName){

// get data from database	
$conn = @mysql_connect("localhost","se2","may1994");
if (!$conn){
    die("Fail to connect database：" . mysql_error());
} else {
    
}
mysql_select_db("se2", $conn);	

//select the closing price of the latest day 
$sql = "SELECT close FROM {$StockName}_historical ORDER BY `date` DESC LIMIT 1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$C=mysql_result($query,0);

//select  the latest day 
$sql = "SELECT date FROM {$StockName}_historical ORDER BY `date` DESC LIMIT 1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d1=mysql_result($query,0);

//select the last 9th day
$sql = "SELECT date FROM {$StockName}_historical ORDER BY `date` DESC LIMIT 8,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d9=mysql_result($query,0);

//select the highest price during the last 9 days
$sql = "SELECT MAX(close) FROM {$StockName}_historical  WHERE date>='$d9'";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$H9=mysql_result($query,0);

//select the lowest price during the last 9 days
$sql = "SELECT MIN(close) FROM {$StockName}_historical  WHERE date>='$d9'";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$L9=mysql_result($query,0);

//set K8 value
$sql = "SELECT K FROM {$StockName}_historical ORDER BY `date` DESC LIMIT 1,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$D8=mysql_result($query,0);
//set D8 value
$sql = "SELECT D FROM {$StockName}_historical ORDER BY `date` DESC LIMIT 1,1";
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
$sql = "UPDATE {$StockName}_historical SET D={$D9}, K={$K9},J={$J9} WHERE date='{$d1}'";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());

echo "Date: ",$d1," 's KDJ Indicator Anylysis(period: 9 days): <br>";
echo "RSV= ",$RSV9,"<br>";
echo "K = ",$K9,"<br>";
echo "D = ",$D9,"<br>";
echo "J = ",$J9,"<br>";

if ($K9<20&&$D9<20&&$J9<20){
	echo "It's a Oversold Zone, Suggestion: BUY! ";
}else if ($K9>80&&$D9>80&&$J9>80){
	echo "It's a Overbought Area, Suggestion: SELL! ";
}else if ((20<=$K9)&&($K9<=80)&&(20<=$D9)&&($D9<=80)&&(20<=$J9)&&($J9<=80)){
	echo "It's a Trade Balance Area, Suggestion: HOLD or SIT OUT! ";
}else echo "Unable to give suggestion. Suggestion: NONE";
}
?>
<h4>VR Indicator</h4>
<?php
VRfunction($stockname);
?>
<h4>KDJ Indicator</h4>
<?php
KDJfunction($stockname);

?>
		<script type="text/javascript">
function KDJChart (StockName){
	var tittle = StockName+" KDJ line";
$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
        names = ['K', 'D', 'J'],
        // create the chart when all data is loaded
        createChart = function () {

            $('#container').highcharts('StockChart', {

                rangeSelector: {
                    selected: 4
                },

                yAxis: {
                    labels: {
                        formatter: function () {
                            return (this.value > 0 ? ' + ' : '') + this.value + '%';
                        }
                    },
                    plotLines: [{
                        value: 0,
                        width: 2,
                        color: 'silver'
                    }]
                },

                plotOptions: {
                    series: {
                        compare: 'percent'
                    }
                },

                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
                    valueDecimals: 2
                },

                series: seriesOptions
            });
        };

    $.each(names, function (i, name) {

        $.getJSON("json/KDJ/"+StockName+'_'+name.toLowerCase() + '.json',    function (data) {

            seriesOptions[i] = {
                name: name,
                data: data
            };

            // As we're loading the data asynchronously, we don't know what order it will arrive. So
            // we keep a counter and create the chart when all the data is loaded.
            seriesCounter += 1;

            if (seriesCounter === names.length) {
                createChart();
            }
        });
    });
});
}
		</script>
	</head>
	<body>
<script src="highstock.js"></script>
<script src="exporting.js"></script>
<script>
var stockname = "<?php echo $stockname; ?>"; 
KDJChart(stockname);
</script>

<div id="container" style="height: 400px; min-width: 310px"></div>
<h2>Trading Signals Based On Lines</h2>
<p>&#9830; A negative value of J combined with %K and %D at the bottom range indicates a strong over sold signal.</p>
<p>&#9830; Likewise, when the J value goes above 100, combined with %K and %D at the top range, it will indicate a strong over bought signal. </p>
<h2>Tips</h2>	
	<p>&#9830; In a increasing trend, when the K value is bigger than D value and the K line is increasing to break through the D line, it is the buying signal; In a decreasing trend, when the K value is smaller than the D value and the K line is decreasing to break through the D line, it's a selling signal.</p>
	<p>&#9830; The KDJ indicator is not suitable for the inactively trading stock with a small circulation. But high accuracy for the popular stock with large circulation. </p>
	<p>&#9830; When the speed of the K and D being increasing or decreasing is reducing, the gradient becoming flat is a reversal signal in short term. </p>
	
	</body>



</html>
