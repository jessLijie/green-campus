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

    </style>
</head>

<body>
    <?php
    $con = mysqli_connect("localhost", "root", "", "greenify");

    if (!$con) {
        die('Could not connect: ' . mysqli_connect_error());
    }

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
    <div class="container mt-5">
        <article style="margin: 15%; margin-top: 3%">
            <header class="mb-4">
                <h1 class="fw-bolder mb-1"><?php echo $newsPost['title']; ?></h1>
                <div class="text-muted fst-italic mb-2">Posted on <?php echo date_format(date_create($newsPost['publish_date']), "d/m/Y H:i:s" ); ?> by <?php echo $newsPost['author']; ?></div>
                <a class="badge bg-secondary text-decoration-none link-light" href=""><?php echo $newsPost['category']; ?></a>
            </header>
            <figure class="mb-4"><img class="img-fluid rounded" src="images/newsImg/<?php echo $newsPost['image_url']; ?>"
                    alt="..." style="width: 100%; aspect-ratio: 16 / 9;" /></figure>
            <section class="mb-5">
                <p class="fs-5 mb-4"><?php echo $newsPost['content']; ?></p>
            </section>
        </article>
    </div>
</body>

</html>