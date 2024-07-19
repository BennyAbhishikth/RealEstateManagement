<?php

    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_pass = '';
    $mysql_db   = 'realestatedb';


    $con = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db);
    if(!$con){
        echo "Connection Failed";
    }
    else {
        echo "Database Connected";
    }

