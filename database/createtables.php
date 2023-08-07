<?php
include("connectdb.php");
$sql1 = "CREATE TABLE user (
        userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(50),
        password varchar(255),
        email varchar(255),
        CONSTRAINT UC_User_Username UNIQUE (username),
        CONSTRAINT UC_User_Email UNIQUE (email)
)";
mysqli_query($con, $sql1);

mysqli_close($con);
?>