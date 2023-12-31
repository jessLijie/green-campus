<html>
    <head>
        <style>
            .modalForm div{
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <!-- edit post modal -->
        <div class="modal fade .modal-dialog-centered" id="editPostFormContainer<?php echo $row["postID"]; ?>" tabindex="-1" aria-labelledby="editPostFormContainerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editPostFormContainerLabel"><i class="bi bi-pencil-square"style="margin-right: 5px;" ></i>Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="modalForm" action="" method="post" enctype="multipart/form-data">
                        <div>
                            <label for="epostTitle" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="epostTitle" name="epostTitle" value="<?php echo $row['postTitle']; ?>" required />
                        </div>
                        <div>
                            <label for="epostContent" class="form-label">Content:</label>
                            <textarea class="form-control" id="epostContent" name="epostContent" rows="4" required><?php echo $row['postContent']; ?></textarea>
                        </div>
                        <div> 
                            <p style="margin: 0 0 8px 0;">Current Image: </p>
                            <?php
                                $currentImg = $row['postPic'];
                                if($currentImg==""){
                                    echo "<div class='imgerror'>Image Not Available.</div>";
                                } else {
                                    echo "<img src='./images/postImg/$currentImg' alt='post_picture' style='width:130px; max-height: 200px'/>";
                                }
                            ?>
                        </div>
                        <div> 
                            <label for="epostImg" class="form-label">New Image: </label>
                            <input type="file" class='form-control' id="epostImg" name="epostImg" accept="image/*"/>
                        </div>
                        <div>   
                            <label for="category" class="form-label">Category:</label>
                            <select name="ecategory" id="category" class='form-select'>
                                <option value='Environment Protection' <?php if($row['postCategory']=="Environment Protection"){ echo "selected"; } ?>>Environment Protection</option>
                                <option value='Energy and Resource' <?php if($row['postCategory']=="Energy and Resource"){ echo "selected"; } ?>>Energy and Resource</option>
                                <option value='Waste Reduction and Recycling' <?php if($row['postCategory']=="Waste Reduction and Recycling"){ echo "selected"; } ?>>Waste Reduction and Recycling</option>
                                <option value='Carbon Footprint' <?php if($row['postCategory']=="Carbon Footprint"){ echo "selected"; } ?>>Carbon Footprint</option>
                                <option value='Transportation' <?php if($row['postCategory']=="Transportation"){ echo "selected"; } ?>>Transportation</option>
                                <option value='Other' <?php if($row['postCategory']=="Other"){ echo "selected"; } ?>>Other</option>
                            </select>
                        </div>
                        <input type="hidden" name="eid" value="<?php echo $row["postID"]; ?>" />
                        <input type="hidden" name="currentImg" value="<?php echo $currentImg; ?>" />
                        <div style="text-align: center; margin: 30px auto 10px;"><button type="submit" name="editPostSubmit" id="submit" class="btn btn-outline-success">Submit</button></div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
</html>