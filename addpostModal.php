<html>
    <body>
    <!-- add post modal -->
    <div class="modal fade .modal-dialog-centered" id="addPostFormContainer" tabindex="-1" aria-labelledby="addPostFormContainerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addPostFormContainerLabel"><i class="bi bi-plus-square"style="margin-right: 5px;"></i>Create Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="modalForm" action="addPost.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="postTitle" class="form-label" >Title:</label>
                    <input type="text" class="form-control" id="postTitle" name="postTitle" required />
                </div>
                <div>
                    <label for="postContent" class="form-label">Content:</label>
                    <textarea class="form-control" id="postContent" name="postContent" rows="4" required></textarea>
                </div>
                <div> 
                    <label for="postImg" class="form-label">Image: </label>
                    <input type="file" class="form-control" id="postImg" name="postImg" accept="image/*"/>
                </div>
                <div>   
                    <label for='category' class="form-label">Category:</label>
                    <select name="category" id="category" class='form-select'>
                        <option value='Environment Protection'>Environment Protection</option>
                        <option value='Energy and Resource'>Energy and Resource</option>
                        <option value='Waste Reduction and Recycling'>Waste Reduction and Recycling</option>
                        <option value='Carbon Footprint'>Carbon Footprint</option>
                        <option value='Transportation'>Transportation</option>
                        <option value='Other'>Other</option>
                    </select>
                </div>      
                
                <div style="text-align: center; margin: 30px auto 10px;"><button type="submit" name="addPostSubmit" id="submit" class="btn btn-outline-success">Submit</button></div>
            </form>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>-->
            </div>
        </div>
    </div>
    </body>
</html>