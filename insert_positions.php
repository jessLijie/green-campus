<?php
include("connectdb.php");

$itemName = $_POST['mode']; // 'hub', 'bus', 'park', 'bike'
$itemImage = "images/$itemName.png";
$item_lat = $_POST['lat'];
$item_lng = $_POST['lgn'];

$query = "INSERT INTO labelled_item (itemName, itemImage, item_lat, item_lng)
          VALUES ('$itemName', '$itemImage', '$item_lat', '$item_lng')";

if (mysqli_query($con, $query)) {
   
    session_start();
    $_SESSION['success_message'] = "Item inserted successfully!";
    
   
    mysqli_close($con);
    
  
    header("Location: locate.php");
    exit;
} else {
    
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>
