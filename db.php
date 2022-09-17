<?php
    $hostname = "localhost";
    $db_user = "root";
    $password = "";
    $db_name = 'test';
    $con = mysqli_connect($hostname, $db_user,$password,$db_name);
    if($con){ echo '';}else{echo 'fail';}
?>