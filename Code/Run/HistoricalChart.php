<?php 
//Written by: Siyuan Zhong
//Assisted by: Kaufei Lei
//Debug by: Jianqin Gao
include_once "jsonHistorical.php";
jsonHistorical();

session_start();
$stockname=$_SESSION["stockname"];
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
	
		<script type="text/javascript">
function HistoricalChart (StockName){
	$(function () {
	var filename ="json/Historical/"+StockName+".json";
	var tittle = StockName+" historical";
    $.getJSON(filename, function (data) {
        // split the data set into ohlc and volume
        var ohlc = [],
            volume = [],
            dataLength = data.length,
            // set the allowed units for data grouping
            groupingUnits = [[
                'week',                         // unit name
                [1]                             // allowed multiples
            ], [
                'month',
                [1, 2, 3, 4, 6]
            ]],

            i = 0;
        //echo data[10][0];

        for (i; i < dataLength; i += 1) {
            ohlc.push([
                data[i][0], // the date
                data[i][1], // open
                data[i][2], // high
                data[i][3], // low
                data[i][4] // close
            ]);

            volume.push([
                data[i][0], // the date
                data[i][5] // the volume
            ]);
        }


        // create the chart
        $('#container').highcharts('StockChart', {

            rangeSelector: {
                selected: 1
            },

            title: {
                text: tittle
            },

            yAxis: [{
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: 'OHLC'
                },
                height: '60%',
                lineWidth: 2
            }, {
                labels: {
                    align: 'right',
                    x: -3
                },
                title: {
                    text: 'Volume'
                },
                top: '65%',
                height: '35%',
                offset: 0,
                lineWidth: 2
            }],

            series: [{
                type: 'candlestick',
                name: StockName,
                data: ohlc,
                dataGrouping: {
                    units: groupingUnits
                }
            }, {
                type: 'column',
                name: 'Volume',
                data: volume,
                yAxis: 1,
                dataGrouping: {
                    units: groupingUnits
                }
            }]
        });
    });
});
	
}

		

		</script>
	</head>
	<body>
<script src="highstock.js"></script>
<script src="exporting.js"></script>
<script type="text/javascript">
var stockname = "<?php echo $stockname; ?>"; 
HistoricalChart(stockname);
</script>
<div id="container" style="height: 400px; min-width: 310px"></div>
	</body>
</html>

