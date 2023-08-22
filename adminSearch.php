<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <style>
        .border-bottom-0 {
            margin: 6%;
            margin-top: 1%;
            border: #dee2e6 1px solid;
        }
    </style>
</head>

<body>
    <div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 3% 6% 0% 6%">
                <div class="container-fluid">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createNewsModal">Create News</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin: 0">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        </ul>
                        <form class="d-flex" action="adminSearch.php" method="GET">
                            <input class="form-control me-2" type="search" name="query" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Create News -->
        <div class="modal fade" id="createNewsModal" tabindex="-1" aria-labelledby="createNewsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createNewsModalLabel">Create News</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="createNews.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" required><br>
                            </div>
                            <div class="form-group">
                                <label for="content">Content:</label><br>
                                <textarea class="form-control" name="content" rows="8" cols="50"
                                    required></textarea><br>
                            </div>
                            <div class="form-group">
                                <label for="author">Author:</label><br>
                                <input type="text" class="form-control" name="author" required><br>
                            </div>
                            <div class="form-group">
                                <label for="publishDate">Publish Date:</label><br>
                                <input type="datetime-local" class="form-control" name="publishDate" required><br>
                            </div>
                            <div class="form-group">
                                <label for="file">Image:</label><br>
                                <input type="file" class="form-control-file" name="file" required><br>
                            </div>
                            <div class="form-group">
                                <br><label for="category">Category:</label><br>
                                <select class="form-control" name="category" required>
                                    <option value="Events">Events</option>
                                    <option value="Facilities">Facilities</option>
                                    <option value="Achievements">Achievements</option>
                                    <option value="Campus News">Campus News</option>
                                </select><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="createNews" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="border-bottom-0">

            <?php
            $con = mysqli_connect("localhost", "root", "", "greenify");

            if (!$con) {
                die('Could not connect: ' . mysqli_connect_error());
            }

            $query = "";
            $result = "";

            if (isset($_GET['query'])) {
                $query = mysqli_real_escape_string($con, $_GET['query']);
                $query = "%" . $query . "%";
                $searchQuery = "SELECT * FROM newsfeed WHERE title LIKE '$query'";
                $result = mysqli_query($con, $searchQuery);
            }

            echo '<table class="table table-hover">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">ID</th>';
            echo '<th scope="col">Image</th>';
            echo '<th scope="col">Title</th>';
            echo '<th scope="col">Author</th>';
            echo '<th scope="col">Publish Date</th>';
            echo '<th scope="col">Category</th>';
            echo '<th scope="col" colspan="2">Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<th scope="row">' . $row['id'] . '</th>';
                echo '<td><img src="images/newsImg/' . $row['image_url'] . '" alt="..." style="width:71.5px ;height:45px;"></td>';
                echo '<td>' . $row['title'] . '</td>';
                echo '<td>' . $row['author'] . '</td>';
                echo '<td>' . $row['publish_date'] . '</td>';
                echo '<td>' . $row['category'] . '</td>';
                echo '<td><button type="button" class="edit-button" data-bs-toggle="modal"
                data-bs-target="#editNewsModal' . $row['id'] . '">Edit</button></td>';

                ?>

                <!-- Edit News -->
                <div class="modal fade" id="editNewsModal<?php echo $row['id'] ?>" tabindex="-1"
                    aria-labelledby="editNewsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editNewsModalLabel">Edit News</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="editNews.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <!-- <label for="id">Id:</label> -->
                                        <input type="hidden" class="form-control" name="id"
                                            value="<?php echo $row['id']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input type="text" class="form-control" name="title"
                                            value="<?php echo $row['title']; ?>" required><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content:</label><br>
                                        <textarea class="form-control" name="content" rows="8" cols="50"
                                            required><?php echo $row['content']; ?></textarea><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="author">Author:</label><br>
                                        <input type="text" class="form-control" name="author"
                                            value="<?php echo $row['author']; ?>" required><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="publishDate">Publish Date:</label><br>
                                        <input type="datetime-local" class="form-control" name="publishDate"
                                            value="<?php echo $row['publish_date']; ?>" required><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Image:</label><br>
                                        <input type="file" class="form-control-file" name="file"><br>
                                    </div>
                                    <div class="form-group">
                                        <br><label for="category">Category:</label><br>
                                        <select class="form-control" name="category" required>
                                            <option value="Events" <?php if ($row['category'] == "Events")
                                                echo "selected"; ?>>Events
                                            </option>
                                            <option value="Facilities" <?php if ($row['category'] == "Facilities")
                                                echo "selected"; ?>>Facilities
                                            </option>
                                            <option value="Achievements" <?php if ($row['category'] == "Achievements")
                                                echo "selected"; ?>>
                                                Achievements</option>
                                            <option value="Campus News" <?php if ($row['category'] == "Campus News")
                                                echo "selected"; ?>>Campus
                                                News
                                            </option>
                                        </select><br>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" name="editNews" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php

                echo '<form action="deleteNews.php" method="POST">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<td><button id="delete-news" class="delete-button">Delete</button></td></form>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            ?>
        </div>
    </div>
</body>

</html>