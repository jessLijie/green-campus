<html>
    <head>
    </head>
    <body>
        <?php 
        if(isset($_POST['editcommentID'])){
            echo "<script>console.log(\"Before modal code\")</script>";
            echo "<script type='text/javascript'>
                $(document).ready(function() {
                    $('#editCommentFormContainer').modal('show');
                });
                </script>";
            $ecommentid = $_POST['editcommentID'];
            $sqlEditcomment = "SELECT * FROM comments WHERE commentID='$ecommentid'";
            $resEditcomment = mysqli_query($con, $sqlEditcomment);
            $rowcommentedit = mysqli_fetch_array($resEditcomment, MYSQLI_ASSOC);
        }
        ?>
        <!-- edit comment modal -->
        <div class="modal fade .modal-dialog-centered" id="editCommentFormContainer" tabindex="-1" aria-labelledby="editCommentFormContainerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCommentFormContainerLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="addPostForm" action="" method="post">
                    <div>
                        <label for="inputNewComment">New Comment:</label>
                        <input type="text" class="inputNewComment" id="inputNewComment" name="newComment" value="<?php if(isset($_POST['editcommentID'])){ echo $rowcommentedit['commentContent']; } ?>" required />
                    </div>
                    <input type="hidden" name="cid" value="<?php echo $ecommentid; ?>" />
                    <div class="submitbtnStyle"><button type="submit" name="editCommentSubmit" id="submit" class="submitbtn">Submit</button></div>
                </form>
                </div>
                </div>
            </div>
        </div>
        <?php
        //edit
        if(isset($_POST['editCommentSubmit'])){
            //echo "<meta http-equiv='refresh' content='0'>";
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
                $_SESSION['editcomment'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='tick' />Comment Edited Successfully.</div>";
                
            } else {
                $_SESSION['editcomment'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to Edit Comment.</div>";
                
            }
        }
        
    ?>
    </body>
</html>