<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Greenify UTM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/profile.css" />
</head>

<body>
    <?php
    include('connectdb.php');

    $statusMsg = '';
    $userErrorMsg = '';
    $emailErrorMsg = '';
    $matricNoErrorMsg = '';
    $newEmail = '';
    $newUsername = '';
    $newMatricNo = '';
    $newFaculty = '';
    $targetDir = "images/profileImg/";

    function selectOption($faculty, $newFaculty, $previousfaculty)
    {
        if ($newFaculty) {
            if ($newFaculty == $faculty) {
                echo 'selected';
            }
        } else {
            if ($previousfaculty == $faculty) {
                echo 'selected';
            }
        }
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['editProfile'])) {
        $newUsername = $_POST['newUsername'];
        $newEmail = $_POST['newEmail'];
        $newMatricNo = $_POST['newMatricNo'];
        $newFaculty = $_POST['newFaculty'];

        $verify_email = mysqli_query($con, "SELECT email FROM users WHERE email='$newEmail'");
        $verify_username = mysqli_query($con, "SELECT username FROM users WHERE username='$newUsername'");
        $verify_matricNo = mysqli_query($con, "SELECT matricNo FROM users WHERE matricNo='$newMatricNo'");

        if ((mysqli_num_rows($verify_email) != 0 && $newEmail != $row['email']) || (mysqli_num_rows($verify_username) != 0 && $newUsername != $row['username']) || (mysqli_num_rows($verify_matricNo) != 0 && $newMatricNo != $row['matricNo'])) {
            if (mysqli_num_rows($verify_email) != 0 && $newEmail != $row['email']) {
                $emailErrorMsg = 'A user with this email address already exists.';
            }

            if (mysqli_num_rows($verify_username) != 0 && $newUsername != $row['username']) {
                $userErrorMsg = 'A user with this username already exists.';
            }

            if (mysqli_num_rows($verify_matricNo) != 0 && $newMatricNo != $row['matricNo']) {
                $matricNoErrorMsg = 'A user with this matric number already exists.';
            }

        } else {

            $updateQuery = "UPDATE users SET username='$newUsername', email='$newEmail', matricNo = '$newMatricNo', faculty = '$newFaculty' WHERE username='$username'";
            if (mysqli_query($con, $updateQuery)) {
                $_SESSION['editProfile'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-check2 toast-icon greenColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Success</span>
                                            <span class='message-text text-2'>Profile edited successfully</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active greenColor'></div>
                                        </div>";

                if ($_FILES["file"]["name"]) {

                    //create new profile pic name
                    $profileImgName = explode('.', $_FILES["file"]["name"]);
                    $ext = end($profileImgName);
                    $profileImgName = "profileImg-" . $row['userID'] . "-" . mt_rand(00000, 99999) . "." . $ext;
                    $fileName = $profileImgName;
                    // $fileName = basename($_FILES["file"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                            $insert = mysqli_query($con, "UPDATE users SET userImage = ('" . $fileName . "') WHERE email = '$newEmail'");
                            unlink($targetDir . $row['userImage']);
                            if ($insert) {
                                $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
                            } else {
                                $statusMsg = "File upload failed, please try again.";
                            }
                        } else {
                            $statusMsg = "Sorry, there was an error uploading your file.";
                            $_SESSION['editProfile'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to upload profile picture</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
                        }
                    } else {
                        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                }

            } else {
                $_SESSION['editProfile'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to edit profile</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
            }
            $_SESSION['username'] = $newUsername;

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
                    <input type="text" class="form-control" id="newUsername" name="newUsername" value="<?php if ($newUsername) {
                        echo $newUsername;
                    } else {
                        echo $row['username'];
                    } ?>" style="background-color: white" required>
                    <p class="errorMsg">
                        <?php echo $userErrorMsg ?>
                    <p>
                </div>
            </div>

            <div class="mb-3">
                <label for="newEmail" class="form-label">Email address</label>
                <div>
                    <input type="email" class="form-control" id="newEmail" name="newEmail" value="<?php if ($newEmail) {
                        echo $newEmail;
                    } else {
                        echo $row['email'];
                    } ?>" style="background-color: white" required>
                    <p class="errorMsg">
                        <?php echo $emailErrorMsg ?>
                    <p>
                </div>
            </div>

            <div class="mb-3">
                <label for="newMatricNo" class="form-label" <?php if ($row['urole'] == 'admin') {
                    echo 'hidden';
                } ?>>Matric Number</label>
                <div>
                    <input type="text" class="form-control" id="newMatricNo" name="newMatricNo" value="<?php if ($newMatricNo) {
                        echo $newMatricNo;
                    } else {
                        echo $row['matricNo'];
                    }

                    ?>" <?php if ($row['urole'] == 'admin') {
                        echo 'hidden';
                    } else {
                        echo 'required';
                    } ?> readonly>
                    <p class="errorMsg">
                        <?php echo $matricNoErrorMsg ?>
                    <p>
                </div>
            </div>

            <div class="mb-3">
                <label for="faculty" class="form-label" <?php if ($row['urole'] == 'admin') {
                    echo 'hidden';
                } ?>>Faculty</label>
                <div>
                    <select id="faculty" name="newFaculty" class="form-control" <?php if ($row['urole'] == 'admin') {
                        echo 'hidden';
                    } else {
                        echo 'required';
                    } ?>>
                        <option value="">Select a faculty</option>
                        <option value="Civil Engineering" <?php selectOption('Civil Engineering', $newFaculty, $row['faculty']) ?>>Faculty of Civil Engineering</option>
                        <option value="Mechanical Engineering" <?php selectOption('Mechanical Engineering', $newFaculty, $row['faculty']) ?>>Faculty of Mechanical Engineering</option>
                        <option value="Electrical Engineering" <?php selectOption('Electrical Engineering', $newFaculty, $row['faculty']) ?>>Faculty of Electrical Engineering</option>
                        <option value="Chemical & Energy Engineering" <?php selectOption('Chemical & Energy Engineering', $newFaculty, $row['faculty']) ?>>Faculty of Chemical & Energy Engineering
                        </option>
                        <option value="Computing" <?php selectOption('Computing', $newFaculty, $row['faculty']) ?>>
                            Faculty of Computing</option>
                        <option value="Science" <?php selectOption('Science', $newFaculty, $row['faculty']) ?>>Faculty
                            of Science</option>
                        <option value="Built Environment & Surveying" <?php selectOption('Built Environment & Surveying', $newFaculty, $row['faculty']) ?>>Faculty of Built Environment & Surveying
                        </option>
                        <option value="Social Sciences & Humanities" <?php selectOption('Social Sciences & Humanities', $newFaculty, $row['faculty']) ?>>Faculty of Social Sciences & Humanities</option>
                        <option value="Management" <?php selectOption('Management', $newFaculty, $row['faculty']) ?>>
                            Faculty of Management</option>
                    </select>
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