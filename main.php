<?php session_start() ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Greenify UTM</title>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="images/icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Greenify UTM
    </a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"> <i class="bi bi-house"></i> Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link "href="locate.php"> <i class="bi bi-geo-alt"></i> Locate</a>
        </li>

        <li class="nav-item">
          <a class="nav-link "href="forum.php"> <i class="bi bi-megaphone"></i> Forum</a>
        </li>

        <li class="nav-item">
          <a class="nav-link "href="guide.php"> <i class="bi bi-journal-text"></i> Guide</a>
        </li>
      </ul>
      
    </div>
    <?php  
    if ($_SESSION['login'] == 'yes' ){ ?>
    <a href="login.php"><button type="button" class="btn btn-outline-success" >Login/Sign Up</button></a>
    <?php } ?>
  </div>
  
</nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>