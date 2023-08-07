<?php
include("../connectdb.php");
$sql1 = "CREATE TABLE users (
        userID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username varchar(50),
        upassword varchar(255),
        email varchar(255),
        urole varchar(20),
        CONSTRAINT UC_User_Username UNIQUE (username),
        CONSTRAINT UC_User_Email UNIQUE (email)
)";
mysqli_query($con, $sql1);

mysqli_close($con);
?>