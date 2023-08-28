<!DOCTYPE html>
<html>
  <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <style>
            .navbar{
                width: 100%;
                background-color: white;
            }
            .nav-container{
                display: flex;
                width: 100%;
                align-items: center;
                padding: 0 15px;
            }
            .nav-menu{
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .fixedpos{
                position: fixed;
                top: 0;
                z-index: 10;
                width: 100%;
            }
            .nav-item{
                padding: 0 15px;
            }
            .nav-link{
                padding: 6px;
                white-space: nowrap;
            }
            .account, .logbtn{
                margin-left: auto;
            }
            .nav-link.active{
                font-weight: 500;
            }
            .nav-link:hover{
                background-color: whitesmoke;
            }
            .account{
                position: relative;
            }
            .accountInfo{
                display: flex;
                align-items: center;
            }
            .account:hover{
                cursor: pointer;
            }
            .accountInfo p{
                margin: 0;
            }
            .accountDropdown{
                list-style: none;
                padding: 0;
                margin: 0;
                position: absolute;
                top: 40px;
                right: 0;
                background-color: white;
                width: 100%;
                height: 0;
                transition: height 0.3s linear;
                transition-delay: 0.1s;
                overflow: hidden;
                border-radius: 10px;
                box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
            }
            .account:hover .accountDropdown{
                height: 88px;
                transition: height 0.3s linear;
                transition-delay: 0.1s;
            }
            .accountDropdown li{
                height: fit-content;
                display: flex;
            }
            .accountDropdown li a{
                text-decoration: none;
                color: black;
                padding: 10px 15px;
            }
            .accountDropdown li:hover{
                background-color: whitesmoke;
            }

        </style>
    </head>
    <body>
        <nav class="navbar fixedpos">
            <div class="nav-container">
                <a class="navbar-brand" href="main.php">
                    <img src="./images/icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    Greenify UTM
                </a>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage=="home")? 'active' : ''?> " aria-current="page" href="main.php"> <i class="bi bi-house"></i> Home</a>
                    </li>

                    <div class="account">
                    <div class="accountInfo">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage=="locate")? 'active' : ''?> " href="<?php echo (isset($_SESSION['login']))? 'locate.php' : 'login.php'; ?>" > <i class="bi bi-geo-alt"></i> Locate
                        <i class="bi bi-caret-down-fill" style='margin: 0 10px;'></i></a>
                    </li>
                    </div>
                    <ul class="accountDropdown">
                        <li><a href="locate.php"><i class="bi bi-signpost-2" style='margin: 0 10px 0 0;'></i>Item</a></li>
                        <li><a href="event.php"><i class="bi bi-calendar-event" style='margin: 0 10px 0 0;'></i>Event</a></li>
                    </ul>
                </div>

                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage=="forum")? 'active' : ''?> " href="<?php echo (isset($_SESSION['login']))? 'forum.php' : 'login.php'; ?>"> <i class="bi bi-megaphone"></i> Forum</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage=="guide")? 'active' : ''?> " href="<?php echo (isset($_SESSION['login']))? 'guide.php' : 'login.php'; ?>"> <i class="bi bi-journal-text"></i> Guide</a>
                    </li>
                </ul>
                <?php if(isset($_SESSION['login'])){ ?>
                <div class="account">
                    <div class="accountInfo">
                        <img src="./images/defaultprofile.png" width="30" height="30" style="margin: 0 10px; border-radius: 15px;" alt="profilePic" />
                        <p><?php echo $_SESSION['username']; ?></p>
                        <i class="bi bi-caret-down-fill" style='margin: 0 10px;'></i>
                    </div>
                    <ul class="accountDropdown">
                        <li><a href="profile.php"><i class="bi bi-person-fill" style='margin: 0 10px 0 0;'></i>Profile</a></li>
                        <li><a href="logout.php"><i class="bi bi-box-arrow-left" style='margin: 0 10px 0 0;'></i>Log Out</a></li>
                    </ul>
                </div>
                <?php } else{ ?> 
                    <a href="login.php" class="logbtn"><button type="button" class="btn btn-outline-success" >Login/Sign Up</button></a>
                <?php } ?>
            </div>
        </nav>
    </body>
</html>