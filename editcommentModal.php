<html>
    <body>
        <!-- edit comment modal -->
        <div class="modal fade .modal-dialog-centered" id="editCommentFormContainer<?php echo $row["commentID"]; ?>" tabindex="-1" aria-labelledby="editCommentFormContainerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editCommentFormContainerLabel"><i class="bi bi-pencil-square"style="margin-right: 5px;" ></i>Edit Comment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form class="modalForm" action="" method="post" id="editCommentForm">
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
    </body>
</html>