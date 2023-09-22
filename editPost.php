<?php
    //edit
    if(isset($_POST['editPostSubmit'])){
        echo "<meta http-equiv='refresh' content='0'>";
        $etitle = mysqli_real_escape_string($con, $_POST['epostTitle']);
        $econtent = mysqli_real_escape_string($con, $_POST['epostContent']);
        $ecategory = $_POST['ecategory'];
        $epostid = $_POST['eid'];
        $currImg = $_POST['currentImg'];
        $status = 'error';

        if(!empty($_FILES["epostImg"]["name"])) {
            // Get file info 
            $postImgName = $_FILES["epostImg"]["name"];
            if($postImgName!=""){
                //Image is selected
                //get extension of selected image(jpg,png,gif....)
                $postImgName = explode('.', $postImgName);
                $ext = end($postImgName);

                //create new image name
                $postImgName = uniqid("postImg-").mt_rand(00000,99999).".".$ext;

                //get src path and destination path
                $src=$_FILES['epostImg']['tmp_name'];

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

                if($currImg!=""){
                    $path = "./images/postImg/$currImg";
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
                        echo "<script>window.location.href='forum.php';</script>";
                        die();
                    }
                }
            }

        }else{ 
            $postImgName = $currImg;
        }
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentDate = date('Y-m-d H:i:s');
        $sql2 = "UPDATE post SET
                postTitle = '$etitle',
                postContent = '$econtent',
                postPic='$postImgName',
                postCategory='$ecategory',
                postDate='$currentDate'
                WHERE postID = $epostid
                ";

        $result2 = mysqli_query($con, $sql2);
        if($result2==true){
            $_SESSION['editpost'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-check2 toast-icon greenColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Success</span>
                                            <span class='message-text text-2'>Post edited successfully</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active greenColor'></div>
                                </div>";
            
        } else {
            $_SESSION['editpost'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-x toast-icon redColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Failed</span>
                                                <span class='message-text text-2'>Failed to edit post</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active redColor'></div>
                                    </div>";
            
        }
    }
    
?>