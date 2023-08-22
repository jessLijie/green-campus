<?php session_start(); ?>
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/forum.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Greenify UTM</title>
</head>
<body>
    <?php include("header.php") ?>
    <?php
        //filter by category and search
        if(isset($_GET['category'])){
            $category_ = $_GET['category'];
            $sql = "SELECT post.*, users.username, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    WHERE post.postCategory=$category_
                    GROUP BY postID
                    ORDER BY post.postDate DESC";

        } else if(isset($_GET['mypost'])){
            if($_GET['mypost']==true){
                $sql = "SELECT post.*, users.username, COUNT(comments.commentID) AS commentNum FROM post 
                        LEFT JOIN users ON post.userID=users.userID
                        LEFT JOIN comments ON comments.postID=post.postID
                        WHERE post.userID=$userID
                        GROUP BY postID
                        ORDER BY post.postDate DESC";
            }
        } else if(isset($_GET['search'])){
            $search_val = $_GET['search_val'];
            $sql = "SELECT post.*, users.username, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    WHERE post.postTitle LIKE '%$search_val%'
                    GROUP BY postID
                    ORDER BY post.postDate DESC";

        } else {
            $sql = "SELECT post.*, users.username, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    GROUP BY postID
                    ORDER BY post.postDate DESC";
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
                    $_SESSION['delete'] = "<div><img src='./images/cross.png' width='16px' alt='cross icon' />Failed to remove picture</div>";
                    header("location: forum.php");
                    die();
                }
            }
            $sqlDelpost = "DELETE FROM post WHERE postID=$delpostid";
            $resdelpost = mysqli_query($con, $sqlDelpost);
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
            <hr style="color: whitesmoke;">
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
                            $postID = $row['postID'];
                            $postTitle = $row['postTitle'];
                            $postContent = $row['postContent'];
                            $postPic = $row['postPic'];
                            $postUser = $row['username'];
                            $postDate = $row['postDate'];
                ?>
                <div class='post'>
                    <!-- name -->
                    <div class='postHeader'>
                        <span>
                            <div class='postInfo'>
                                <!--<img src='images/icon.png' style='width: 20px; height: 20px; border-radius: 20px; margin-right: 5px'>-->
                                <i class="bi bi-person-circle" style='margin-right: 10px;'></i>
                                <p style='margin: 0 10px 0 0;'><?php echo $postUser; ?></p>
                                <p style='margin: 0;' ><?php echo date("d/m/Y H:i:s", strtotime($postDate)) ?></p>
                            </div>
                            <?php if($userID == $row['userID'] || $_SESSION['role']=="admin" ){ ?>
                                <div class='postFeature'>
                                    <i class="bi bi-three-dots threeDotImg"></i>
                                    <div class="dropdownContainer">
                                        <form method="post" action="" >
                                            <input type='hidden' name='action' value='edit' />
                                            <input type='hidden' name='editpostID' value='<?php echo $row['postID']; ?>' />
                                            <button type="submit" class='editpost'>
                                                <i class="bi bi-pencil-square"></i>Edit Post
                                            </button>
                                        </form>

                                        <form method="post" action="">
                                            <input type='hidden' name='delpostID' value='<?php echo $row['postID']; ?>' />
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
                                        
                                        // Close all other open dropdowns
                                        closeAllDropdownsExcept(this);
                                        this.classList.add("dropActive");
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
                            });

                            </script>
                            <?php } ?>
                        </span>
                    </div>
                    <a href="post.php?postID='<?php echo $postID ?>'" class="postlink">
                        <div class='postDetails'>
                            <div class='word'>
                                <!-- title -->
                                <div class='postTitle'>
                                <?php echo $postTitle; ?>
                                </div>
                                <!-- description -->
                                <div class='postContent'>
                                    <p class="pcontent">
                                        <?php echo $postContent; ?>
                                    </p>
                                </div>
                                <!-- comment -->
                                <div class='interact'>
                                    <span><i class="bi bi-chat-left"></i> <?php echo $row['commentNum']; ?></span>
                                </div>
                            </div>
                            <!-- picture(optional) -->
                            <div class='postPic'>
                                <?php if($postPic != ""){ ?>
                                    <img src="<?php echo "./images/postImg/$postPic"; ?>"  width='100' height='100' alt='tumbnail' />
                                <?php } ?>
                            </div>
                        </div>
                    </a>
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
    <?php 
        include('addpostModal.php');
        include('editpostModal.php') 
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>