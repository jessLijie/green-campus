<?php session_start(); ob_start();?>
<?php 
include('connectdb.php');
$currentPage = "forum"; 
if(isset($_SESSION['userID'])){
    $userID = $_SESSION['userID'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/forum.css" />
    <title>Greenify UTM</title>
</head>
<body>
    <?php include("header.php");
    if(isset($_SESSION['addpost'])){
        echo $_SESSION['addpost'];
        unset($_SESSION['addpost']);
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
    <?php
        //filter by category and search
        if(isset($_GET['category'])){
            $category_ = $_GET['category'];
            $sql = "SELECT post.*, users.username, users.userImage, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    WHERE post.postCategory='$category_'
                    GROUP BY postID
                    ORDER BY post.postDate DESC";

        } else if(isset($_GET['mypost'])){
            if($_GET['mypost']==true){
                $sql = "SELECT post.*, users.username, users.userImage, COUNT(comments.commentID) AS commentNum FROM post 
                        LEFT JOIN users ON post.userID=users.userID
                        LEFT JOIN comments ON comments.postID=post.postID
                        WHERE post.userID=$userID
                        GROUP BY postID
                        ORDER BY post.postDate DESC";
            }
        } else if(isset($_GET['search'])){
            $search_val = $_GET['search_val'];
            $sql = "SELECT post.*, users.username, users.userImage, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    WHERE post.postTitle LIKE '%$search_val%'
                    GROUP BY postID
                    ORDER BY post.postDate DESC";

        } else {
            $sql = "SELECT post.*, users.username, users.userImage, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    GROUP BY postID
                    ORDER BY post.postDate DESC";
        }
        ?>
        <?php
        include("editPost.php");
        ?>

    <div class='forum-container'>
        <div class='tool'>
            <div class='search-box'>
                <form action="" method="GET">  
                    <div class="search">
                        <input type="text" name="search_val" value="<?php if(isset($_GET['search'])){ echo $search_val; } ?>" placeholder="Search Post" />
                        <button type="submit" name="search"><i class="bi bi-search" style="color: whitesmoke"></i></button>
                    </div>
                </form>
            </div>
            <div class='forum-category'>
                <h5>Category</h5>
                <hr>
                <a href="forum.php"><h3>All</h3></a>
                <a href="forum.php?category=environment-protection"><h3>Environment Protection</h3></a>
                <a href="forum.php?category=energy-resource"><h3>Energy and Resource</h3></a>
                <a href="forum.php?category=waste-recycling"><h3>Waste Reduction and Recycling</h3></a>
                <a href="forum.php?category=carbon-footprint"><h3>Carbon Footprint</h3></a>
                <a href="forum.php?category=transportation"><h3>Transportation</h3></a>
                <a href="forum.php?category=other"><h3>Other</h3></a>
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
                ?>
                <div class="posthover">
                <div class='post'>
                    <div class='postHeader'>
                        <span>
                            <div class='postInfo'>
                                <img src="images/profileImg/<?php if(!$row['userImage']){echo 'defaultprofile.png';}else{echo $row['userImage'];}?>" alt="userImg" style='width: 20px; height: 20px; border-radius: 20px; margin-right: 10px'>
                                <p style='margin: 0 10px 0 0;'><?php echo $row['username']; ?></p>
                                <p style='margin: 0;' ><?php echo date("d/m/Y H:i:s", strtotime($row['postDate'])) ?></p>
                            </div>
                            <?php if($userID == $row['userID'] || $_SESSION['role']=="admin" ){ ?>
                                
                                <div class="postFeature">
                                    <i class="bi bi-three-dots threeDotImg"></i>
                                    <div class="dropdownContainer">
                                        <button class='editpost' data-bs-toggle="modal" data-bs-target="#editPostFormContainer<?php echo $row["postID"]; ?>" >
                                            <i class="bi bi-pencil-square"></i>Edit Post
                                        </button>
                                        <button class='delpost' data-bs-toggle="modal" data-bs-target="#deletePostFormContainer<?php echo $row["postID"]; ?>" >
                                            <i class="bi bi-trash"></i>Delete Post
                                        </button>
                                    </div>
                                </div>

                            <?php } ?>
                        </span>
                    </div>
                    <a href="post.php?postID='<?php echo $row['postID']; ?>'" class="postlink">
                        <div class='postDetails'>
                            <div class='word'>
                                <div class='postTitle'>
                                <?php echo $row['postTitle']; ?>
                                </div>
                                <div class='postContent'>
                                    <p class="pcontent">
                                        <?php echo $row['postContent']; ?>
                                    </p>
                                </div>
                                <div class='interact'>
                                    <span><i class="bi bi-chat-dots" style="margin-right: 10px;"></i><?php echo $row['commentNum']; ?></span>
                                </div>
                            </div>
                            <div class='postPic'>
                                <?php if($row['postPic'] != ""){ ?>
                                    <img src="<?php echo './images/postImg/' . $row['postPic']; ?>"  width='100' height='100' alt='thumbnail' />
                                <?php } ?>
                            </div>
                        </div>
                    </a>
               </div>
                </div>
               <hr>
                
            <?php
                    include("deletePostModal.php");
                    include('editpostModal.php');
                }}else{
                    echo "<div class='noPost'>No post yet</div>";
                }
            ?> 
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
    <?php 
        include('addpostModal.php');
    ?>

    <script>
            document.addEventListener('DOMContentLoaded', function() {
            var dropdownbtns = document.querySelectorAll(".postFeature");
            
            dropdownbtns.forEach(function(dropdownbtn) {
                dropdownbtn.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent the click from propagating to the window
                    // Close all other open dropdowns
                    closeAllDropdownsExcept(this);
                    if(this.classList.contains("dropActive")){
                        this.classList.remove("dropActive");
                    }else{
                        this.classList.add("dropActive");
                    }
                    
                });
            });

            window.onclick = function(event) {
                var dropdowns = document.getElementsByClassName("postFeature");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('dropActive')) {
                        openDropdown.classList.remove('dropActive');
                    }
                }
            };
            
            function closeAllDropdownsExcept(keepOpen) {
                dropdownbtns.forEach(function(dropdownbtn) {
                    if (dropdownbtn !== keepOpen && dropdownbtn.classList.contains('dropActive')) {
                        dropdownbtn.classList.remove('dropActive');
                    }
                });
            }

            var statusMessageBox = document.querySelector('.statusMessageBox1');
            if(statusMessageBox){
                setTimeout(function() {
                    statusMessageBox.classList.add("slideOut");
                }, 4000);
            }
            var progressbar = document.querySelector('.progressbar.active');
            if (progressbar) {
                setTimeout(function() {
                    progressbar.classList.remove("active");
                    statusMessageBox.remove();
                }, 4500);
            }

            var toastCloseButtons = document.querySelectorAll('.toast-close');
            toastCloseButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var statusMessageBox = document.querySelector('.statusMessageBox1');
                    statusMessageBox.classList.add("slideOut");

                    setTimeout(function() {
                        progressbar.classList.remove("active");
                        statusMessageBox.remove();
                    }, 300);
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>