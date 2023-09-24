<html>
    <body>
    <div class="modal fade .modal-dialog-centered" id="deleteComment<?php echo $row["commentID"]; ?>" tabindex="-1" aria-labelledby="deleteCommentFormContainerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteCommentFormContainerLabel"><i class="bi bi-trash" style="margin-right: 5px;"></i>Delete Comment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                    <p><b>Comment: </b><?php echo $row['commentContent']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    <form method="post" action="" id="delcommentForm">
                        <input type="hidden" name="delcommentID" value="<?php echo $row['commentID']; ?>" />
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>