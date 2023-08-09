<?php
    $con = mysqli_connect("localhost", "root", "jkty12138", "greenify");

    if(!$con){
        die('Could not connect: '.mysqli_connect_error());
    }

?>