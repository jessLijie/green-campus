<?php
    $con = mysqli_connect("localhost", "greenify", "1234", "greenify");

    if(!$con){
        die('Could not connect: '.mysqli_connect_error());
    }

?>