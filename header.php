<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./images/icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    Greenify UTM
                </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage=="home")? 'active' : ''?> " aria-current="page" href="main.php"> <i class="bi bi-house"></i> Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage=="locate")? 'active' : ''?> " href="locate.php"> <i class="bi bi-geo-alt"></i> Locate</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage=="forum")? 'active' : ''?> " href="forum.php"> <i class="bi bi-megaphone"></i> Forum</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage=="guide")? 'active' : ''?> " href="guide.php"> <i class="bi bi-journal-text"></i> Guide</a>
                        </li>
                    </ul>

                </div>
                <?php  
                    if (!isset($_SESSION['login'])){ ?>
                    <a href="login.php"><button type="button" class="btn btn-outline-success" >Login/Sign Up</button></a>
                <?php } else {?>

        
                    <a href="logout.php"><button type="button" class="btn btn-outline-danger" >Log Out</button></a>
                <?php } ?>

            </div>

        </nav>    
    </body>
    
   
    
</html>
