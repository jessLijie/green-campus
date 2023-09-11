<?php
include("connectdb.php");


if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];
    $deleteEventImg = $_GET['eventImage'];
    echo "<script>
        console.log($deleteEventImg);</script>";
    $remove = unlink($deleteEventImg);
    
    if (!$remove) {
        
        echo "Error deleting image: " . error_get_last()['message'];
    }
    $deleteQuery = "DELETE FROM events WHERE eventID = '$eventID'";

    if (mysqli_query($con, $deleteQuery)) {
 
        session_start();
        $_SESSION['success_message'] = "Event deleted successfully!";
    } else {

        session_start();
        $_SESSION['error_message'] = "Error deleting event: " . mysqli_error($con);
    }



    mysqli_close($con);
}

header("Location: manageEvent.php");
exit;
?>
