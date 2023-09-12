<?php 
session_start();
if(isset($_SESSION['userID'])){
    $userID = $_SESSION['userID'];
}
include("connectdb.php");
    $status = $statusMsg = '';
    if(isset($_POST['addPostSubmit'])){
        $title = mysqli_real_escape_string($con, $_POST['postTitle']);
        $content = mysqli_real_escape_string($con, $_POST['postContent']);
        $category = $_POST['category'];
        $status = 'error';

        if(isset($_FILES["postImg"]["name"])) {
            // Get file info 
            $postImgName = $_FILES["postImg"]["name"];
            if($postImgName!=""){
                //Image is selected
                //get extension of selected image(jpg,png,gif....)
                $postImgName = explode('.', $postImgName);
                $ext = end($postImgName);

                //create new image name
                $postImgName = "postImg-".mt_rand(00000,99999).".".$ext;

                //get src path and destination path
                $src=$_FILES['postImg']['tmp_name'];

                $dst = "./images/postImg/".$postImgName;

                $upload = move_uploaded_file($src, $dst);

                if($upload==false){
                    $_SESSION['upload'] = "<div class='statusMessageBox1'>
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
                    header('location: forum.php');
                    die();
                }
            }

        }else{ 
            $postImgName = "";
        }
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentDate = date('Y-m-d H:i:s');
        $sql1 = "INSERT INTO post(postTitle,postContent,postPic,postCategory,postDate,userID)
                VALUES ('$title', '$content', '$postImgName', '$category', '$currentDate', '$userID')";

        $result1 = mysqli_query($con, $sql1);
        if($result1==true){
            $_SESSION['addpost'] = "<div class='statusMessageBox1'>
                                    <div class='toast-content'>
                                    <i class='bi bi-check2 toast-icon greenColor'></i>
                                    <div class='message'>
                                        <span class='message-text text-1'>Success</span>
                                        <span class='message-text text-2'>Post created successfully</span>
                                    </div>
                                    </div>
                                    <i class='bi bi-x toast-close'></i>
                                    <div class='progressbar active greenColor'></div>
                            </div>";
            header('location: forum.php');
        } else {
            $_SESSION['addpost'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to create post</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
            header('location: forum.php');
        }
    }
?>