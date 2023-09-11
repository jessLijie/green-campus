<html>
    <head>
        <style>
            .modalForm div{
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
    <!-- add guide modal -->
    <div class="modal fade .modal-dialog-centered" id="addGuideFormContainer" tabindex="-1" aria-labelledby="addPostFormContainerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="addGuideFormContainer">Add Guide</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class="modalForm" action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="guideTitle" class="form-label" >Title:</label>
                <input type="text" class="form-control" id="guideTitle" name="guideTitle" required />
            </div>
            <div>
                <label for="guideContent" class="form-label">Content:</label>
                <textarea class="form-control" id="guideContent" name="guideContent" rows="6" required></textarea>
            </div>
            <div> 
                <label for="guideImg" class="form-label">Image: </label>
                <input type="file" class="form-control" id="guideImg" name="guideImg" accept="image/*"/>
            </div>
            <div>   
                <label for='category' class="form-label">Category:</label>
                <select name="category" id="category" class='form-select'>
                    <option value='<?php echo htmlspecialchars("Environment Protection"); ?>'>Environment Protection</option>
                    <option value='<?php echo htmlspecialchars("Energy and Resource"); ?>'>Energy and Resource</option>
                    <option value='<?php echo htmlspecialchars("Waste Reduction and Recycling"); ?>'>Waste Reduction and Recycling</option>
                    <option value='<?php echo htmlspecialchars("Carbon Footprint"); ?>'>Carbon Footprint</option>
                    <option value='Transportation'>Transportation</option>
                    <option value='Other'>Other</option>
                </select>
            </div>      
            
            <div style="text-align: center; margin: 30px auto 10px;"><button type="submit" name="addGuideSubmit" id="submit" class="btn btn-outline-success">Submit</button></div>
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
    if(isset($_POST['addGuideSubmit'])){
        echo "<meta http-equiv='refresh' content='0'>";
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
            
        }
    }
    ?>
    </body>
</html>