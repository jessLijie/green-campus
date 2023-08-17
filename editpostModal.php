<html>
    <head>
    </head>
    <body>
        <?php 
        //edit post
        if(isset($_POST['action']) && $_POST['action'] == "edit" ){
            echo "<script type='text/javascript'>
            $(document).ready(function() {
                $('#editPostFormContainer').modal('show');
            });
            </script>";
            $editpostid = $_POST['editpostID'];
            $sqlEditpost = "SELECT * FROM post WHERE postID=$editpostid";
            $reseditpost = mysqli_query($con, $sqlEditpost);
            $rowedit = mysqli_fetch_array($reseditpost, MYSQLI_ASSOC);
        }
        ?>
        <!-- edit post modal -->
        <div class="modal fade .modal-dialog-centered" id="editPostFormContainer" tabindex="-1" aria-labelledby="editPostFormContainerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editPostFormContainerLabel">Edit Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="addPostForm" action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="epostTitle">Title:</label>
                    <input type="text" class="inputPostTitle" id="epostTitle" name="epostTitle" value="<?php if(isset($_POST['editpostID'])){ echo $rowedit['postTitle']; } ?>" required />
                </div>
                <div>
                    <label for="epostContent">Content:</label>
                    <textarea class="inputPostContent" id="epostContent" name="epostContent" rows="4" required><?php if(isset($_POST['editpostID'])){ echo $rowedit['postContent']; } ?></textarea>
                </div>
                <div> 
                    <p>Current Image: </p>
                    <?php
                        $currentImg = $rowedit['postPic'];
                        if($currentImg==""){
                            echo "<div class='imgerror'>Image Not Available.</div>";
                        } else {
                            echo "<img src='./images/postImg/$currentImg' alt='post_picture' width='100px'/>";
                        }
                    ?>
                </div>
                <div> 
                    <label for="epostImg">New Image: </label>
                    <input type="file" class='postImg' id="epostImg" name="epostImg" accept="image/*"/>
                </div>
                <div>   
                    <label for="category">Category:</label>
                    <select name="ecategory" id="category" class='inputCategory'>
                        <option value='environment-protection' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="environment-protection"){ echo "selected"; } ?>>Environment Protection</option>
                        <option value='energy-resource' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="energy-resource"){ echo "selected"; } ?>>Energy and Resource</option>
                        <option value='waste-recycling' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="waste-recycling"){ echo "selected"; } ?>>Waste Reduction and Recycling</option>
                        <option value='carbon-footprint' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="carbon-footprint"){ echo "selected"; } ?>>Carbon Footprint</option>
                        <option value='transportation' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="transportation"){ echo "selected"; } ?>>Transportation</option>
                        <option value='other' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="other"){ echo "selected"; } ?>>Other</option>
                    </select>
                </div>
                <input type="hidden" name="eid" value="<?php echo $editpostid; ?>" />
                <input type="hidden" name="currentImg" value="<?php echo $currentImg; ?>" />
                <div class="submitbtnStyle"><button type="submit" name="editPostSubmit" id="submit" class="submitbtn">Submit</button></div>
            </form>
            </div>
            </div>
        </div>
        </div>
        <?php
        //edit
        if(isset($_POST['editPostSubmit'])){
            echo "<meta http-equiv='refresh' content='0'>";
            $etitle = $_POST['epostTitle'];
            $econtent = $_POST['epostContent'];
            $ecategory = $_POST['ecategory'];
            $epostid = $_POST['eid'];
            $currImg = $_POST['currentImg'];
            $status = 'error';

            if(!empty($_FILES["epostImg"]["name"])) {
                $_SESSION['hhh'] = $_FILES["epostImg"]["name"];
                // Get file info 
                $postImgName = $_FILES["epostImg"]["name"];
                if($postImgName!=""){
                    //Image is selected
                    //get extension of selected image(jpg,png,gif....)
                    $postImgName = explode('.', $postImgName);
                    $ext = end($postImgName);

                    //create new image name
                    $postImgName = "postImg-".mt_rand(00000,99999).".".$ext;

                    //get src path and destination path
                    $src=$_FILES['epostImg']['tmp_name'];

                    $dst = "./images/postImg/".$postImgName;

                    $upload = move_uploaded_file($src, $dst);

                    if($upload==false){
                        $_SESSION['upload'] = "<div class='error><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to Upload Image.</div>";
                        header('location: forum.php');
                        die();
                    }

                    if($currImg!=""){
                        $path = "./images/postImg/$currImg";
                        $remove = unlink($path);

                        if($remove == false){
                            $_SESSION['remove-failed'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to remove current image.</div>";
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
                $_SESSION['edit'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='tick' />Post Edited Successfully.</div>";
                
            } else {
                $_SESSION['edit'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to Edit Post.</div>";
                
            }
        }
        
    ?>
    </body>
</html>