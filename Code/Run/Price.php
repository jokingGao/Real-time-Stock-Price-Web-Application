<?php 
//Written by: Siyuan Zhong
//Debug by: Jianqin Gao
//Assisted by: Wangzhe Chen
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
<title>Lumino - Widgets</title>

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
        $file = fopen("predictSVM.csv","r");
        for ($i=0;$i<10;$i++) {
            $data = fgetcsv($file, 1000, ",");
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
            $result[$i]=$data;
                //echo $data;
            }
        }
        fclose($file);
        $file = fopen("predictBay.csv","r");
        for ($i=0;$i<10;$i++) {
            $data = fgetcsv($file, 1000, ",");
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
            $result2[$i]=$data;
                //echo $data;
            }
        }
        fclose($file);
        $file = fopen("predictNN.csv","r");
        for ($i=0;$i<10;$i++) {
           $data = fgetcsv($file, 1000, ",");
            $num = count($data);
            for ($c=0; $c < $num; $c++) {
            $result3[$i]=$data;
            }
        }
        fclose($file);

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
				<li class="active">PricePrediction</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Price Predition</h1>
			</div>
		</div><!--/.row-->
									
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-shopping-cart glyphicon-l"></em>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">10</div>
							<div class="text-muted">Stocks</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<em class="glyphicon glyphicon-comment glyphicon-l"></em>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">2</div>
							<div class="text-muted">Users</div>
						</div>
					</div>
				</div>
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
                                echo "<script>alert('You have successfully add to the list!');location.href='Price.php';</script>";
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
                                    echo "The highest price of ",$_POST["search"]," in the latest one year days is ",$highest,"</br>";
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
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> Prediction Strategy</div>
					<div class="panel-body">
                    <?php
                    if (isset($_POST["submit"]))
                    {
                        for ($i=0;$i<10;$i++)
                        {
                            if ($result[$i][2]==$_POST["submit"])
                                $stock=$result[$i];
                        }
                    ?>
                <h4>Short Term(1 day): SVM</h4>
				 <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
                        <td>StockID</td>
                        <td>Ticker</td>
                        <td>Name</td>
                        <td>Company</td>
                        <td>Last Price Date</td>
						<td>Last Close Price</td>
						<td>Predict Price Next Day</td>
                    </tr>
                </thead>
                <tbody>
				<?php 			 
                    echo "<tr>";
                       echo   "<td> ".$stock[0]." </td>";
                       echo "<td> ".$stock[1]. "</td>";
                       echo "<td> ".$stock[2]. "</td>";
                       echo "<td> ". $stock[3] ."</td>";
					   echo "<td> ". $stock[4] ."</td>";
					   echo "<td> ". $stock[5] ."</td>";
                       echo "<td> ". round($stock[6],2) ."</td>";
					   echo "</tr>";
                  ?>
                </tbody>
                </table>
                <?php
                }
                ?>
					</div>
				</div>
                <div class="panel panel-default">
					<div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> Prediction Strategy</div>
					<div class="panel-body">
                    <?php
                    if (isset($_POST["submit"]))
                    {
                        for ($i=0;$i<10;$i++)
                        {
                            if ($result2[$i][2]==$_POST["submit"])
                                $stock2=$result2[$i];
                        }
                    ?>
                <h4>Short Term(1 day): Bayesian</h4>
				 <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
                        <td>StockID</td>
                        <td>Ticker</td>
                        <td>Name</td>
                        <td>Company</td>
                        <td>Last Price Date</td>
						<td>Last Close Price</td>
						<td>Predict Price Next Day</td>
                    </tr>
                </thead>
                <tbody>
				<?php 			 
                    echo "<tr>";
                       echo   "<td> ".$stock2[0]." </td>";
                       echo "<td> ".$stock2[1]. "</td>";
                       echo "<td> ".$stock2[2]. "</td>";
                       echo "<td> ". $stock2[3] ."</td>";
					   echo "<td> ". $stock2[4] ."</td>";
					   echo "<td> ". $stock2[5] ."</td>";
                       echo "<td> ". round($stock2[6],2) ."</td>";
					   echo "</tr>";
                  ?>
                </tbody>
                </table>
                <?php
                }
                ?>
					</div>
				</div>
                <div class="panel panel-default">
					<div class="panel-heading"><span class="glyphicon glyphicon-envelope"></span> Prediction Strategy</div>
					<div class="panel-body">
                    <?php
                    if (isset($_POST["submit"]))
                    {
                        for ($i=0;$i<10;$i++)
                        {
                            if ($result3[$i][0]==$_POST["submit"])
                                $stock3=$result3[$i];
                        }
                    ?>
            <h4 >Long Term: Neural Network</h4>
			<h6>The prediction price for the next 10 days to <?php echo $stock2[2] ?> are </h6>
                 <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
						<td>4</td>
						<td>5</td>
						<td>6</td>
						<td>7</td>
						<td>8</td>
						<td>9</td>
						<td>10</td>
                    </tr>
                </thead>
                <tbody>
				<?php 			 
                    echo "<tr>";
                       echo "<td> ".round($stock3[3],2)." </td>";
                       echo "<td> ".round($stock3[4],2). "</td>";
                       echo "<td> ". round($stock3[5],2) ."</td>";
					   echo "<td> ". round($stock3[6],2) ."</td>";
					   echo "<td> ". round($stock3[7],2) ."</td>";
					   echo "<td> ". round($stock3[8],2) ."</td>";
					   echo "<td> ". round($stock3[9],2) ."</td>";
					   echo "<td> ". round($stock3[10],2) ."</td>";
					   echo "<td> ". round($stock3[11],2) ."</td>";
					   echo "<td> ". round($stock3[12],2) ."</td>";
					   echo "</tr>";
                  ?>
                </tbody>
				</table>
                <?php
                    }
                ?>
					</div>
				</div>
			</div><!--/.col-->
                    
			
			<div class="col-md-4">	
				<div class="panel panel-red">
					<div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-calendar"></span>Calendar</div>
					<div class="panel-body">
						<div id="calendar"></div>
					</div>
				</div>
				
				<div class="panel panel-blue">
					<div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-check"></span>To-do List</div>
					<div class="panel-body">
						<ul class="todo-list">
						<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox" />
									<label for="checkbox">Make a plan for today</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox" />
									<label for="checkbox">Choose your own stock</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox" />
									<label for="checkbox">Send email  for stop loss price</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox" />
									<label for="checkbox">Sell google today</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input-group">
							<input id="btn-input" type="text" class="form-control input-md" placeholder="Add new task" />
							<span class="input-group-btn">
								<button class="btn btn-primary btn-md" id="btn-todo">Add</button>
							</span>
						</div>
					</div>
				</div>				
			</div><!--/.col-->          
		</div><!--/.row-->
	</div>	<!--/.main-->
		  

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
		});

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
