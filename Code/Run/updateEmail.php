<?php
//Written by: Jianqin Gao
//Assisted by: Wangzhe Chen
//Debug by: Siyuan Zhong
    set_time_limit(0);
    include_once 'SendEmail.php';
    @$username=$_SESSION["username"];
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
    
    do{
        $i=1;
        $query = mysql_query("SELECT username, email, stockname, stopprice FROM user_email");
        $row_number   = mysql_num_rows($query);
        if(empty($row_number))
        {
            echo "null";
            $i=0;
        }
        while ($row=mysql_fetch_row($query))
        {
            $query2 = mysql_query("SELECT price FROM {$row[2]}_realtime ORDER BY `Date` DESC,`time` DESC   LIMIT 1");
            $result2 = mysql_result($query2,0);
            //echo $result2;
            if ($result2<=$row[3]){
                sendemail($row[0],$row[1],$row[2],$row[3]);
                $query3 = mysql_query("DELETE FROM user_email WHERE username='$row[0]' AND email='$row[1]' AND stockname='$row[2]' AND stopprice=$row[3]");
                echo "haha";
            }
        }
        usleep(50000000);
    }while($i);

    exit
    ?>
<html>
    <head>
    </head>
    <body>
        <h1>web</h1>
    </body>
</html>