<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "greenify");

if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM newsfeed WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "News deleted successfully.";
        header('Location: adminHome.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>