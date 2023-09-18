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
    $_SESSION['success_message'] = "<div class='statusMessageBox1'>
    <div class='toast-content'>
    <i class='bi bi-check2 toast-icon greenColor'></i>
    <div class='message'>
        <span class='message-text text-1'>Success</span>
        <span class='message-text text-2'>Item inserted successfully</span>
    </div>
    </div>
    <i class='bi bi-x toast-close'></i>
    <div class='progressbar active greenColor'></div>
</div>";;
    
   
    mysqli_close($con);
    
  
    header("Location: locate.php");
    exit;
} else {
    
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>
