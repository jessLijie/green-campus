<?php
include("connectdb.php");
session_start();
$currentPage = "event";
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
} ?>


<html>

<head>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="css/locate.css" />
    <title>Greenify | Locate</title>
</head>

<body>
    <?php include("header.php") ?>

    

</body>

</html>