<?php
session_start();

include("connectdb.php");

$newsPost = array('id' => '', 'title' => '', 'content' => '');

if (isset($_POST['id'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT * FROM newsfeed WHERE id = $id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if ($result && mysqli_num_rows($result) > 0) {
        $newsPost = mysqli_fetch_assoc($result);
    }
}

$statusMsg = '';
$targetDir = "images/newsImg/";

if (isset($_POST['editNews'])) {
    $newTitle = mysqli_real_escape_string($con, $_POST['title']);
    $newContent = mysqli_real_escape_string($con, $_POST['content']);
    $newAuthor = mysqli_real_escape_string($con, $_POST['author']);
    $newCategory = mysqli_real_escape_string($con, $_POST['category']);
    $newPublishDate = mysqli_real_escape_string($con, $_POST['publishDate']);

    $update = "UPDATE newsfeed SET title = '$newTitle', content = '$newContent', publish_date = '$newPublishDate', author = '$newAuthor', category = '$newCategory' WHERE id = $id";
    if (mysqli_query($con, $update)) {
        echo "News post updated successfully.";
    } else {
        echo "Error updating news post: " . mysqli_error($con);
    }

    if ($_FILES["file"]["name"]) {

        //create new newspic name
        $newsImgName = explode('.', $_FILES["file"]["name"]);
        $ext = end($newsImgName);
        $newsImgName = "newsImg-" . $row['id'] . "-" . mt_rand(00000, 99999) . "." . $ext;
        $fileName = $newsImgName;

        // $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $insert = mysqli_query($con, "UPDATE newsfeed SET image_url = ('" . $fileName . "') WHERE id = $id");
                unlink($targetDir . $row['image_url']);
                if ($insert) {
                    $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
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

    header('Location: adminManage.php');
    exit;
}
?>