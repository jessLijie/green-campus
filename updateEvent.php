<?php
include("connectdb.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES["eventImage"]["name"])) {

        $imagePath = "images/event/";

        if ($_FILES["eventImage"]["error"] == UPLOAD_ERR_OK) {
            $tempName = $_FILES["eventImage"]["tmp_name"];
            $originalName = $_FILES["eventImage"]["name"];
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $ext;

            if (move_uploaded_file($tempName, $imagePath . $newFileName)) {
                $eventID = $_POST["eventID"];
                $eventName = $_POST["eventName"];
                $category = $_POST["category"];
                $startDate = $_POST["startDate"];
                $endDate = $_POST["endDate"];
                $locationName = $_POST["locationName"];
                $organizer = $_POST["organizer"];
                $eventDescp = $_POST["eventDescp"];
                $sql = "UPDATE events SET eventName='$eventName', category='$category', startDate='$startDate', endDate='$endDate', locationName='$locationName', organizer='$organizer', eventDescp='$eventDescp', eventImage='$imagePath$newFileName' WHERE eventID='$eventID'";

                if (mysqli_query($con, $sql)) {
                    $_SESSION['success_message'] = "Event updated successfully!";
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

        $sql = "UPDATE events SET eventName='$eventName', category='$category', startDate='$startDate', endDate='$endDate', locationName='$locationName', organizer='$organizer', eventDescp='$eventDescp' WHERE eventID='$eventID'";


        if (mysqli_query($con, $sql)) {
            $_SESSION['success_message'] = "Event updated successfully!";
            header("Location: manageEvent.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error updating event: " . mysqli_error($con);
        }
    }
}

exit();
?>