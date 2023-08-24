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
    <?php
    include('connectdb.php');

    $statusMsg = '';
    $targetDir = "images/profileImg/";

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
        $row = mysqli_fetch_array($result);

    }

    if (isset($_POST['editProfile'])) {
        $newUsername = $_POST['newUsername'];
        $newEmail = $_POST['newEmail'];

        $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$newEmail'");

        if (mysqli_num_rows($verify_query) != 0 && $newEmail != $row['email']) {
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

    <div class="row g-3 align-items-center"
        style="margin: 6% 30% 6% 30%; padding: 2%; border: 1px solid grey; border-radius: 12px;">
        <h1 style="margin-top: 0">Edit Profile</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="profile-container">
                <img src="images/profileImg/profile.jpg" alt="Avatar" class="round" width="300" height="400">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Profile picture</label>
                <input class="form-control" type="file" name="file" id="file">
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