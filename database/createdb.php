<?php
$con = mysqli_connect("localhost", "jy", "1234");

if(!$con){
    die('Could not connect: '.mysqli_connect_error());
}

if (mysqli_query($con,"CREATE DATABASE greenify")) {

    echo "Database created";

} else {

    echo "Error creating database: " . mysqli_connect_error();

}
mysqli_close($con);
?>