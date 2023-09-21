<?php
session_start();
include("connectdb.php");
        //edit
        if(isset($_POST['editGuideSubmit'])){
            $etitle = mysqli_real_escape_string($con, $_POST['eguideTitle']);
            $econtent = mysqli_real_escape_string($con, $_POST['eguideContent']);
            $ecategory = $_POST['ecategory'];
            $eguideid = $_POST['eid'];
            $currImg = $_POST['currentImg'];
            $status = 'error';

            if(!empty($_FILES["eguideImg"]["name"])) {
                // Get file info 
                $guideImgName = $_FILES["eguideImg"]["name"];
                if($guideImgName!=""){
                    //Image is selected
                    //get extension of selected image(jpg,png,gif....)
                    $guideImgName = explode('.', $guideImgName);
                    $ext = end($guideImgName);

                    //create new image name
                    $guideImgName = uniqid("guideImg-").mt_rand(00000,99999).".".$ext;

                    //get src path and destination path
                    $src=$_FILES['eguideImg']['tmp_name'];

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

                    if($currImg!=""){
                        $path = "./images/guideImg/$currImg";
                        $remove = unlink($path);

                        if($remove == false){
                            $_SESSION['remove-failed'] = "<div class='statusMessageBox1'>
                                                                <div class='toast-content'>
                                                                <i class='bi bi-x toast-icon redColor'></i>
                                                                <div class='message'>
                                                                    <span class='message-text text-1'>Failed</span>
                                                                    <span class='message-text text-2'>Failed to remove current image</span>
                                                                </div>
                                                                </div>
                                                                <i class='bi bi-x toast-close'></i>
                                                                <div class='progressbar active redColor'></div>
                                                        </div>";
                            echo "<script>window.location.href='guideManage.php';</script>";
                            die();
                        }
                    }
                }

            }else{ 
                $guideImgName = $currImg;
            }
  
            $sql2 = "UPDATE guides SET
                    guideTitle = '$etitle',
                    guideContent = '$econtent',
                    guideImg='$guideImgName',
                    guideCategory='$ecategory'
                    WHERE guideID = $eguideid
                    ";

            $result2 = mysqli_query($con, $sql2);
            if($result2==true){
                $_SESSION['editguide'] = "<div class='statusMessageBox1'>
                                                <div class='toast-content'>
                                                <i class='bi bi-check2 toast-icon greenColor'></i>
                                                <div class='message'>
                                                    <span class='message-text text-1'>Success</span>
                                                    <span class='message-text text-2'>Guide edited successfully</span>
                                                </div>
                                                </div>
                                                <i class='bi bi-x toast-close'></i>
                                                <div class='progressbar active greenColor'></div>
                                        </div>";
                header('location: guideManage.php');
            } else {
                $_SESSION['editguide'] = "<div class='statusMessageBox1'>
                                                <div class='toast-content'>
                                                <i class='bi bi-x toast-icon redColor'></i>
                                                <div class='message'>
                                                    <span class='message-text text-1'>Failed</span>
                                                    <span class='message-text text-2'>Failed to edit guide</span>
                                                </div>
                                                </div>
                                                <i class='bi bi-x toast-close'></i>
                                                <div class='progressbar active redColor'></div>
                                        </div>";
                header('location: guideManage.php');
            }
        }
        
    ?>