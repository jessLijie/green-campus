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

$sql="CREATE TABLE post (
        postID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        postTitle varchar(255),
        postContent TEXT(255),
        postPic BLOB(255),
        postCategory varchar(255),
        postDate datetime,
        userID varchar(50),
        FOREIGN KEY (userID) REFERENCES users(userID)
        )";

mysqli_close($con);
?>