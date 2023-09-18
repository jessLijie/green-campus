<?php
session_start();
include_once("connectdb.php");
if(isset($_SESSION["userID"])){
    $userID = $_SESSION["userID"];
}

if(isset($_POST['cid'])){
    $cid = $_POST['cid'];
    $comment = $_POST['newComment'];

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentDate = date('Y-m-d H:i:s');
    $sqlupdatecomment = "UPDATE comments SET
            commentContent='$comment',
            commentDate='$currentDate'
            WHERE commentID = $cid
            ";

    $resUpdateComment = mysqli_query($con, $sqlupdatecomment);
    if($resUpdateComment==true){
        $message = array('title' => "Success", 'content' => "Comment edited successfully.");
        $error = false;
        
    } else {
        $message = array('title' => "Failed", 'content' => "Failed to edit comment.");
        $error = true;   
    }
    $response = array(
        'error' => $error,
        'message' => $message
    );
    echo json_encode($response);
}

?>