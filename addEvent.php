<?php
include("connectdb.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST["eventName"];
    $category = $_POST["category"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $locationName = $_POST["locationName"];
    $organizer = $_POST["organizer"];
    $eventDescp = $_POST["eventDescp"];

    if (!empty($_FILES["eventImage"]["name"])) {
    
        $imagePath = "images/event/";

        if ($_FILES["eventImage"]["error"] == UPLOAD_ERR_OK) {
            $tempName = $_FILES["eventImage"]["tmp_name"];
            $originalName = $_FILES["eventImage"]["name"];
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $ext;

            if (move_uploaded_file($tempName, $imagePath . $newFileName)) {
                $sql = "INSERT INTO events (eventName,category,startDate,endDate,locationName,organizer,eventDescp,eventImage)
                VALUES ('$eventName','$category','$startDate','$endDate','$locationName','$organizer','$eventDescp','$imagePath$newFileName')";
                
                if (mysqli_query($con, $sql)) {
                    $_SESSION['success_message'] = "<div class='statusMessageBox1'>
                    <div class='toast-content'>
                    <i class='bi bi-check2 toast-icon greenColor'></i>
                    <div class='message'>
                        <span class='message-text text-1'>Success</span>
                        <span class='message-text text-2'>Event added successfully</span>
                    </div>
                    </div>
                    <i class='bi bi-x toast-close'></i>
                    <div class='progressbar active greenColor'></div>
            </div>";
                    header("Location: manageEvent.php"); 
                    exit();
                } else {
                    $_SESSION['error_message'] = "Error updating event: " . mysqli_error($con);
                }
            } else {
                $_SESSION['error_message'] = "Failed to upload the image.";
            }
        } else {
            $_SESSION['error_message'] = "Error uploading the image: " . $_FILES["eventImage"]["error"];
        }
    } else {
        $sql = "INSERT INTO events (eventName,category,startDate,endDate,locationName,organizer,eventDescp,eventImage)
        VALUES ('$eventName','$category','$startDate','$endDate','$locationName','$organizer','$eventDescp','$imagePath$newFileName')";

        if (mysqli_query($con, $sql)) {
            $_SESSION['success_message'] = "<div class='statusMessageBox1'>
            <div class='toast-content'>
            <i class='bi bi-check2 toast-icon greenColor'></i>
            <div class='message'>
                <span class='message-text text-1'>Success</span>
                <span class='message-text text-2'>Event added successfully</span>
            </div>
            </div>
            <i class='bi bi-x toast-close'></i>
            <div class='progressbar active greenColor'></div>
    </div>";
            header("Location: manageEvent.php"); 
            exit();
        } else {
            $_SESSION['error_message'] = "Error updating event: " . mysqli_error($con);
        }
    }
}

exit();
?>
