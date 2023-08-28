<?php
session_start();

include("connectdb.php");

$statusMsg = '';
$targetDir = "images/newsImg/";

if (isset($_POST['createNews'])) {
    $newTitle = mysqli_real_escape_string($con, $_POST['title']);
    $newContent = mysqli_real_escape_string($con, $_POST['content']);
    $newAuthor = mysqli_real_escape_string($con, $_POST['author']);
    $newCategory = mysqli_real_escape_string($con, $_POST['category']);
    $newPublishDate = mysqli_real_escape_string($con, $_POST['publishDate']);

    $create = " INSERT INTO newsfeed (title, content, publish_date, author, category) VALUES ('$newTitle', '$newContent', '$newPublishDate', '$newAuthor', '$newCategory')";
    if (mysqli_query($con, $create)) {
        echo "News post updated successfully.";
    } else {
        echo "Error updating news post: " . mysqli_error($con);
    }

    if ($_FILES["file"]["name"]) {
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $insert = mysqli_query($con, "UPDATE newsfeed SET image_url = ('" . $fileName . "') WHERE title = '$newTitle'");
                if ($insert) {
                    $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
                    header('Location: adminManage.php');
                    exit;
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    }
}
?>