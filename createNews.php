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
        $_SESSION['addNews'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-check2 toast-icon greenColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Success</span>
                                                <span class='message-text text-2'>News added successfully</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active greenColor'></div>
                                    </div>";
    } else {
        echo "Error updating news post: " . mysqli_error($con);
        $_SESSION['addNews'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to add news</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
        header('Location: adminManage.php');
        exit;
    }

    $last_id = mysqli_insert_id($con);

    if ($_FILES["file"]["name"]) {

        $newsImgName = explode('.', $_FILES["file"]["name"]);
        $ext = end($newsImgName);
        $newsImgName = "newsImg-" . $last_id . "-" . mt_rand(00000, 99999) . "." . $ext;
        $fileName = $newsImgName;

        // $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $insert = mysqli_query($con, "UPDATE newsfeed SET image_url = ('" . $fileName . "') WHERE id = '$last_id'");
                if ($insert) {
                    $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
                $_SESSION['addNews'] = "<div class='statusMessageBox1'>
                                                <div class='toast-content'>
                                                <i class='bi bi-x toast-icon redColor'></i>
                                                <div class='message'>
                                                    <span class='message-text text-1'>Failed</span>
                                                    <span class='message-text text-2'>Failed to upload image</span>
                                                </div>
                                                </div>
                                                <i class='bi bi-x toast-close'></i>
                                                <div class='progressbar active redColor'></div>
                                        </div>";
                mysqli_query($con, "DELETE FROM newsfeed WHERE id = '$last_id'");
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    }

    header('Location: adminManage.php');
    exit;
}
?>