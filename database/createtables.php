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
        postContent TEXT,
        postPic BLOB(255),
        postCategory varchar(255),
        postDate datetime,
        userID int,
        FOREIGN KEY (userID) REFERENCES users(userID)
        )";
mysqli_query($con, $sql1);

$sql2= "CREATE TABLE events (
        eventID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        eventName varchar(50),
        latitude decimal(20, 16),
        longitude decimal(20, 16),
        eventDescp text,
        organizer varchar(255),
        startDate date,
        endDate date,
        duration int GENERATED ALWAYS AS (DATEDIFF(endDate, startDate)) STORED
)";
mysqli_query($con,$sql2);

$sql3 = "CREATE TABLE labelled_item(
        itemID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        itemName varchar(50),
        itemImage varchar(50),
        item_lat decimal(20, 16),
        item_lng decimal(20, 16)
)";
mysqli_query($con,$sql3);

// predefined labels
$sql4 = [];
$markers = [
    [1.5610633368545406, 103.64042591346818, 'hub'],
    [1.5586772764694763, 103.63833887638042, 'hub'],
    [1.5617711770954321, 103.63561939498715, 'hub'],
    [1.5618355261964076, 103.64531826263638, 'hub'],
    [1.5572238356525796, 103.63716434736952, 'bike'],
    [1.5604198455313483, 103.63403152728813, 'bike'],
    [1.5591757617257345, 103.6451895166191, 'bike'],
    [1.5628007624863784, 103.63637041351328, 'bus'],
    [1.5596905551138243, 103.6347396304572, 'bus'],
    [1.5579960264032544, 103.64029716745091, 'bus'],
    [1.5603125969563914, 103.64167045844547, 'bus'],
    [1.5627793127961294, 103.63913845317423, 'bus'],
    [1.5634657027755823, 103.64259313833247, 'park'],
    [1.5648345526143883, 103.63936059611834, 'park'],
    [1.55305617950327, 103.64641245128925, 'park'],
    [1.5568706004434785, 103.63494198708115, 'park']
];

foreach ($markers as $marker) {
    $lat = $marker[0];
    $lng = $marker[1];
    $image = $marker[2];

    $sql4[] = "INSERT INTO labelled_item (itemName, itemImage, item_lat, item_lng) VALUES ('$image', 'images/$image.png', $lat, $lng);";
}

foreach ($sql4 as $sqlInsert) {
    mysqli_query($con, $sqlInsert);
}
mysqli_close($con);
?>