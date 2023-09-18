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
        $_SESSION['success_message'] = "<div class='statusMessageBox1'>
        <div class='toast-content'>
        <i class='bi bi-check2 toast-icon greenColor'></i>
        <div class='message'>
            <span class='message-text text-1'>Success</span>
            <span class='message-text text-2'>Event deleted successfully</span>
        </div>
        </div>
        <i class='bi bi-x toast-close'></i>
        <div class='progressbar active greenColor'></div>
</div>";
    } else {

        session_start();
        $_SESSION['error_message'] = "Error deleting event: " . mysqli_error($con);
    }



    mysqli_close($con);
}

header("Location: manageEvent.php");
exit;
?>