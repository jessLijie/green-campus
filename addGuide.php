<?php 
session_start();
include("connectdb.php");
    $status = $statusMsg = '';
    if(isset($_POST['addGuideSubmit'])){
        $title = mysqli_real_escape_string($con, $_POST['guideTitle']);
        $content = mysqli_real_escape_string($con, $_POST['guideContent']);
        $category = $_POST['category'];
        $status = 'error';

        if(isset($_FILES["guideImg"]["name"])) {
            // Get file info 
            $guideImgName = $_FILES["guideImg"]["name"];
            if($guideImgName!=""){
                //Image is selected
                //get extension of selected image(jpg,png,gif....)
                $guideImgName = explode('.', $guideImgName);
                $ext = end($guideImgName);

                //create new image name
                $guideImgName = "guideImg-".mt_rand(00000,99999).".".$ext;

                //get src path and destination path
                $src=$_FILES['guideImg']['tmp_name'];

                $dst = "./images/guideImg/".$guideImgName;

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
                    header('location: guideManage.php');
                    die();
                }
            }

        }else{ 
            $guideImgName = "";
        }
        
        $sql1 = "INSERT INTO guides(guideTitle,guideContent,guideImg,guideCategory)
                VALUES ('$title', '$content', '$guideImgName', '$category')";

        $result1 = mysqli_query($con, $sql1);
        if($result1==true){
            $_SESSION['addguide'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-check2 toast-icon greenColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Success</span>
                                                <span class='message-text text-2'>Guide added successfully</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active greenColor'></div>
                                    </div>";
            header('location: guideManage.php');
        } else {
            $_SESSION['addguide'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to delete guide</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
            header('location: guideManage.php');
        }
    }
    ?>