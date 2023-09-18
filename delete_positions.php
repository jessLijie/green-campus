<?php
include("connectdb.php");

if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    $deleteQuery = "DELETE FROM labelled_item WHERE itemID = '$itemId'";

    if (mysqli_query($con, $deleteQuery)) {
 
        session_start();
        $_SESSION['success_message'] = "<div class='statusMessageBox1'>
        <div class='toast-content'>
        <i class='bi bi-check2 toast-icon greenColor'></i>
        <div class='message'>
            <span class='message-text text-1'>Success</span>
            <span class='message-text text-2'>Item deleted successfully</span>
        </div>
        </div>
        <i class='bi bi-x toast-close'></i>
        <div class='progressbar active greenColor'></div>
</div>";;
    } else {

        session_start();
        $_SESSION['error_message'] = "Error deleting item: " . mysqli_error($con);
    }

    mysqli_close($con);
}

header("Location: locate.php");
exit;
?>
