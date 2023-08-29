<?php session_start();ob_start();
    include("connectdb.php");
    if(isset($_SESSION["userID"])){
        $userID = $_SESSION["userID"];
    }
?>
<!doctype html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/forum.css" />
    <link rel="stylesheet" href="./css/post.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <?php include("header.php"); 
    if(isset($_SESSION['addcomment'])){
        echo $_SESSION['addcomment'];
        unset($_SESSION['addcomment']);
    }
    if(isset($_SESSION['editcomment'])){
        echo $_SESSION['editcomment'];
        unset($_SESSION['editcomment']);
    }
    if(isset($_SESSION['delcomment'])){
        echo $_SESSION['delcomment'];
        unset($_SESSION['delcomment']);
    }
    if(isset($_SESSION['editpost'])){
        echo $_SESSION['editpost'];
        unset($_SESSION['editpost']);
    }
    if(isset($_SESSION['deletePost'])){
        echo $_SESSION['deletePost'];
        unset($_SESSION['deletePost']);
    }
    if(isset($_SESSION['upload'])){
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
    if(isset($_SESSION['remove-failed'])){
        echo $_SESSION['remove-failed'];
        unset($_SESSION['remove-failed']);
    }
    ?>
    <?php include("editpostModal.php"); ?>
    <?php include("editcommentModal.php"); ?>
    <?php 
        if(isset($_GET["postID"])){
            $postID = $_GET["postID"];
            $sql = "SELECT post.*, users.username, users.userImage, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    WHERE post.postID=$postID
                    GROUP BY postID";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $postTitle = $row['postTitle'];
            $postContent = $row['postContent'];
            $postImg = $row['postPic'];
            $postDate = $row['postDate'];
            $postUser = $row['username'];
            $postUserImg = $row['userImage'];
        } else {
            header("location:forum.php");
        }
    ?>
    <?php
        //add comment
        if(isset($_POST['submitComment'])){
            $addcomment = $_POST['postComment'];
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentTime = date('Y-m-d H:i:s');
            $pid = $_POST['pid'];
            $addComsql = "INSERT INTO comments(commentContent, commentDate, userID, postID) 
                        VALUES ('$addcomment', '$currentTime', $userID, $pid)";
            $resAddComment = mysqli_query($con, $addComsql);
            if($resAddComment==true){
                $_SESSION['addcomment'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='tick' />Comment added successfully.</div>";
                
            } else {
                $_SESSION['addcomment'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to add comment.</div>";
                
            }
            echo "<meta http-equiv='refresh' content='0'>";
        }
    ?>
    <?php
        //delete comment
        if(isset($_POST['delcommentID'])){
            echo "<meta http-equiv='refresh' content='0'>";
            $delcommentid = $_POST['delcommentID'];
            $sqlDelcomment = "DELETE FROM comments WHERE commentID=$delcommentid";
            $resdelcomment = mysqli_query($con, $sqlDelcomment);
            if($resdelcomment){
                $_SESSION['delcomment'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='tick' />Comment deleted successfully.</div>";
            } else {
                $_SESSION['delcomment'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to delete comment.</div>";
            }
        }

    ?>
    <?php
        //delete post
        if(isset($_POST['action']) && $_POST['action']=="delete"){
            $delpostid = $_POST['delpostID'];
            $delpostImg = $_POST['delpostImg'];
            if($delpostImg != ""){
                $path = "./images/postImg/$delpostImg";
                $remove = unlink($path);
        
                if($remove==false){
                    $_SESSION['deletePost'] = "<div><img src='./images/cross.png' width='16px' alt='cross icon' />Failed to remove picture</div>";
                    header("location: forum.php");
                    die();
                }
            }
            $sqlDelpost = "DELETE FROM post WHERE postID=$delpostid";
            $resdelpost = mysqli_query($con, $sqlDelpost);
            if($resdelpost){
                $_SESSION['deletePost'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='cross icon' />Post deleted successfully.</div>";
                header("location: forum.php");
            } else{
                $_SESSION['deletePost'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon' />Failed to delete post.</div>";
                header("location: forum.php");
            }
        }
        ?>
    
    <div class="forum-container">
        <div class="tool">
            <div class="search-box">
                <form action="" method="GET">  
                    <div class="search">
                        <input type="text" name="search_val" value="<?php if(isset($_GET["search"])){ echo $search_val; } ?>" placeholder="post" />
                        <button type="submit" name="search"><i class="bi bi-search" style="color: whitesmoke"></i></button>
                    </div>
                </form>
            </div>
            <div class="forum-category">
                <h5>Category</h5>
                <hr>
                <a href="forum.php"><h3>All</h3></a>
                <a href="forum.php?category='environment-protection'"><h3>Environment Protection</h3></a>
                <a href="forum.php?category='energy-resource'"><h3>Energy and Resource</h3></a>
                <a href="forum.php?category='waste-recycling'"><h3>Waste Reduction and Recycling</h3></a>
                <a href="forum.php?category='carbon-footprint'"><h3>Carbon Footprint</h3></a>
                <a href="forum.php?category='transportation'"><h3>Transportation</h3></a>
                <a href="forum.php?category='other'"><h3>Other</h3></a>
            </div>
        </div>
        
        <div class="post-container">
            <div class="post-content-container">
                <div class="post-header">
                    <div class="postUserInfo">
                        <img src="images/profileImg/<?php if(!$postUserImg){echo 'defaultprofile.png';}else{echo $postUserImg;}?>" alt="userImg" style='width: 40px; height: 40px; border-radius: 20px; margin-right: 10px'>
                        <!-- <i class="bi bi-person-circle" style='margin: 0 10px; font-size: 30px;'></i> -->
                        <span class="post_user_date">
                            <div>
                                <?php echo $postUser; ?>
                            </div>
                            <div>
                                <?php echo $postDate; ?>
                            </div>
                        </span>
                    </div>
                    <?php if($userID == $row['userID'] || $_SESSION['role']=="admin" ){ ?>
                        <div class='postFeature'>
                            <i class="bi bi-three-dots threeDotImg"></i>
                            <div class="dropdownContainer">
                                <form method="post" action="" >
                                    <input type='hidden' name='action' value='edit' />
                                    <input type='hidden' name='editpostID' value=<?php echo $row['postID']; ?> />
                                    <button type="submit" class='editpost'>
                                        <i class="bi bi-pencil-square"></i>Edit Post
                                    </button>
                                </form>

                                <form method="post" action="">
                                    <input type='hidden' name='delpostID' value=<?php echo $row['postID']; ?> />
                                    <input type='hidden' name='delpostImg' value="<?php echo $row['postPic']; ?>" />
                                    <input type='hidden' name='action' value='delete' />
                                    <button type="submit" class='delpost' onClick="javascript: return confirm('Please confirm deletion.');">
                                        <i class="bi bi-trash"></i>Delete Post
                                    </button>
                                </form>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                            var dropdownbtns = document.querySelectorAll(".postFeature");

                            dropdownbtns.forEach(function(dropdownbtn) {
                                dropdownbtn.addEventListener('click', function(event) {
                                    event.stopPropagation(); // Prevent the click from propagating to the window
                                    this.classList.toggle("dropActive");
                                });
                            });

                            window.onclick = function(event) {
                                if (!event.target.matches('.postFeature')) {
                                    var dropdowns = document.getElementsByClassName("postFeature");
                                    for (var i = 0; i < dropdowns.length; i++) {
                                        var openDropdown = dropdowns[i];
                                        if (openDropdown.classList.contains('dropActive')) {
                                            openDropdown.classList.remove('dropActive');
                                        }
                                    }
                                }
                            };
                        });
                        </script>
                    <?php } ?>
                </div>
                <div class="post-bodyContent">
                    <div class='post-title'>
                        <?php echo $postTitle; ?>
                    </div>
                    <!-- description -->
                    <div class='post-content'>
                        <?php echo $postContent; ?>
                    </div>
                    <?php if($postImg!=""){ ?>
                        <div class="post-image">
                            <img src="./images/postImg/<?php echo $postImg ?>" alt="post-pic" width="100%" height="400px" />
                        </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <div class="post-comment-container">
                <div style="margin: 0 0 10px 0" >Total <?php echo $row['commentNum']; ?> comments</div>
                <div class="addcomment">
                    <img src="images/profileImg/<?php echo (isset($_SESSION['userImage'])&& $_SESSION['userImage']!="") ?  $_SESSION['userImage'] : 'defaultprofile.png'; ?>" alt="userImg" style='width: 40px; height: 40px; border-radius: 20px; margin-right: 5px'>
                    <!-- <i class="bi bi-person-circle" style='margin: 0 10px; font-size: 30px;'></i> -->
                    <form action="" method="post">
                        <input type="text" name="postComment" class="commentInput" required />
                        <input type="hidden" name="pid" value="<?php echo $postID ?>"/>
                        <input type="submit" name="submitComment" value="Add Comment" class="submitCommentBtn"/>
                    </form>
                </div>
                <div class="comment-list">
                    <?php
                    $sql = "SELECT comments.*, users.username, users.userImage FROM comments
                            LEFT JOIN users ON comments.userID=users.userID
                            WHERE postID=$postID
                            ORDER BY comments.commentDate DESC";
                    $result = mysqli_query($con, $sql);
                    $count = mysqli_num_rows($result);
                    if($count>0){
                        while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        $commentID = $row['commentID'];
                        $cusername = $row['username'];
                        $ctime = $row['commentDate'];
                        $commentContent = $row['commentContent'];
                    ?>
                    <div class="comment">
                        <div class="commentUser">
                            <img src="images/profileImg/<?php if(!$row['userImage']){echo 'defaultprofile.png';}else{echo $row['userImage'];}?>" alt="userImg" style='width: 40px; height: 40px; border-radius: 20px; margin-right: 5px'>
                            <!-- <i class="bi bi-person-circle" style='margin: 0 10px; font-size: 30px;'></i> -->
                            <p style='margin: 0 10px 0 0; font-weight: bold;'><?php echo $cusername; ?></p>
                            <p style='margin: 0;'><?php echo $ctime; ?></p>
                        </div>
                        <div class="comment-content">
                            <p style='margin: 0 0 5px 0;'><?php echo $commentContent; ?></p>
                        </div>
                        <div class="comment-feature">
                        <?php if($userID == $row['userID'] || $_SESSION['role']=="admin" ){ ?>
                            <form method="post" action="">
                                <input type='hidden' name='editcommentID' value='<?php echo $row['commentID']; ?>' />
                                <button type="submit" class='editcomment'>
                                    <i class="bi bi-pencil-square"></i>Edit
                                </button>
                            </form>
                            <form method="post" action="">
                                <input type='hidden' name='delcommentID' value='<?php echo $row['commentID']; ?>' />
                                <button type="submit" class='delcomment' onClick="javascript: return confirm('Please confirm deletion.');">
                                    <i class="bi bi-trash"></i>Delete
                                </button>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }} else {
                        echo "<div style='text-align: center;'>No comment yet</div>";
                    }?>
                </div>
            </div>
        </div>
        <div class="layerThree">
            <div class="forumStatistic">
                <h5>Forum statistic</h5>
                <hr>
                <?php 
                $sqlnumpost="SELECT * FROM post";
                $numpostResult=mysqli_query($con, $sqlnumpost);
                $tnumpost=mysqli_num_rows($numpostResult);
                ?>
                <?php 
                date_default_timezone_set('Asia/Kuala_Lumpur');
                $todayDate=date("Y-m-d 00:00:00");
                $sqlnumpost="SELECT * FROM post WHERE postDate>='$todayDate'";
                $numpostResult=mysqli_query($con, $sqlnumpost);
                $dnumpost=mysqli_num_rows($numpostResult);
                ?>
                <?php 
                $sqlnumUser="SELECT * FROM users";
                $numUserResult=mysqli_query($con, $sqlnumUser);
                $numUser=mysqli_num_rows($numUserResult);
                ?>
                <table class="statisticInfo">
                    <tr>
                        <td>Total posts: </td>
                        <td><?php echo $tnumpost; ?></td>
                    </tr>
                    <tr>
                        <td>Today posts: </td>
                        <td><?php echo $dnumpost; ?></td>
                    </tr>
                    <tr>
                        <td>Total users: </td>
                        <td> <?php echo $numUser; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php ob_end_flush(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>