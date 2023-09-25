<html>
    <body>
    <div class="modal fade .modal-dialog-centered" id="deletePostFormContainer<?php echo $row['postID']; ?>" tabindex="-1" aria-labelledby="deletePostFormContainerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deletePostFormContainerLabel"><i class="bi bi-trash" style="margin-right: 5px;"></i>Delete Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete?</p>
                        <p><b>Post title: </b><?php echo $row['postTitle']; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <form method="post" action="deletePost.php">
                            <input type='hidden' name='delpostID' value="<?php echo $row['postID']; ?>" />
                            <input type='hidden' name='delpostImg' value="<?php echo $row['postPic']; ?>" />
                            <input type='hidden' name='action' value='delete' />
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>