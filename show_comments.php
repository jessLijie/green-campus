<?php
session_start();
include("connectdb.php");
if(isset($_SESSION["userID"])){
    $userID = $_SESSION["userID"];
    $userImg = $_SESSION['userImage'];
}

$commentQuery = "SELECT comments.*, users.username, users.userImage FROM comments
                LEFT JOIN users ON comments.userID = users.userID 
                WHERE parent_commentId = 0 AND postID={$_POST['postID']}
                ORDER BY comments.commentDate DESC";
$commentsResult = mysqli_query($con, $commentQuery) or die("database error:". mysqli_error($con));
$commentHTML = '';
$count1 = mysqli_num_rows($commentsResult);
if($count1>0){
    while($row = mysqli_fetch_assoc($commentsResult)){
        $commentHTML .= '
        <div class="commentWrapper">
        <div class="comment">
            <div class="commentUserImg">
                <img src="images/profileImg/' . ((!empty($row["userImage"])) ? $row["userImage"] : "defaultprofile.png") . '" alt="userImg" style="width: 40px; height: 40px; border-radius: 20px; margin-right: 10px;">
            </div>
            <div class="comment-content">
                <div class="commentUser">
                    <p style="margin: 0 10px 0 0; font-weight: bold;">'.$row["username"].'</p>
                    <p style="margin: 0;">'.$row["commentDate"].'</p>
                </div>
            
                <p style="margin: 0 0 5px 0;">'.$row["commentContent"].'</p>
                <button type="button" class="replyToggleBtn">Reply</button>
                <form action="" method="post" id="replyForm" class="replyForm">
                    <span style="display: flex;" class="replyInputBar">
                        <img src="images/profileImg/' . (isset($_SESSION["userImage"]) && $_SESSION["userImage"] != "" ? $_SESSION["userImage"] : "defaultprofile.png") . '" alt="userImg" style="width: 30px; height: 30px; border-radius: 20px; margin-right: 5px" />
                        <input type="text" name="postComment" placeholder="Add reply..." class="replyInput" required/>
                        <input type="hidden" name="parent_commentID" id="parent_commentID" value='.$row["commentID"].' />
                        <input type="hidden" name="pid" value='.$_POST["postID"].' />
                    </span>
                    <div class="replyToolContainer">
                        <div class="replyTool">
                            <button type="reset" class="closeReplybtn"><i class="bi bi-x"></i></button>
                            <button type="submit" class="replybtn"><i class="bi bi-send"></i></button>
                        </div>                
                    </div>
                </form>
                
            </div>';
            
        if ($userID == $row["userID"] || $_SESSION["role"] == "admin") {
            $commentHTML .= '
            <div class="comment-feature">
                <i class="bi bi-three-dots-vertical threeDotImg"></i>
                <div class="dropdownContainer">
                    <button class="editcomment" data-bs-toggle="modal" data-bs-target="#editCommentFormContainer'.$row["commentID"].'" >
                        <i class="bi bi-pencil-square"></i>Edit
                    </button>
                    <button class="delcomment" data-bs-toggle="modal" data-bs-target="#deleteComment'.$row["commentID"].'" >
                        <i class="bi bi-trash"></i>Delete
                    </button>
                </div>
            </div>';
        }
        $commentHTML .= '</div>';

        $commentHTML .= getCommentReply($con, $userID, $row["commentID"]);
        $commentHTML .= '</div>';
        include("deleteCommentModal.php");
        include("editcommentModal.php"); 
    }
} else {
    echo "<div style='text-align: center;'>No comment yet</div>";
}

echo $commentHTML;

function getCommentReply($con, $userID, $parentId = 0, $marginLeft = 0) {
	$commentHTML = '';
	$commentQuery = "SELECT comments.* , users.username, users.userImage FROM comments
                    LEFT JOIN users ON comments.userID=users.userID 
                    WHERE parent_commentId = $parentId 
                    ORDER BY comments.commentID DESC";
	$commentsResult = mysqli_query($con, $commentQuery);
	$commentsCount = mysqli_num_rows($commentsResult);
	if($parentId == 0) {
		$marginLeft = 0;
	} else {
        if($marginLeft >= 50){
            $marginLeft = $marginLeft + 40;
        }else{
            $marginLeft = $marginLeft + 50;
        }
	}
	if($commentsCount > 0) {
        $commentHTML .= '<button class="showRepliesbtn" style="margin-left: ' . $marginLeft . 'px;" ><i class="bi bi-caret-down-fill" style="margin-right: 5px;"></i>Show Replies</button>';
        $commentHTML .= '<div class="comment-replies" style="display: none;" data-comment-id='.$parentId.'>';
		while($row = mysqli_fetch_assoc($commentsResult)){  
			$commentHTML .= '
            <div class="comment" style="margin-left: ' . $marginLeft . 'px;">
                <div class="commentUserImg">
                    <img src="images/profileImg/' . ((!empty($row["userImage"])) ? $row["userImage"] : "defaultprofile.png") . '" alt="userImg" style="width: 30px; height: 30px; border-radius: 20px; margin-right: 10px;">
                </div>
                <div class="comment-content">
                    <div class="commentUser">
                        <p style="margin: 0 10px 0 0; font-weight: bold;">'.$row["username"].'</p>
                        <p style="margin: 0;">'.$row["commentDate"].'</p>
                    </div>
            
                    <p style="margin: 0 0 5px 0;">'.$row["commentContent"].'</p>
                    <button type="button" class="replyToggleBtn">Reply</button>
                    <form action="" method="post" id="replyForm" class="replyForm">
                        <span style="display: flex;" class="replyInputBar">
                            <img src="images/profileImg/' . (isset($_SESSION["userImage"]) && $_SESSION["userImage"] != "" ? $_SESSION["userImage"] : "defaultprofile.png") . '" alt="userImg" style="width: 30px; height: 30px; border-radius: 20px; margin-right: 5px" />
                            <input type="text" name="postComment" placeholder="Add reply..." class="replyInput" required/>
                            <input type="hidden" name="parent_commentID" id="parent_commentID" value='.$row["commentID"].' />
                            <input type="hidden" name="pid" value='.$_POST["postID"].' />
                        </span>
                        <div class="replyToolContainer">
                            <div class="replyTool">
                                <button type="reset" class="closeReplybtn"><i class="bi bi-x"></i></button>
                                <button type="submit" class="replybtn"><i class="bi bi-send"></i></button>
                            </div>                
                        </div>
                    </form>
                
                </div>';
                
            if ($userID == $row["userID"] || $_SESSION["role"] == "admin") {
                $commentHTML .= '
                <div class="comment-feature">
                    <i class="bi bi-three-dots-vertical threeDotImg"></i>
                    <div class="dropdownContainer">
                        <button class="editcomment" data-bs-toggle="modal" data-bs-target="#editCommentFormContainer'.$row["commentID"].'" >
                            <i class="bi bi-pencil-square"></i>Edit
                        </button>
                        <button class="delcomment" data-bs-toggle="modal" data-bs-target="#deleteComment'.$row["commentID"].'" >
                            <i class="bi bi-trash"></i>Delete
                        </button>
                    </div>
                </div>';
            }

            $commentHTML .= '</div>';
			$commentHTML .= getCommentReply($con, $userID, $row["commentID"], $marginLeft);
            include("deleteCommentModal.php");
            include("editcommentModal.php"); 
		}
        $commentHTML .= '</div>';
	}
    
	return $commentHTML;
}
?>
