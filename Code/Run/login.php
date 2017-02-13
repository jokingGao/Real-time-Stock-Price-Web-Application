<?php 
//Written by: Kaifei Lei
//Debug by: Siyuan Zhong
//Assisted by: Wangzhe Chen
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forms</title>

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

    $username=$password="";
    if(isset($_POST["submit"]))
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
         $username = test_input($_POST["username"]);
         $password= test_input($_POST["password"]);
            //Check the user
        $check_query = mysql_query("SELECT * from Users where username='$username' and password='$password'"); 
        if ($check_query)
        {	 
            $row=mysql_fetch_array($check_query);
            print_r(mysql_fetch_array($check_query));
            echo "1";
            if($row)
            {  
                $_SESSION["username"]=$username;
                $_SESSION["password"]=$password;
                if(!empty($_POST["remember"]))
                {
                    //echo "<script>alert('Y1111')</script>";
                    $_SESSION["username"]=$username;
                    $_SESSION["password"]=$password;
                }
                echo "<script>alert('You have successfully logged in!');location.href='index.php';</script>";
            }
            else
            {
                echo "<script>alert('Your Account is not right!');location.href='login.php';</script>";
            }
        }
        }
    }
    
    function test_input($data) 
    {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    ?>
 
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<form action="<?php echo $_SERVER['PHP_SELF']?>" id="validate" class="form" method="post">
						<fieldset>
							<div class="form-group">
								<label for="login">Username:</label>
                                <div class="loginInput"><input type="username" name="username" class="form-control" id="login" /></div>
                                <div class="clear"></div>
							</div>
                            
							<div class="form-group">
								<label for="pass">Password:</label>
                                <div class="loginInput"><input type="password" name="password" class="form-control" id="pass" /></div>
                                <div class="clear"></div>
							</div>
                            
							<div class="checkbox">
                                <label>
					               <input type="checkbox" id="remember" name="remember" />Remember me
                                </label>
							</div>
                            <input type="submit" value="Log me in" class="btn btn-primary" name="submit" />
					
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

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
