<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        img.round {
            object-fit: cover;
            border-radius: 50%;
            height: 200px;
            width: 200px;
            box-sizing: content-box;
        }

        .profile-container {
            padding: 1%;
            margin-bottom: 4%;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <?php
    include("connectdb.php");

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
        $row = mysqli_fetch_array($result);

    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $newUsername = $_POST['newUsername'];
        $newEmail = $_POST['newEmail'];

        $verify_query=mysqli_query($con, "SELECT email FROM users WHERE email='$newEmail'");

        if(mysqli_num_rows($verify_query)!=0 && $newEmail != $row['email'])
            {

            }else{
                $updateQuery = "UPDATE users SET username='$newUsername', email='$newEmail' WHERE username='$username'";
                mysqli_query($con, $updateQuery);
        
                $_SESSION['username'] = $newUsername;
        
                header("Location: profile.php");
                exit();
            }
    }

    ?>

    <div class="row g-3 align-items-center"
        style="margin: 6% 30% 6% 30%; padding: 2%; border: 1px solid grey; border-radius: 12px;">
        <h1 style="margin-top: 0">Edit Profile</h1>
        <form method="POST" action="">
            <div class="profile-container">
                <img src="profileimage/profile.jpg" alt="Avatar" class="round" width="300" height="400">
            </div>
            <div class="mb-3">
                <label for="newUsername" class="form-label">Username</label>
                <div>
                    <input type="text" class="form-control" id="newUsername" name="newUsername"
                        value="<?php echo $row['username']; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="newEmail" class="form-label">Email address</label>
                <div>
                    <input type="email" class="form-control" id="newEmail" name="newEmail"
                        value="<?php echo $row['email']; ?>">
                </div>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <input type="submit" class="btn btn-primary" name="editProfile" value="Submit">
            </div>
        </form>
    </div>
</body>

</html>