<html>
    <body>
        <!-- edit comment modal -->
        <div class="modal fade .modal-dialog-centered" id="editCommentFormContainer<?php echo $row["commentID"]; ?>" tabindex="-1" aria-labelledby="editCommentFormContainerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCommentFormContainerLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="modalForm" action="" method="post">
                    <div>
                        <label for="inputNewComment" class="form-label">New Comment:</label>
                        <input type="text" class="form-control" id="inputNewComment" name="newComment" value="<?php echo $row['commentContent']; ?>" required />
                    </div>
                    <input type="hidden" name="cid" value="<?php echo $row["commentID"]; ?>" />
                    <div style="text-align: center; margin: 30px auto 10px;"><button type="submit" name="editCommentSubmit" id="submit" class="btn btn-outline-success">Submit</button></div>
                </form>
                </div>
                </div>
            </div>
        </div>
        <?php
        //edit
        if(isset($_POST['editCommentSubmit'])){
            echo "<meta http-equiv='refresh' content='0'>";
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
                $_SESSION['editcomment'] = "<div class='success'><img src='./images/tick.png' width='16px' alt='tick' />Comment edited successfully.</div>";
                
            } else {
                $_SESSION['editcomment'] = "<div class='error'><img src='./images/cross.png' width='16px' alt='cross icon'/>Failed to edit comment.</div>";
                
            }
        }
        
    ?>
    </body>
</html>