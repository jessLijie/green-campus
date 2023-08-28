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
        body {
            background-image: linear-gradient(to right, #8a64d6, #0cead9)
        }

        .errorMsg{
            font-size: small;
            color: red;
        }

        img.round {
            object-fit: cover;
            border-radius: 50%;
            height: 200px;
            width: 200px;
            box-sizing: content-box;
            box-shadow: 3px 3px 10px 2px #888888;
        }

        .profile-container {
            padding: 1%;
            margin-bottom: 4%;
            text-align: center;
        }

        #cointainer {
            margin: 6% 30% 6% 30%;
            padding: 2%;
            border-radius: 12px;
            background-color: white;
            box-shadow: 3px 3px 20px 2px #888888;
        }
    </style>
</head>

<body>
    <?php
    include('connectdb.php');

    $statusMsg = '';
    $userErrorMsg = '';
    $emailErrorMsg = '';
    $newEmail = '';
    $newUsername = '';
    $targetDir = "images/profileImg/";

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['editProfile'])) {
        $newUsername = $_POST['newUsername'];
        $newEmail = $_POST['newEmail'];

        $verify_email = mysqli_query($con, "SELECT email FROM users WHERE email='$newEmail'");
        $verify_username = mysqli_query($con, "SELECT username FROM users WHERE username='$newUsername'");


        if ((mysqli_num_rows($verify_email) != 0 && $newEmail != $row['email']) || (mysqli_num_rows($verify_username) != 0 && $newUsername != $row['username'])) {
            if (mysqli_num_rows($verify_email) != 0 && $newEmail != $row['email']) {
                $emailErrorMsg = 'A user with this email address already exists.';
            } 
            
            if (mysqli_num_rows($verify_username) != 0 && $newUsername != $row['username']) {
                $userErrorMsg = 'A user with this username already exists.';
            }

        } else {

            $updateQuery = "UPDATE users SET username='$newUsername', email='$newEmail' WHERE username='$username'";
            mysqli_query($con, $updateQuery);
            $_SESSION['username'] = $newUsername;

            if ($_FILES["file"]["name"]) {
                $fileName = basename($_FILES["file"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($fileType, $allowTypes)) {
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                        $insert = mysqli_query($con, "UPDATE users SET userImage = ('" . $fileName . "') WHERE email = '$newEmail'");
                        if ($insert) {
                            $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
                        } else {
                            $statusMsg = "File upload failed, please try again.";
                        }
                    } else {
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                }
            }

            echo $statusMsg;

            header('Location: profile.php');
            exit();
        }
    }

    ?>

    <?php include('header.php'); ?>

    <div class="row g-3 align-items-center" id="cointainer">
        <h2 style="margin-top: 0">Edit Profile</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="profile-container">
                <img src="images/profileImg/<?php if (!$row['userImage']) {
                    echo 'defaultprofile.png';
                } else {
                    echo $row['userImage'];
                } ?>" alt="Avatar" class="round" width="300" height="400">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Profile picture</label>
                <input class="form-control" type="file" name="file" id="file">
            </div>

            <div class="mb-3">
                <label for="newUsername" class="form-label">Username</label>
                <div>
                    <input type="text" class="form-control" id="newUsername" name="newUsername"
                        value="<?php if($newUsername){ echo $newUsername; }else{ echo $row['username']; }?>" required>
                    <p class="errorMsg"><?php echo $userErrorMsg ?><p>
                </div>
            </div>

            <div class="mb-3">
                <label for="newEmail" class="form-label">Email address</label>
                <div>
                    <input type="email" class="form-control" id="newEmail" name="newEmail"
                        value="<?php if($newEmail){ echo $newEmail; }else{ echo $row['email']; } ?>" required>
                    <p class="errorMsg"><?php echo $emailErrorMsg ?><p>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <a href="profile.php"><button type="button" class="btn btn-outline-primary">Cancel</button></a>
                <input type="submit" class="btn btn-primary" name="editProfile" value="Submit">
            </div>
        </form>
    </div>
</body>

</html>