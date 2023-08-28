<?php
session_start();

include("connectdb.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM newsfeed WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "News deleted successfully.";
        header('Location: adminManage.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>