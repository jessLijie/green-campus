<?php
session_start();

include("connectdb.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM newsfeed WHERE id = $id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);

    $sql = "DELETE FROM newsfeed WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        unlink('images/newsImg/' .$row['image_url']);
        echo "News deleted successfully.";
        header('Location: adminManage.php');
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>