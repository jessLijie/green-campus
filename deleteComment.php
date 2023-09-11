<?php
session_start();
include("connectdb.php");

function deleteComments($con, $delcommentid) {
    // Delete comments where commentID matches delcommentid
    $sql = "DELETE FROM comments WHERE commentID = $delcommentid";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $message = array('title' => "Success", 'content' => "Comment deleted successfully");
        $error = false;
    } else {
        $message = array('title' => "Failed", 'content' => "Comment failed to delete");
        $error = true;
    }

    // Find child comments with parent_commentID = delcommentid
    $sql = "SELECT commentID FROM comments WHERE parent_commentID = $delcommentid";
    $result = mysqli_query($con, $sql);

    // Recursively delete child comments
    while ($row = mysqli_fetch_assoc($result)) {
        deleteComments($con, $row['commentID']);
    }
    return array($error, $message);
}

if (isset($_POST['delcommentID'])) {
    $delcommentid = $_POST['delcommentID'];
    $errorMessage=deleteComments($con, $delcommentid);

    // Update the comment count
    $postID = $_POST['postID'];
    $commentCountQuery = "SELECT COUNT(*) as count FROM comments WHERE postID = $postID";
    $commentCountResult = mysqli_query($con, $commentCountQuery);
    $commentCountData = mysqli_fetch_assoc($commentCountResult)['count'];

    $response = array(
        'commentCount' => $commentCountData,
        'error' => $errorMessage[0],
        'message' => $errorMessage[1]
    );
    echo json_encode($response);
}
?>