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
                    <a class="btn btn-primary" href="createNews.php" role="button">Create News</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        </ul>
                        <form class="d-flex" method="GET">
                            <input class="form-control me-2" type="search" name="query" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
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

        if (mysqli_num_rows($result) > 0) {
        
            echo ' <div class="border-bottom-0">';
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
                echo '<td><img src="image/' . $row['image_url'] . '" alt="..." style="width:71.5px ;height:45px;"></td>';
                echo '<td>' . $row['title'] . '</td>';
                echo '<td>' . $row['author'] . '</td>';
                echo '<td>' . $row['publish_date'] . '</td>';
                echo '<td>' . $row['category'] . '</td>';
                echo '<form action="editNews.php" method="POST">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<td><button id="edit-news" class="edit-button">Edit</button></td></form>';
                echo '<form action="deleteNews.php" method="POST">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo '<td><button id="delete-news" class="delete-button">Delete</button></td></form>';
                echo '</tr></div>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "No results";
        }


        ?>
    </div>
</body>

</html>