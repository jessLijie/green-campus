<?php
include("connectdb.php");

if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    $deleteQuery = "DELETE FROM labelled_item WHERE itemID = '$itemId'";

    if (mysqli_query($con, $deleteQuery)) {
 
        session_start();
        $_SESSION['success_message'] = "Item deleted successfully!";
    } else {

        session_start();
        $_SESSION['error_message'] = "Error deleting item: " . mysqli_error($con);
    }

    mysqli_close($con);
}

header("Location: locate.php");
exit;
?>
