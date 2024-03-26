<?php
    $con = mysqli_connect("localhost", "root", "", "greenify");

    if(!$con){
        die('Could not connect: '.mysqli_connect_error());
    }

?>