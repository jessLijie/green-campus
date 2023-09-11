<?php session_start();
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Greenify UTM</title>
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
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .border-bottom-0 {
            margin: 6%;
            margin-top: 1%;
            border: #dee2e6 1px solid;
        }

        .goback {
            font-size: 20px;
            text-decoration: none;
            color: black;
        }

        .returnLink {
            color: black;
            font-size: calc(1.275rem + .3vw);
            text-decoration: none;
            margin-bottom: 5px;
            text-align: center;
        }

        .returnLink:hover {
            color: grey;
        }

        .noResult {
            text-align: center;
            margin: 100px;
        }

        .newsImage {
            width: 71.5px;
            height: 45px;
        }

        .editNewsImage {
            width: 214.5px;
            height: 135px;
            margin: 5px 0px;
        }

        .statusMessageBox1 {
            position: fixed;
            bottom: 30px;
            right: 40px;
            background: #fff;
            min-width: 100px;
            min-height: 30px;
            padding: 10px 25px 10px 15px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* transform: translateX(calc(100% + 100px)); */
            /* transition: all 0.5s cubic-bezier(0.68, -0.55, 0.25, 1.35); */
            z-index: 2;
            animation: slideIn 0.5s cubic-bezier(0.68, -0.55, 0.25, 1.35);
        }

        @keyframes slideIn {
            from {
                transform: translateX(calc(100% + 100px));
            }

            to {
                transform: translateX(0);
            }
        }

        .statusMessageBox1.slideOut {
            animation: slideOut 0.5s cubic-bezier(0.68, -0.55, 0.25, 1.35);
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(calc(100% + 100px));
            }
        }

        .toast-content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .toast-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 35px;
            width: 35px;
            border-radius: 50%;
            color: #fff;
            font-size: 20px;
        }

        .greenColor {
            background-color: #40f467;
        }

        .redColor {
            background-color: #f44040;
        }

        .message {
            display: flex;
            flex-direction: column;
            margin: 0 20px;
        }

        .message-text {
            font-size: 20px;
            font-weight: 600;
        }

        .text-1 {
            color: #333;
        }

        .text-2 {
            color: #666;
            font-weight: 400;
            font-size: 16px;
        }

        .toast-close {
            position: absolute;
            top: 10px;
            right: 15px;
            padding: 5px;
            cursor: pointer;
            opacity: 0.7;
        }

        .toast-close:hover {
            opacity: 1;
        }

        .progressbar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            width: 100%;
            /* background-color: #40f467; */
        }

        .progressbar.active {
            animation: progress 4s linear forwards;
        }

        @keyframes progress {
            100% {
                width: 0%;
            }
        }
    </style>
</head>

<body>
    <?php
    include("connectdb.php");

    if (isset($_SESSION['editNews'])) {
        echo $_SESSION['editNews'];
        unset($_SESSION['editNews']);
    }

    if (isset($_SESSION['addNews'])) {
        echo $_SESSION['addNews'];
        unset($_SESSION['addNews']);
    }

    if (isset($_SESSION['deleteNews'])) {
        echo $_SESSION['deleteNews'];
        unset($_SESSION['deleteNews']);
    }

    ?>
    <div>
        <div style="padding: 10px 50px 0px;">
            <a class="goback" href="adminHome.php">
                <i class="bi bi-arrow-left-short"></i>
                <span>Back</span>
            </a>
            <h1 style="font-size: 30px; text-align: center; margin: 15px 0 30px 0;">Manage News</h1>
        </div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid" style="margin: 0% 6% 1% 6%">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#createNewsModal">Create News <svg xmlns="http://www.w3.org/2000/svg" width="20"
                            height="20" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 19 19">
                            <path
                                d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z" />
                        </svg></button>
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
                                <input type="file" class="form-control" name="file" accept=".jpg, .png, .jpeg, .gif"
                                    required><br>
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
                echo '<a href="adminManage.php" class="returnLink"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 19 19">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
              </svg> Back</a>';
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
                echo '<th scope="col">Action</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr>';
                    echo '<th scope="row"> ' . $row['id'] . ' </th>';
                    echo '<td><img src="images/newsImg/' . $row['image_url'] . '" class="newsImage" alt="..."></td>';
                    echo '<td><a href="newsPost.php?id=' . $row['id'] . '">' . $row['title'] . '</a></td>';
                    echo '<td>' . $row['author'] . '</td>';
                    echo '<td>' . $row['publish_date'] . '</td>';
                    echo '<td>' . $row['category'] . '</td>';
                    echo '<td><button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#editNewsModal' . $row['id'] . '" style="width: auto"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
              </svg></button>';

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
                                        <div>
                                            <label for="file">Image:</label><br>
                                            <img src="images/newsImg/<?php echo $row['image_url'] ?>" class="editNewsImage"
                                                alt="..."><br>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="file"
                                                accept=".jpg, .png, .jpeg, .gif"><br>
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

                    <!-- deletetion model -->
                    <div class="modal fade" id="deleteNewsModal<?php echo $row['id'] ?>" tabindex="-1"
                        aria-labelledby="deleteNewsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deleteNewsModalLabel"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                            class="bi bi-trash3-fill" viewBox="0 0 19 19">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg> Confirm Deletion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6 style="font-weight:normal;">Are you sure you want to delete this news?</h6>
                                    <h6><span style="font-weight:normal;">News title: </span>
                                        <?php echo $row['title'] ?>
                                    </h6>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="deleteNews.php?id=<?php echo $row['id'] ?>"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php

                    echo '<button id="delete-news"  class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#deleteNewsModal' . $row["id"] . '" style="width: auto"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                  </svg></button></td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

            } else {
                echo '<h2 class="noResult">We could not find anything for " ' . $_GET['query'] . '".</h2>';
            }


            ?>
        </div>
    </div>

    <script>
        function showDeleteConfirmation(id) {
            if (confirm("Are you sure you want to delete this news?")) {
                window.location.href = "deleteNews.php?id=" + id;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var statusMessageBox = document.querySelector('.statusMessageBox1');
            if (statusMessageBox) {
                setTimeout(function () {
                    statusMessageBox.classList.add("slideOut");
                }, 4000);
            }
            var progressbar = document.querySelector('.progressbar.active');
            if (progressbar) {
                setTimeout(function () {
                    progressbar.classList.remove("active");
                    statusMessageBox.remove();
                }, 4500);
            }

            var toastCloseButtons = document.querySelectorAll('.toast-close');
            toastCloseButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var statusMessageBox = document.querySelector('.statusMessageBox1');
                    statusMessageBox.classList.add("slideOut");

                    setTimeout(function () {
                        progressbar.classList.remove("active");
                        statusMessageBox.remove();
                    }, 300);
                });
            });
        });
    </script>
</body>

</html>