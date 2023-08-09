<?php session_start(); ?>
<?php $currentPage = "forum"; ?>

<html>
<head>
    <link rel="stylesheet" href="./css/forum.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <?php include("header.php") ?>
    <div class='forum-container'>
        <div class='tool'>
            <div class='search-box'>
                <form action="" method="GET">  
                    <div class="search">
                        <input type="text" name="search_val" value="<?php if(isset($_GET['search'])){ echo $search_val; } ?>" placeholder="post" />
                        <button type="submit" name="search"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class='forum-category'>
                <h3>Environment Protection</h3>
                <h3>Energy and Resource</h3>
                <h3>Waste Reduction and Recycling</h3>
                <h3>Carbon Footprint</h3>
                <h3>Transportation</h3>
                <h3>Other</h3>
            </div>    
        </div>

        <div class='post-container'>
        
            <div class='post-nav-container'>
                <ul class='post-nav'>
                    <li> All Post </li>
                    <li> My Post </li>
                </ul>
                <!--<div class='addpost'>Add Post</div>-->
                <button type="button" class="addpost" data-bs-toggle="modal" data-bs-target="#addPostFormContainer">
                    Create Post
                </button>
            </div>

            <div class='post-list'>
               <div class='post'>
                    <!-- name -->
                    <div class='username'>
                        <span style='display: flex; align-items: center;'>
                        <img src='images/icon.png' style='width: 20px; height: 20px; border-radius: 20px; margin-right: 5px'>
                        <p style='margin: 0;'>故事募集所</p></span>
                    </div>
                    <div class='postDetails'>
                        <div class='word'>
                            <!-- title -->
                            <div class='postTitle'>
                            Title
                            </div>
                            <!-- description -->
                            <div class='postContent'>
                            Content
                            </div>
                            <!-- comment -->
                            <div class='interact'>
                                <i class="bi bi-chat-left"></i>   12
                            </div>
                        </div>
                        <!-- picture(optional) -->
                        <div class='postPic'>
                            <img src='./images/icon.png' width='100' height='100'/>
                        </div>
                    </div>
               </div>
               <hr>
            </div>
        </div>
    </div>
    <!-- modal -->
    <div class="modal fade .modal-dialog-centered" id="addPostFormContainer" tabindex="-1" aria-labelledby="addPostFormContainerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="addPostFormContainerLabel">Create post</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form class='addPostForm' action='' method='post'>
            <div>
                <label for='postTitle'>Title:</label></td>
                <input type='text' class='inputPostTitle' id='postTitle' name='postTitle' required /></td>
            </div>
            <div>
                <label for='postContent'>Content:</label></td>
                <textarea class='inputPostContent' id="postContent" name="postContent" rows="4" required></textarea></td>
            </div>
            <div> 
                <label for="postImg">Image: </label></td>
                <input type="file" class='postImg' id="inputPostImg" name="postImg" accept="image/*"/></td>
            </div>
            <div>   
                <label for='category'>Category:</label></td>
                <select name="category" id="category" class='inputCategory'>
                    <option value='Environment Protection'>Environment Protection</option>
                    <option value='Energy and Resource'>Energy and Resource</option>
                    <option value='Waste Reduction and Recycling'>Waste Reduction and Recycling</option>
                    <option value='Carbon Footprint'>Carbon Footprint</option>
                    <option value='Transportation'>Transportation</option>
                    <option value='Other'>Other</option>
                </select>
            </div>      
            
            <div class="submitbtnStyle"><button type="submit" name="addPostSubmit" id="submit" class="submitbtn">Submit</button></div>
        </form>
        </div>
        <!--<div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>-->
        </div>
    </div>
    </div>

    <?php
        if(isset($_POST['addPostSubmit'])){
            $title = $_POST['postTitle'];
            $content = $_POST['postContent'];
            $category = $_POST['category'];
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>