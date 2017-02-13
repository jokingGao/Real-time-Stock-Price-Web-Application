<?php 
//Written by: Siyuan Zhong
//Assisted by: Kaifei Lei
//Debug by: Jianqin Gaos
session_start();
include_once 'VR.php';
include_once "search.php";
include_once 'KDJ.php';
@$username=$_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lumino - Panels</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
    
        <?php

        // Connect to the database
        $conn = @mysql_connect("localhost","se2","may1994");
        if (!$conn){
            die("Failed to connect database£º" . mysql_error());
        }
        $db=mysql_select_db("se2", $conn);
        if(!$db)
        {
          die("Failed to connect to MySQL:". mysql_error());
        }
        ?>
    
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Storck</span>Price</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php 
                            if ($username == null)
                                $username = User;
                            echo $username;
                    ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
							<li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search" method="post">
			<div class="form-group" >
				<input type="text" name="search" class="form-control" placeholder="Search a Stock"/>
                <input type="submit" name="submitsearch" value = "submit"/>
			</div>
		</form>
		<ul class="nav menu">
			<li class="active"><a href="index.php"><span class="glyphicon glyphicon-dashboard"></span> Home</a></li>
            <li class="parent ">
				<a href="#">
					<span class="glyphicon glyphicon-list"></span> PriceData <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="Historical.php">
							<span class="glyphicon glyphicon-share-alt"></span> Historical
						</a>
					</li>
					<li>
						<a class="" href="Realtime.php">
							<span class="glyphicon glyphicon-share-alt"></span> Realtime
						</a>
					</li>
				</ul>
			</li>
			<li><a href="Email.php"><span class="glyphicon glyphicon-list-alt"></span> Email</a></li>
            <li class="parent ">
				<a href="#">
					<span class="glyphicon glyphicon-list"></span> Prediction <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-2">
					<li>
						<a class="" href="Indicator.php">
							<span class="glyphicon glyphicon-share-alt"></span> Indicator
						</a>
					</li>
					<li>
						<a class="" href="Price.php">
							<span class="glyphicon glyphicon-share-alt"></span> Price
						</a>
					</li>
				</ul>
			</li>
			<li role="presentation" class="divider"></li>
			<li><a href="login.php"><span class="glyphicon glyphicon-user"></span> Login Page</a></li>
		</ul>
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">Indicator</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">IndicatorPrediction</h1>
			</div>
		</div><!--/.row-->
					
		
        <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Your Stocks</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							    <!-- Title area -->
                        <div class="titleArea" method="post">
                                <div class="button" >
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" id="validate" class="form" method="post">
                                    <?php
                                    $check_query = mysql_query("SELECT Stockname from stocks_for_user where username='$username'"); 
                                    while ($row=mysql_fetch_row($check_query))
                                    {
                                        $sub="submit";
                                        echo "<input type=".$sub." name=".$sub." value=".$row[0]." />";
                                    }
                                    ?>
                                    </div>
                        </div>
						</div>
                        <div class="canvas-wrapper">
						<?php 
                        //print_r($_POST);
                            if (isset($_POST["add"]))
                            {	
                                $stockname=$_POST["add"];
                                $check_query=mysql_query("SELECT Ticker FROM stocks where name='$stockname'");
                                $result=mysql_fetch_array($check_query);
                                $ticker=$result[0];
                                mysql_query("INSERT INTO stocks_for_user VALUES('$username','$stockname','$ticker')");
                                echo "<script>alert('You have successfully add to the list!');location.href='Indicator.php';</script>";
                                exit;
                            }
                            if (isset($_POST["search"]) )
                            {
                                ?>
                                <div class="wrapper" >
                                <h2><?php echo $_POST["search"]; ?></h2>
                                <?php
                                    $check_query=mysql_query("SELECT Description FROM stocks where name='{$_POST["search"]}'");
                                    $des=mysql_fetch_array($check_query);
                                    echo $des[0],"</br>";
                                    $search=new search();
                                    $search->connect();
                                    $highest=$search->findhighest($_POST["search"]);
                                    $average=$search->findaverage($_POST["search"]);
                                    $lowest=$search->findlowest($_POST["search"]);
                                    echo "The highest price of ",$_POST["search"]," in the latest one year is ",$highest,"</br>";
                                    echo "The average price of ",$_POST["search"]," in the latest one year is ",$average,"</br>";
                                    echo "The lowest price of ",$_POST["search"]," in the latest one year is ", $lowest,"</br>";

                                ?>
                                <input type="submit" name="add" placeholder="add to list"  value="<?php echo $_POST["search"];?>" />
                                <h6>Press the button to add the stock to the list</h6>
                                <?php
                            }
                            ?>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2>VR KDJ Suggestion</h2>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						VR
					</div>
					<div class="panel-body">
                    <?php
                    if (isset($_POST["submit"]))
                    {
                        $_SESSION["stockname"]=$_POST["submit"];
                    ?>
                        <!-- Main content wrapper -->
                        <h2>VR</h2>
                                <?php
                                    $VR=new VR();
                                    $VRpridiction=$VR->CalculateVR($_POST["submit"]);
                                    echo "The VR is ",$VRpridiction,"</br>";
                                    $VR->Analysis($VRpridiction);
                                    echo "</br></br>";
                                ?>
                    <div class="clear"></div>
                    <?php
                        }
                    ?>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">
						KDJ
					</div>
					<div class="panel-body">
						<?php
                    if (isset($_POST["submit"]))
                    {
                        $_SESSION["stockname"]=$_POST["submit"];
                    ?>
                        <script>window.open("window_KDJ.php");</script>
                        <!-- Main content wrapper -->
                        <h2>KDJ</h2>
                                <?php
                                KDJfunction($_POST["submit"]);
                                ?>
                    <div class="clear"></div>
                    <?php
                        }
                    ?>
					</div>
				</div>
			</div>
			
		</div><!-- /.row -->
		
		
	</div><!--/.main-->

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
