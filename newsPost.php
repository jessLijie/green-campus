<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Blog Post - Start Bootstrap Template</title>
    <style>
        .newsImage {
            width: 140px;
            height: 85px;
            padding: 5px;
        }

        .newsFeature {
            text-decoration: none;
            color: black;
        }

        .newsFeature:hover {
            color: red;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto;
        }

        .grid-item{
            text-wrap: break-word;
            /* width: 50px; */
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    include("connectdb.php");
    $newsPost = array('id' => '', 'title' => '', 'content' => '');

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $query = "SELECT * FROM newsfeed WHERE id = $id";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $newsPost = mysqli_fetch_assoc($result);
        }
    }

    ?>
    <div style="margin: 10%; margin-top: 7%; display: flex; gap: 50px;">
        <div>
            <article>
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1" style="width: 800px">
                        <?php echo $newsPost['title']; ?>
                    </h1>
                    <div class="text-muted fst-italic mb-2">Posted on
                        <?php echo date_format(date_create($newsPost['publish_date']), "d/m/Y H:i:s"); ?> by
                        <?php echo $newsPost['author']; ?>
                    </div>
                    <a class="badge bg-secondary text-decoration-none link-light" href="">
                        <?php echo $newsPost['category']; ?>
                    </a>
                </header>
                <figure class="mb-4"><img class="img-fluid rounded"
                        src="images/newsImg/<?php echo $newsPost['image_url']; ?>" alt="..."
                        style="width: 800px; aspect-ratio: 16 / 9; margin-right: 0" /></figure>
                <section class="mb-5">
                    <p class="fs-5 mb-4" style="width: 800px; margin-right: 0">
                        <?php echo $newsPost['content']; ?>
                    </p>
                </section>
            </article>
        </div>
        <div>
            <h3>Features</h3>
            <?php $result1 = mysqli_query($con, "SELECT * FROM newsfeed WHERE id != $id ORDER BY id DESC LIMIT 8");
            if (mysqli_num_rows($result1) > 0) {
                while ($row = mysqli_fetch_array($result1)) {
                    echo '<div><a href="newsPost.php?id=' . $row['id'] . '" class="newsFeature">';
                    echo '<div style="display: inline-block"><img src="images/newsImg/' . $row['image_url'] . '" class="newsImage" alt="..."></div>';
                    echo '<div style="display: inline-block; width: 200px; max-height: 85px;vertical-align: top">' . $row['title'] . '</div></a><hr style="margin: 0"></div>';
                }
            } else {

            }
            ?>
        </div>
    </div>
</body>

</html>