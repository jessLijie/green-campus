<?php
    $con = mysqli_connect("localhost", "root", "jkty12138");

    if(!$con){
        die('Could not connect: '.mysqli_connect_error());
    }
    
    mysqli_select_db($con, "greenify");
?>