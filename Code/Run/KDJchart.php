<?php
//Written by: Siyuan Zhong
//Debug by: Jianqin Gao
//Assisted by: Kaifei Lei
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
		<?php
function KDJchartfunc($StockName){
// get data from database	
$conn = @mysql_connect("localhost","se2","may1994");
if (!$conn){
    die("Fail to connect database：" . mysql_error());
} else {
    
}
mysql_select_db("se2", $conn);	

//select lastest 10 k value
$sql = "SELECT K FROM {$StockName}_historical LIMIT 0,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k10=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 1,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k9=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 2,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k8=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 3,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k7=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 4,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k6=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 5,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k5=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 6,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k4=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 7,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k3=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 8,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k2=mysql_result($query,0);

$sql = "SELECT K FROM {$StockName}_historical LIMIT 9,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$k1=mysql_result($query,0);


//select lastest 10 d value
$sql = "SELECT D FROM {$StockName}_historical LIMIT 0,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d10=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 1,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d9=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 2,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d8=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 3,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d7=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 4,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d6=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 5,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d5=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 6,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d4=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 7,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d3=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 8,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d2=mysql_result($query,0);

$sql = "SELECT D FROM {$StockName}_historical LIMIT 9,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$d1=mysql_result($query,0);

//select lastest 10 J value
$sql = "SELECT J FROM {$StockName}_historical LIMIT 0,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j10=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 1,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j9=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 2,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j8=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 3,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j7=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 4,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j6=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 5,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j5=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 6,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j4=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 7,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j3=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 8,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j2=mysql_result($query,0);

$sql = "SELECT J FROM {$StockName}_historical LIMIT 9,1";
$query=mysql_query($sql) or die($query."<br/><br/>".mysql_error());
$j1=mysql_result($query,0);

}

?>
		<script type="text/javascript">
		function KDJChart (StockName){
			var tittle = StockName+" KDJ line";
$(function () {
    $('#container').highcharts({
        title: {
            text: tittle,
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: ['1','2','3','4','5','6','7','8','9','10']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'D',
            data: [<?php echo $d10; ?>,<?php echo $d9; ?>,<?php echo $d8; ?>,<?php echo $d7; ?>,<?php echo $d6; ?>,<?php echo $d5; ?>,<?php echo $d4; ?>,<?php echo $d3; ?>,<?php echo $d2; ?>,<?php echo $d1; ?>]
        }, {
            name: 'K',
            data: [<?php echo $k10; ?>,<?php echo $k9; ?>,<?php echo $k8; ?>,<?php echo $k7; ?>,<?php echo $k6; ?>,<?php echo $k5; ?>,<?php echo $k4; ?>,<?php echo $k3; ?>,<?php echo $k2; ?>,<?php echo $k1; ?>]
        }, {
            name: 'J',
            data: [<?php echo $j10; ?>,<?php echo $j9; ?>,<?php echo $j8; ?>,<?php echo $j7; ?>,<?php echo $j6; ?>,<?php echo $j5; ?>,<?php echo $j4; ?>,<?php echo $j3; ?>,<?php echo $j2; ?>,<?php echo $j1; ?>]
        }]
    });
});
		}
		</script>

	</head>
	<body>
<script src="highcharts.js"></script>
<script src="exporting.js"></script>
<?php 
KDJchartfunc("twitter");
?>
<script>
KDJChart("twitter");
</script>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
