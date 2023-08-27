<?php session_start();
include("header.php");
?>
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
        a {
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: grey;
        }

        table {
            border: 1px #dee2e6 solid;
        }

        .border-bottom-0 {
            margin: 6%;
            margin-top: 1%;
            border: #dee2e6 1px solid;
        }

        .returnLink {
            color: grey;
            text-decoration: none;
            margin-bottom: 5px;
        }

        .noResult {
            text-align: center;
            margin: 100px;
        }
    </style>
</head>

<body>
    <?php
    include("connectdb.php");
    ?>
    <div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid" style="margin: 2% 6% 1% 6%">
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
                        <form class="d-flex" action="" method="GET">
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
                        <h1 class="modal-title fs-5" id="createNewsModalLabel"><svg xmlns="http://www.w3.org/2000/svg"
                                width="30" height="30" fill="currentColor" class="bi bi-file-earmark-plus"
                                viewBox="0 0 19 19">
                                <path
                                    d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z" />
                                <path
                                    d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                            </svg> Create News</h1>
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
                                <input type="file" class="form-control" name="file" required><br>
                            </div>
                            <div class="form-group">
                                <label for="category">Category:</label><br>
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

        <div style="margin: 0% 6% 2% 6%">
            <?php

            $result = "";

            if (isset($_GET['query'])) {
                $query = mysqli_real_escape_string($con, $_GET['query']);
                $query = "%" . $query . "%";
                $result = mysqli_query($con, "SELECT * FROM newsfeed WHERE title LIKE '$query'");
                echo '<a href="adminManage.php" class="returnLink">< Return to previous page</a>';
                echo '<h5>Search results for : ' . $_GET['query'] . '</h5>';

            } else {
                $result = mysqli_query($con, "SELECT * FROM newsfeed");
            }

            if (mysqli_num_rows($result) > 0) {
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
                    echo '<td><a href="newsPost.php?id=' . $row['id'] . '">' . $row['title'] . '</a></td>';
                    echo '<td>' . $row['author'] . '</td>';
                    echo '<td>' . $row['publish_date'] . '</td>';
                    echo '<td>' . $row['category'] . '</td>';
                    echo '<td><button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                data-bs-target="#editNewsModal' . $row['id'] . '">Edit</button></td>';

                    ?>

                    <!-- Edit News -->
                    <div class="modal fade" id="editNewsModal<?php echo $row['id'] ?>" tabindex="-1"
                        aria-labelledby="editNewsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editNewsModalLabel"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="30" height="30" fill="currentColor" class="bi bi-pencil-square"
                                            viewBox="0 0 19 19">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg> Edit News</h1>
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
                                            <input type="file" class="form-control" name="file"><br>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Category:</label><br>
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

                    echo '<td><button id="delete-news"  class="btn btn-outline-danger" onclick="showDeleteConfirmation(' . $row['id'] . ')">Delete</button></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<h2 class="noResult">We could not find anything for " ' . $_GET['query'] . '".</h2>';
            }


            ?>
        </div>

        <script>
            function showDeleteConfirmation(id) {
                if (confirm("Are you sure you want to delete this news?")) {
                    window.location.href = "deleteNews.php?id=" + id;
                }
            }
        </script>

    </div>
</body>

</html>