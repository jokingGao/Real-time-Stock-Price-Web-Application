<?php 
//Written by: Siyuan Zhong
//Assisted by: Wangzhe Chen
//Debug by: Jianqin Gao
session_start();
$stockname=$_SESSION["stockname"];
 //date_default_timezone_set('UTD');

include_once 'jsonRealtime.php';
jsonRealtime();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>OKCoin LTCCNY Price</title>

    <script type="text/javascript"     src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">
	function HistoricalChart (StockName){
    var chart; // global
    var filename_lastpoint ="json/Realtime/"+StockName+"_realtime.json";
	var filename="json/Realtime/"+StockName+"_realtime.json";
	var tittle = StockName+" realtime";
//    function requestData() {
//        $.ajax({
//            url: filename_lastpoint, 
//            success: function(point) {
//                var series = chart.series[0],
//                    shift = series.data.length > 100; // shift if the series is longer than 20
//
//                // add the point
//                chart.series[0].addPoint(eval(point), true, shift);
//
//                // call it again after one second
//                setTimeout(requestData, 10000); 
//            },
//            cache: false
//        });
//    }

        
$(function () {
    $.getJSON(filename, function (data) {

        // create the chart
        $('#container').highcharts('StockChart', {


            title: {
                text: tittle
            },

            subtitle: {
                text: 'Using ordinal X axis'
            },

            xAxis: {
                gapGridLineWidth: 0
            },

            rangeSelector : {
                buttons : [{
                    type : 'minute',
                    count : 10,
                    text : '10M'
                }, {
                    type : 'hour',
                    count : 1,
                    text : '1H'
                }, {
                    type : 'all',
                    count : 1,
                    text : 'All'
                }],
                selected : 1,
                inputEnabled : false
            },

            series : [{
                name : StockName,
                type: 'area',
                data : data,
                gapSize: 1,
                tooltip: {
                    valueDecimals: 2
                },
                fillColor : {
                    linearGradient : {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops : [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                threshold: null
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
<script>
var stockname = "<?php echo $stockname; ?>"; 
HistoricalChart(stockname);
</script>
<div id="container" style="height: 500px; min-width: 500px"></div>

</body>
</html>