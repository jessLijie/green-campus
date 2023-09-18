<?php
session_start();
include_once("connectdb.php");
if(isset($_SESSION["userID"])){
    $userID = $_SESSION["userID"];
}
if(!empty($_POST["pid"]) && !empty($_POST["postComment"])){
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentTime = date('Y-m-d H:i:s');
	$insertComments = "INSERT INTO comments (parent_commentId, commentContent, commentDate, userID, postID) VALUES ('" . $_POST['parent_commentID'] . "', '" . $_POST['postComment'] . "', '$currentTime', " . $_SESSION['userID'] . ", " . $_POST['pid'] . ")";
	$resAddComment=mysqli_query($con, $insertComments) or die("database error: ". mysqli_error($con));	

    if($resAddComment==true){
        $message = array('title' => "Success", 'content' => "Comment added successfully.");
        $error = false;
        
    } else {
        $message = array('title' => "Failed", 'content' => "Failed to add comment.");
        $error = true;
    }
    $response = array(
        'error' => $error,
        'message' => $message
    );
    echo json_encode($response);
}

?>