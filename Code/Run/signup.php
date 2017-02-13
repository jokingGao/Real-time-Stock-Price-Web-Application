<?php 
//Written by: Kaifei Lei
//Assisted by: Wangzhe Chen
//Debug by: Jianqin Gao
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

    
    $username=$email=$password="";
    if(isset($_POST["submit"]))
    {echo "good~~~~~You have already sign up!";
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $email = test_input($_POST["email"]);
            $password= test_input($_POST["password"]);
            $username=test_input($_POST["username"]);
        }
        //Insert the user
        $check_query = mysql_query("INSERT INTO Users Values('$username','$email','$password')"); 
         if(!empty($_POST["rembember"]))
        {
        $_SESSION["adminemail"]=$email;
        $_SESSION["adminpassword"]=$password;
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
				<div class="panel-heading">Sign up</div>
				<div class="panel-body">
					<form class="register"  method="post">
						<fieldset>
							<div class="form-group">
                                <label for="Signup">Email:</label>
								<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="">
							</div>
							<div class="form-group">
                                <label for="Signup">UserName:</label>
								<input class="form-control" placeholder="UserName" name="username" type="name" autofocus="">
							</div>
							<div class="form-group">
                                <label for="Signup">Password:</label>
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Register Now" />
							<a href="login.php" class="btn btn-primary">Login</a>
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
