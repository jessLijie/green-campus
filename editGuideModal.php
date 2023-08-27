<html>
    <head>
        <style>
            .modalForm div{
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <?php 
        //edit guide
        if(isset($_POST['action']) && $_POST['action'] == "edit" ){
            echo "<script type='text/javascript'>
            $(document).ready(function() {
                $('#editGuideFormContainer').modal('show');
            });
            </script>";
            $editguideid = $_POST['editguideID'];
            $sqlEditguide = "SELECT * FROM guides WHERE guideID=$editguideid";
            $reseditguide = mysqli_query($con, $sqlEditguide);
            $rowedit = mysqli_fetch_array($reseditguide, MYSQLI_ASSOC);
        }
        ?>
        <!-- edit guide modal -->
        <div class="modal fade .modal-dialog-centered" id="editGuideFormContainer" tabindex="-1" aria-labelledby="editGuideFormContainerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editGuideFormContainerLabel">Edit Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="modalForm" action="" method="guide" enctype="multipart/form-data">
                <div>
                    <label for="eguideTitle" class="form-label">Title:</label>
                    <input type="text" class="form-control" id="eguideTitle" name="eguideTitle" value="<?php if(isset($_POST['editguideID'])){ echo $rowedit['guideTitle']; } ?>" required />
                </div>
                <div>
                    <label for="eguideContent" class="form-label">Content:</label>
                    <textarea class="form-control" id="eguideContent" name="eguideContent" rows="4" required><?php if(isset($_POST['editguideID'])){ echo $rowedit['guideContent']; } ?></textarea>
                </div>
                <div> 
                    <p>Current Image: </p>
                    <?php
                        $currentImg = $rowedit['guideImg'];
                        if($currentImg==""){
                            echo "<div class='imgerror'>Image Not Available.</div>";
                        } else {
                            echo "<img src='./images/guideImg/$currentImg' alt='guide_picture' width='100px'/>";
                        }
                    ?>
                </div>
                <div> 
                    <label for="eguideImg" class="form-label">New Image: </label>
                    <input type="file" class='form-control' id="eguideImg" name="eguideImg" accept="image/*"/>
                </div>
                <div>   
                    <label for="category" class="form-label">Category:</label>
                    <select name="ecategory" id="category" class='form-select'>
                        <option value='environment-protection' <?php if(isset($_POST['editguideID']) && $rowedit['guideCategory']==htmlspecialchars("Environment Protection")){ echo "selected"; } ?>>Environment Protection</option>
                        <option value='energy-resource' <?php if(isset($_POST['editguideID']) && $rowedit['guideCategory']==htmlspecialchars("Energy and Resource")){ echo "selected"; } ?>>Energy and Resource</option>
                        <option value='waste-recycling' <?php if(isset($_POST['editguideID']) && $rowedit['guideCategory']==htmlspecialchars("Waste Reduction and Recycling")){ echo "selected"; } ?>>Waste Reduction and Recycling</option>
                        <option value='carbon-footprint' <?php if(isset($_POST['editguideID']) && $rowedit['guideCategory']==htmlspecialchars("Carbon Footprint")){ echo "selected"; } ?>>Carbon Footprint</option>
                        <option value='transportation' <?php if(isset($_POST['editguideID']) && $rowedit['guideCategory']=="Transportation"){ echo "selected"; } ?>>Transportation</option>
                        <option value='other' <?php if(isset($_POST['editguideID']) && $rowedit['guideCategory']=="Other"){ echo "selected"; } ?>>Other</option>
                    </select>
                </div>
                <input type="hidden" name="eid" value="<?php echo $editguideid; ?>" />
                <input type="hidden" name="currentImg" value="<?php echo $currentImg; ?>" />
                <div style="text-align: center; margin: 30px auto 10px;"><button type="submit" name="editPostSubmit" id="submit" class="btn btn-outline-success">Submit</button></div>
            </form>
            </div>
            </div>
        </div>
        </div>
        <?php
        //edit
        if(isset($_POST['editPostSubmit'])){
            echo "<meta http-equiv='refresh' content='0'>";
            $etitle = $_POST['eguideTitle'];
            $econtent = $_POST['eguideContent'];
            $ecategory = $_POST['ecategory'];
            $eguideid = $_POST['eid'];
            $currImg = $_POST['currentImg'];
            $status = 'error';

            if(!empty($_FILES["eguideImg"]["name"])) {
                $_SESSION['hhh'] = $_FILES["eguideImg"]["name"];
                // Get file info 
                $guideImgName = $_FILES["eguideImg"]["name"];
                if($guideImgName!=""){
                    //Image is selected
                    //get extension of selected image(jpg,png,gif....)
                    $guideImgName = explode('.', $guideImgName);
                    $ext = end($guideImgName);

                    //create new image name
                    $guideImgName = "guideImg-".mt_rand(00000,99999).".".$ext;

                    //get src path and destination path
                    $src=$_FILES['eguideImg']['tmp_name'];

                    $dst = "./images/guideImg/".$guideImgName;

                    $upload = move_uploaded_file($src, $dst);

                    if($upload==false){
                        $_SESSION['upload'] = "<div class='error><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to upload image.</div>";
                        header('location: guideManage.php');
                        die();
                    }

                    if($currImg!=""){
                        $path = "./images/guideImg/$currImg";
                        $remove = unlink($path);

                        if($remove == false){
                            $_SESSION['remove-failed'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to remove current image.</div>";
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
                    guideCategory='$ecategory',
                    WHERE guideID = $eguideid
                    ";

            $result2 = mysqli_query($con, $sql2);
            if($result2==true){
                $_SESSION['editguide'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='tick' />Post edited successfully.</div>";
                
            } else {
                $_SESSION['editguide'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to edit guide.</div>";
                
            }
        }
        
    ?>
    </body>
</html>