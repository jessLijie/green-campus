<html>
    <body>
    <!-- add post modal -->
    <div class="modal fade .modal-dialog-centered" id="addPostFormContainer" tabindex="-1" aria-labelledby="addPostFormContainerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="addPostFormContainerLabel">Create Post</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="modalForm" action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="postTitle" class="form-label" >Title:</label>
                <input type="text" class="form-control" id="postTitle" name="postTitle" required />
            </div>
            <div>
                <label for="postContent" class="form-label">Content:</label>
                <textarea class="form-control" id="postContent" name="postContent" rows="4" required></textarea>
            </div>
            <div> 
                <label for="postImg" class="form-label">Image: </label>
                <input type="file" class="form-control" id="postImg" name="postImg" accept="image/*"/>
            </div>
            <div>   
                <label for='category' class="form-label">Category:</label>
                <select name="category" id="category" class='form-select'>
                    <option value='environment-protection'>Environment Protection</option>
                    <option value='energy-resource'>Energy and Resource</option>
                    <option value='waste-recycling'>Waste Reduction and Recycling</option>
                    <option value='carbon-footprint'>Carbon Footprint</option>
                    <option value='transportation'>Transportation</option>
                    <option value='other'>Other</option>
                </select>
            </div>      
            
            <div style="text-align: center; margin: 30px auto 10px;"><button type="submit" name="addPostSubmit" id="submit" class="btn btn-outline-success">Submit</button></div>
        </form>
        </div>
        <!--<div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>-->
        </div>
    </div>
    </div>

    <?php 
    $status = $statusMsg = '';
    if(isset($_POST['addPostSubmit'])){
        echo "<meta http-equiv='refresh' content='0'>";
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
        }
    }
    ?>
    </body>
</html>