<?php session_start(); ?>
<?php 
include('connectdb.php');
$currentPage = "forum"; 
if(isset($_SESSION['userID'])){
    $userID = $_SESSION['userID'];
}
?>
<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/forum.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <?php include("header.php") ?>
    <?php
        //filter by category and search
        if(isset($_GET['category'])){
            $category_ = $_GET['category'];
            $sql = "SELECT post.*, users.username FROM post JOIN users ON post.userID=users.userID WHERE post.postCategory=$category_ ORDER BY post.postDate DESC";
        } else if(isset($_GET['mypost'])){
            if($_GET['mypost']==true){
                $sql = "SELECT post.*, users.username FROM post 
                        JOIN users ON post.userID=users.userID
                        WHERE post.userID=$userID
                        ORDER BY post.postDate DESC";
            }
        } else if(isset($_GET['search'])){
            $search_val = $_GET['search_val'];
            $sql = "SELECT post.*, users.username FROM post 
                    JOIN users ON post.userID=users.userID
                    WHERE post.postTitle LIKE '%$search_val%'
                    ORDER BY post.postDate DESC";

        } else {
            $sql = "SELECT post.*, users.username FROM post 
                    JOIN users ON post.userID=users.userID
                    ORDER BY post.postDate DESC";
        }
        ?>

        <?php
        //delete post
        if(isset($_POST['action']) && $_POST['action']=="delete"){
            $delpostid = $_POST['delpostID'];
            $sqlDelpost = "DELETE FROM post WHERE postID=$delpostid";
            $resdelpost = mysqli_query($con, $sqlDelpost);
        }

        //edit post
        if(isset($_POST['action']) && $_POST['action'] == "edit" ){
            echo "<script type='text/javascript'>
            $(window).on('load', function() {
                $('#editPostFormContainer').modal('show');
            });
            </script>";
            $editpostid = $_POST['editpostID'];
            $sqlEditpost = "SELECT * FROM post WHERE postID=$editpostid";
            $reseditpost = mysqli_query($con, $sqlEditpost);
            $rowedit = mysqli_fetch_array($reseditpost, MYSQLI_ASSOC);
        }

        ?>
    <div class='forum-container'>
        <div class='tool'>
            <div class='search-box'>
                <form action="" method="GET">  
                    <div class="search">
                        <input type="text" name="search_val" value="<?php if(isset($_GET['search'])){ echo $search_val; } ?>" placeholder="post" />
                        <button type="submit" name="search"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class='forum-category'>
                <a href="forum.php"><h3>All</h3></a>
                <a href="forum.php?category='environment-protection'"><h3>Environment Protection</h3></a>
                <a href="forum.php?category='energy-resource'"><h3>Energy and Resource</h3></a>
                <a href="forum.php?category='waste-recycling'"><h3>Waste Reduction and Recycling</h3></a>
                <a href="forum.php?category='carbon-footprint'"><h3>Carbon Footprint</h3></a>
                <a href="forum.php?category='transportation'"><h3>Transportation</h3></a>
                <a href="forum.php?category='other'"><h3>Other</h3></a>
            </div>
        </div>
        
        <div class='post-container'>
            <div class='post-nav-container'>
                <ul class='post-nav'>
                    <li class=<?php if(!isset($_GET['mypost'])){ echo "active"; } ?>><a href="forum.php"> All Post </a></li>
                    <li class=<?php if(isset($_GET['mypost'])){ echo "active"; } ?>><a href="forum.php?mypost='true'" style="text-decoration: none;"> My Post </a></li>
                </ul>
                <button type="button" class="addpost" data-bs-toggle="modal" data-bs-target="#addPostFormContainer">
                    Create Post
                </button>
            </div>

            <div class='post-list'>
                <?php
                    $result = mysqli_query($con, $sql);
                    $count = mysqli_num_rows($result);
                    if($count > 0){
                        while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                            $postTitle = $row['postTitle'];
                            $postContent = $row['postContent'];
                            $postPic = $row['postPic'];
                            $postUser = $row['username'];
                            $postDate = $row['postDate'];
                ?>
                <div class='post'>
                    <!-- name -->
                    <div class='postInfo'>
                        <span>
                            <div class='postHeader'>
                                <!--<img src='images/icon.png' style='width: 20px; height: 20px; border-radius: 20px; margin-right: 5px'>-->
                                <i class="bi bi-person-circle" style='margin-right: 10px;'></i>
                                <p style='margin: 0 10px 0 0;'><?php echo $postUser; ?></p>
                                <p style='margin: 0;' ><?php echo date("d/m/Y H:i:s", strtotime($postDate)) ?></p>
                            </div>
                            <?php if($userID == $row['userID'] || $_SESSION['role']=="admin" ){ ?>
                                <div class='postFeature'>
                                    <form method="post" action="" >
                                        <input type='hidden' name='action' value='edit' />
                                        <input type='hidden' name='editpostID' value=<?php echo $row['postID']; ?> />
                                        <button type="submit" class='editpost'>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>

                                    <form method="post" action="">
                                        <input type='hidden' name='delpostID' value=<?php echo $row['postID']; ?> />
                                        <input type='hidden' name='action' value='delete' />
                                        <button type="submit" class='delpost' onClick="javascript: return confirm('Please confirm deletion.');">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php } ?>
                        </span>
                    </div>
                    <div class='postDetails'>
                        <div class='word'>
                            <!-- title -->
                            <div class='postTitle'>
                            <?php echo $postTitle; ?>
                            </div>
                            <!-- description -->
                            <div class='postContent'>
                            <?php echo $postContent; ?>
                            </div>
                            <!-- comment -->
                            <div class='interact'>
                                <i class="bi bi-chat-left"></i>   12
                            </div>
                        </div>
                        <!-- picture(optional) -->
                        <div class='postPic'>
                            <?php if($postPic != ""){ ?>
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['postPic']); ?>"  width='100' height='100' alt='tumbnail' />
                            <?php } ?>
                        </div>
                    </div>
               </div>
               <hr>
            
            <?php
                    }}else{
                        echo "<div class='noPost'>No post yet</div>";
                    }
            ?>
               
            </div>
        </div>
    </div>
    <!-- add post modal -->
    <div class="modal fade .modal-dialog-centered" id="addPostFormContainer" tabindex="-1" aria-labelledby="addPostFormContainerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="addPostFormContainerLabel">Create Post</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class='addPostForm' action='' method='post' enctype="multipart/form-data">
            <div>
                <label for='postTitle'>Title:</label></td>
                <input type='text' class='inputPostTitle' id='postTitle' name='postTitle' required /></td>
            </div>
            <div>
                <label for='postContent'>Content:</label></td>
                <textarea class='inputPostContent' id="postContent" name="postContent" rows="4" required></textarea></td>
            </div>
            <div> 
                <label for="postImg">Image: </label></td>
                <input type="file" class='postImg' id="inputPostImg" name="postImg" accept="image/*"/></td>
            </div>
            <div>   
                <label for='category'>Category:</label></td>
                <select name="category" id="category" class='inputCategory'>
                    <option value='environment-protection'>Environment Protection</option>
                    <option value='energy-resource'>Energy and Resource</option>
                    <option value='waste-recycling'>Waste Reduction and Recycling</option>
                    <option value='carbon-footprint'>Carbon Footprint</option>
                    <option value='transportation'>Transportation</option>
                    <option value='other'>Other</option>
                </select>
            </div>      
            
            <div class="submitbtnStyle"><button type="submit" name="addPostSubmit" id="submit" class="submitbtn">Submit</button></div>
        </form>
        </div>
        <!--<div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>-->
        </div>
    </div>
    </div>
    
    <!-- edit post modal -->
    <div class="modal fade .modal-dialog-centered" id="editPostFormContainer" tabindex="-1" aria-labelledby="editPostFormContainerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editPostFormContainerLabel">Edit Post</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class='addPostForm' action='' method='post' enctype="multipart/form-data">
            <div>
                <label for='postTitle'>Title:</label></td>
                <input type='text' class='inputPostTitle' id='postTitle' name='postTitle' value="<?php if(isset($_POST['editpostID'])){ echo $rowedit['postTitle']; } ?>" required /></td>
            </div>
            <div>
                <label for='postContent'>Content:</label></td>
                <textarea class='inputPostContent' id="postContent" name="postContent" rows="4" required><?php if(isset($_POST['editpostID'])){ echo $rowedit['postContent']; } ?></textarea></td>
            </div>
            <div> 
                <label for="postImg">Image: </label></td>
                <input type="file" class='postImg' id="inputPostImg" name="postImg" accept="image/*"/></td>
            </div>
            <div>   
                <label for='category'>Category:</label></td>
                <select name="category" id="category" class='inputCategory'>
                    <option value='environment-protection' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="environment-protection"){ echo "selected"; } ?>>Environment Protection</option>
                    <option value='energy-resource' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="energy-resource"){ echo "selected"; } ?>>Energy and Resource</option>
                    <option value='waste-recycling' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="waste-recycling"){ echo "selected"; } ?>>Waste Reduction and Recycling</option>
                    <option value='carbon-footprint' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="carbon-footprint"){ echo "selected"; } ?>>Carbon Footprint</option>
                    <option value='transportation' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="transportation"){ echo "selected"; } ?>>Transportation</option>
                    <option value='other' <?php if(isset($_POST['editpostID']) && $rowedit['postCategory']=="other"){ echo "selected"; } ?>>Other</option>
                </select>
            </div>      
            
            <div class="submitbtnStyle"><button type="submit" name="editPostSubmit" id="submit" class="submitbtn">Submit</button></div>
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
            $title = $_POST['postTitle'];
            $content = $_POST['postContent'];
            $category = $_POST['category'];

            $status = 'error'; 
            if(!empty($_FILES["postImg"]["name"])) {
                // Get file info 
                $fileName = basename($_FILES["postImg"]["name"]);
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['postImg']['tmp_name']; 
                    $imageContent = addslashes(file_get_contents($image)); 
                    
                    if($insert){ 
                        $status = 'success'; 
                        $statusMsg = "File uploaded successfully."; 
                    }else{ 
                        $statusMsg = "File upload failed, please try again."; 
                    }  
                }else{ 
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
                }
            }else{ 
                $imageContent = "";
            }
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentDate = date('Y-m-d H:i:s');
            $sql1 = "INSERT INTO post(postTitle,postContent,postPic,postCategory,postDate,userID)
                    VALUES ('$title', '$content', '$imageContent', '$category', '$currentDate', '$userID')";

            $result1 = mysqli_query($con, $sql1);
            if($result1==true){
                $_SESSION['add'] = "<div class='success'><img src='../image/tick.png' width='16px' alt='tick' />Post Created Successfully.</div>";
                
            } else {
                $_SESSION['add'] = "<div class='error'><img src='../image/cross.png' width='16px' alt='cross icon'/>Failed to Create Post.</div>";
                
            }
        }

        echo "<div style='font-size: 50px;'>$statusMsg</div>";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>