<?php
include("connectdb.php");
$sql1 = "CREATE TABLE NewsFeed (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        author VARCHAR(100) NOT NULL,
        publish_date DATETIME NOT NULL,
        image_url VARCHAR(255),
        category VARCHAR(50)
)";
mysqli_query($con, $sql1);

mysqli_close($con);
?>