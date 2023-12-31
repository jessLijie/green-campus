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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/forum.css" />
    <link rel="stylesheet" href="./css/post.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <?php include("header.php"); 
    
    if(isset($_SESSION['editpost'])){
        echo $_SESSION['editpost'];
        unset($_SESSION['editpost']);
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
        if(isset($_GET["postID"])){
            $postID = $_GET["postID"];
            $sql = "SELECT post.*, users.username, users.userImage, COUNT(comments.commentID) AS commentNum FROM post 
                    LEFT JOIN users ON post.userID=users.userID
                    LEFT JOIN comments ON comments.postID=post.postID
                    WHERE post.postID=$postID
                    GROUP BY postID";
            $resultPost = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($resultPost);
            $postID = $row['postID'];
            $postIDjs = json_encode($postID);
            $postTitle = $row['postTitle'];
            $postContent = $row['postContent'];
            $postImg = $row['postPic'];
            $postDate = $row['postDate'];
            $postUserID = $row['userID'];
            $postUser = $row['username'];
            $postUserImg = $row['userImage'];
            include("deletePostModal.php");
            include("editpostModal.php");
        } else {
            header("location:forum.php");
        }
    ?>
    <?php
        include("editPost.php");
        ?>
    <div class="statusMessageBox">
        <div class="toast-content">
        <i class="bi bi-check2 toast-icon"></i>
        <div class="message">
            <span class="message-text text-1"></span>
            <span class="message-text text-2"></span>
        </div>
        </div>
        <i class="bi bi-x toast-close"></i>
        <div class="progressbar"></div>
  </div>

    <div class="forum-container">
        <div class="tool">
            <div class="search-box">
                <form action="forum.php" method="GET">  
                    <div class="search input-group">
                        <input type="text" class="form-control" name="search_val" value="<?php if(isset($_GET['search'])){ echo $search_val; } ?>" placeholder="Search Post" />
                        <button type="submit" class="btn" name="search"><i class="bi bi-search" style="color: whitesmoke"></i></button>
                    </div>
                </form>
            </div>
            <div class="forum-category">
                <h5>Category</h5>
                <hr>
                <a href="forum.php"><h3>All</h3></a>
                <a href="forum.php?category=Environment Protection"><h3>Environment Protection</h3></a>
                <a href="forum.php?category=Energy and Resource"><h3>Energy and Resource</h3></a>
                <a href="forum.php?category=Waste Reduction and Recycling"><h3>Waste Reduction and Recycling</h3></a>
                <a href="forum.php?category=Carbon Footprint"><h3>Carbon Footprint</h3></a>
                <a href="forum.php?category=Transportation"><h3>Transportation</h3></a>
                <a href="forum.php?category=Other"><h3>Other</h3></a>
            </div>
        </div>
        
        <div class="post-container">
            <div class="post-content-container">
                <div class="post-header">
                    <div class="postUserInfo">
                        <img src="images/profileImg/<?php if(!$postUserImg){echo 'defaultprofile.png';}else{echo $postUserImg;}?>" alt="userImg" style='width: 40px; height: 40px; border-radius: 20px; margin-right: 10px'>
                        <span class="post_user_date">
                            <div>
                                <?php echo $postUser; ?>
                            </div>
                            <div>
                                <?php echo $postDate; ?>
                            </div>
                        </span>
                    </div>
                    <?php if($userID == $postUserID || $_SESSION['role']=="admin" ){ ?>
                        <div class='postFeature'>
                            <i class="bi bi-three-dots threeDotImg"></i>
                            <div class="dropdownContainer">
                                <button class='editpost' data-bs-toggle="modal" data-bs-target="#editPostFormContainer<?php echo $postID; ?>" >
                                    <i class="bi bi-pencil-square"></i>Edit Post
                                </button>
                                <button class='delpost' data-bs-toggle="modal" data-bs-target="#deletePostFormContainer<?php echo $row["postID"]; ?>" >
                                    <i class="bi bi-trash"></i>Delete Post
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="post-bodyContent">
                    <div class='post-title'>
                        <?php echo $postTitle; ?>
                    </div>

                    <div class='post-content'>
                        <?php echo $postContent; ?>
                    </div>
                    <?php if($postImg!=""){ ?>
                        <div class="post-image">
                            <img src="./images/postImg/<?php echo $postImg; ?>" alt="post-pic" width="100%" height="400px" />
                        </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <div class="post-comment-container">
                <div style="margin: 0 0 10px 0" >Total <p style="display: inline;" id="commentCount"><?php echo $row['commentNum']; ?></p> comments</div>
                <div class="addcomment">
                    <img src="images/profileImg/<?php echo (isset($_SESSION['userImage'])&& $_SESSION['userImage']!="") ?  $_SESSION['userImage'] : 'defaultprofile.png'; ?>" alt="userImg" style='width: 40px; height: 40px; border-radius: 20px; margin-right: 5px'>
                    <form action="" method="post" id="commentForm">
                        <input type="text" name="postComment" class="commentInput" required autocomplete="off"/>
                        <input type="hidden" name="pid" value="<?php echo $postID; ?>"/>
                        <input type="hidden" name="parent_commentID" id="commentID" value='0'/>
                        <input type="submit" name="submitComment" value="Add Comment" class="submitCommentBtn"/>
                    </form>
                </div>
                <div class="comment-list" id="comment-list">
                    <!-- comment list container -->
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
                        <td> <?php echo $numUser;?></td>
                    </tr>
                </table>
            </div>
            <?php
                $sqlrecommend = "SELECT * FROM post WHERE postID!=$postID ORDER BY RAND () LIMIT 3";
                $resultrecommend = mysqli_query($con, $sqlrecommend);
                if(mysqli_num_rows($resultrecommend)>0){
                ?>
                <div class="recommend-post">
                    <h5>Recommend Post</h5>
                    <hr>
                    <?php
                    echo "<div class='recommendPostList'>";
                    while($row=mysqli_fetch_assoc($resultrecommend)){
                        ?> 
                        <a class="rpost" href="forumPost.php?postID='<?php echo $row['postID']; ?>'">
                            <img src="./images/postImg/<?php echo $row['postPic']; ?>" alt="postPic" height="50px" width="50px"/>
                            <p style="margin: 0 0 0 5px;"><?php echo $row['postTitle']; ?></p>
                        </a>
                        <hr>
                        <?php
                    }
                    echo "</div>";
                }
            ?>
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){ 
            showComments();
            $('#commentForm').on('submit', function(event){
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "addcomments.php",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success:function(response) {
                        if(!response.error) {
                            $('#commentForm')[0].reset();
                            $('#commentId').val(0);
                            var currentCount = parseInt($("#commentCount").text());
                            $("#commentCount").text(currentCount + 1);
                            //status
                            showSuccessMessage(response);
                            showComments();
                        } else if(response.error){
                            showErrorMessage(response);
                            showComments();
                        }
                    }
                })
            });

            $(document).on('submit', '#editCommentForm', function(event){
                event.preventDefault();
                var formData = $(this).serialize();
                $(this).closest(".modal").modal('hide');

                $.ajax({
                    url: "editComment.php",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success:function(response) {
                        if(!response.error) {
                            $('#editCommentForm')[0].reset();
                            //status
                            showSuccessMessage(response);
                            showComments();
                        } else if(response.error){
                            showErrorMessage(response);
                            showComments();
                        }
                    }
                })
            });	

            $(document).on('submit','#delcommentForm', function(event){
                event.preventDefault();
                var formData = $(this).serialize();
                var additionalData = {
                    postID: <?php echo $postIDjs; ?>
                };
                var requestData = $.param(additionalData) + '&' + formData;
                $.ajax({
                    url: "deleteComment.php",
                    method: "POST",
                    data: requestData,
                    dataType: "json",
                    success:function(response) {
                        if(!response.error) {
                            $('#delcommentForm')[0].reset();
                            $("#commentCount").text(response.commentCount);
                            //status
                            showSuccessMessage(response);
                            showComments();
                        } else if(response.error){
                            showErrorMessage(response);
                            showComments();
                        }
                    }
                })
            });
            
            $(document).on('submit', '#replyForm', function(e){
                e.preventDefault();
                var parentCommentID = $(this).find('#parent_commentID').val();
                var formData = $(this).serialize();
                var comment = $(this).closest('.comment');
                $.ajax({
                    url: "addcomments.php",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    success:function(response) {
                    if(!response.error) {
                        var currentCount = parseInt($("#commentCount").text());
                        $("#commentCount").text(currentCount + 1);
                        //status
                        showSuccessMessage(response);
                        var commentReplies = $('.comment-replies[data-comment-id="' + parentCommentID + '"]');
                        if (commentReplies.length === 0) {
                            commentReplies = $('<div class="comment-replies" data-comment-id="' + parentCommentID + '"></div>');
                            commentReplies.insertAfter(comment);
                        }
                        $('.comment-replies[data-comment-id="' + parentCommentID + '"]').show();
                        showComments();
                        
                    } else if(response.error){
                        showErrorMessage(response);
                        showComments();
                    }
                }
                })
            });

            $(document).on('click', '.showRepliesbtn', function(){
                var repliesContainer = $(this).next('.comment-replies');
                //repliesContainer.slideToggle();
                repliesContainer.slideToggle("fast", "swing", function() {
                    // Check the current visibility state
                    var isVisible = $(this).is(":visible");
                    // Set button text based on visibility state
                    if (isVisible) {
                        $(this).prev('.showRepliesbtn').html('<i class="bi bi-caret-up-fill"></i> Hide Replies');
                    } else {
                        $(this).prev('.showRepliesbtn').html('<i class="bi bi-caret-down-fill"></i> Show Replies');
                    }
                });
            });

            $(document).on('click', '.comment-feature', function(){
                closeAllDropdownsExcept(this);
                this.classList.toggle("dropActive");
            });

            $(document).on('click', '.postFeature', function(){
                closeAllDropdownsExcept(this);
                this.classList.toggle("dropActive");
            });

            $(document).on('click', '.replyToggleBtn', function(){
                this.classList.toggle("repActive");
            });

            $(document).on('click', '.closeReplybtn', function(){
                $(this).closest(".replyForm").prev(".replyToggleBtn.repActive").removeClass('repActive');
            });

            function showSuccessMessage(response){
                $('.statusMessageBox').addClass("active");
                $('.toast-icon').css('background-color', '#40f467');
                $('.message-text.text-1').text(response.message['title']);
                $('.message-text.text-2').text(response.message['content']);
                $('.progressbar').addClass("active");
                $('.progressbar').css('background-color', '#40f467');
                setTimeout(function() {
                    $('.statusMessageBox').removeClass("active");
                }, 4000);

                setTimeout(function() {
                    $('.progressbar').removeClass("active");
                }, 4300);
                $('.toast-close').on("click", function() {
                    $('.statusMessageBox').removeClass("active");

                    setTimeout(function() {
                        $('.progressbar').removeClass("active");
                    }, 300);
                });
            }
            function showErrorMessage(response){
                $('.statusMessageBox').addClass("active");
                $('.toast-icon').css('background-color', 'red');
                $('.toast-icon').removeClass('bi-check2').addClass('bi-x');
                $('.message-text.text-1').text(response.message['title']);
                $('.message-text.text-2').text(response.message['content']);
                $('.progressbar').addClass("active");
                $('.progressbar').css('background-color', 'red');
                setTimeout(function() {
                    $('.statusMessageBox').removeClass("active");
                }, 4000);

                setTimeout(function() {
                    $('.progressbar').removeClass("active");
                }, 4300);
                $('.toast-close').on("click", function() {
                    $('.statusMessageBox').removeClass("active");

                    setTimeout(function() {
                        $('.progressbar').removeClass("active");
                    }, 300);
                });
            }

            function closeAllDropdownsExcept(keepOpen) {
                var commentdropdowns = $('.comment-feature');
                commentdropdowns.each(function(index, dropdownbtn) {
                    var $dropdownbtn = $(dropdownbtn); // Convert the native DOM element to a jQuery object
                    if (!$dropdownbtn.is(keepOpen) && $dropdownbtn.hasClass('dropActive')) {
                        $dropdownbtn.removeClass('dropActive');
                    }
                });

                var postdropdowns = $('.postFeature.dropActive');
                if (!postdropdowns.is(keepOpen) && postdropdowns.hasClass('dropActive')) {
                        postdropdowns.removeClass('dropActive');
                }
            }

            function closeAllDropdowns() {
                var commentdropdowns = $('.comment-feature.dropActive');
                var postdropdowns = $('.postFeature.dropActive');

                commentdropdowns.removeClass('dropActive');
                postdropdowns.removeClass('dropActive');
            }

            // Attach a click event handler to the document
            $(document).on('click', function(event) {
                var target = $(event.target);
                // Check if the clicked element is not within a dropdown container
                if (!target.closest('.threeDotImg').length) {
                    closeAllDropdowns();
                }
            });
        });
        // function to show comments
        function showComments()	{
            var postID = <?php echo $postIDjs; ?>;
            var visibilityStatus = {};
            $('.comment-replies:visible').each(function () {
                var commentId = $(this).data('comment-id'); // Use a unique identifier here
                visibilityStatus[commentId] = true; // Mark it as visible
            });
            
            $.ajax({
                url:"show_comments.php",
                method:"POST",
                data: {postID: postID},
                success:function(response) {
                    $('#comment-list').html(response);
                    for (var commentId in visibilityStatus) {
                        if (visibilityStatus[commentId]) {
                            $('.comment-replies[data-comment-id="' + commentId + '"]').show();
                            $('.comment-replies[data-comment-id="' + commentId + '"]').prev().html('<i class="bi bi-caret-up-fill"></i> Hide Replies');
                        }
                    }
                }
            })
        }
    </script>
    <script>
        var statusMessageBox = document.querySelector('.statusMessageBox1');
            if(statusMessageBox){
                setTimeout(function() {
                    statusMessageBox.classList.add("slideOut");
                }, 4000);
            }
            var progressbar = document.querySelector('.statusMessageBox1 .progressbar.active');
            if (progressbar) {
                setTimeout(function() {
                    progressbar.classList.remove("active");
                    statusMessageBox.remove();
                }, 4500);
            }

            var toastCloseButtons = document.querySelectorAll('.statusMessageBox1 .toast-close');
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
    </script>
<?php ob_end_flush(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>