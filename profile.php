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
    <?php include('header.php');
    include("connectdb.php");

    if (isset($_SESSION['editProfile'])) {
        echo $_SESSION['editProfile'];
        unset($_SESSION['editProfile']);
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username'");
        $row = mysqli_fetch_array($result);
    }

    ?>

    <div class="row g-3 align-items-center" id="cointainer">
        <h2 style="margin-top: 0">Profile</h2>
        <form>
            <div class="profile-container">
                <img src="images/profileImg/<?php if (!$row['userImage']) {
                    echo 'defaultprofile.png';
                } else {
                    echo $row['userImage'];
                } ?>" alt="Avatar" class="round" width="300" height="400">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div>
                    <input type="text" readonly class="form-control" id="username"
                        value="<?php echo $row['username']; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <div>
                    <input type="email" readonly class="form-control" id="email" value="<?php echo $row['email']; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="matricNo" class="form-label" <?php if ($row['urole'] == 'admin') {
                    echo 'hidden';
                } ?>>Matric  Number</label>
                <div>
                    <input type="text" readonly class="form-control" id="matricNo"
                        value="<?php echo $row['matricNo']; ?>" <?php if ($row['urole'] == 'admin') {
                               echo 'hidden';
                           } ?>>
                </div>
            </div>

            <div class="mb-3">
                <label for="faculty" class="form-label" <?php if ($row['urole'] == 'admin') {
                    echo 'hidden';
                } ?>>Faculty</label>
                <div>
                    <select id="faculty" name="faculty" class="form-control" disabled <?php if ($row['urole'] == 'admin') {
                        echo 'hidden';
                    } ?>>
                        <option value=""></option>
                        <option value="Civil Engineering" <?php if ($row['faculty'] == 'Civil Engineering') {
                            echo 'selected';
                        } ?>>Faculty of Civil Engineering</option>
                        <option value="Mechanical Engineering" <?php if ($row['faculty'] == 'Mechanical Engineering') {
                            echo 'selected';
                        } ?>>Faculty of Mechanical Engineering</option>
                        <option value="Electrical Engineering" <?php if ($row['faculty'] == 'Electrical Engineering') {
                            echo 'selected';
                        } ?>>Faculty of Electrical Engineering</option>
                        <option value="Chemical & Energy Engineering" <?php if ($row['faculty'] == 'Chemical & Energy Engineering') {
                            echo 'selected';
                        } ?>>Faculty of Chemical & Energy Engineering</option>
                        <option value="Computing" <?php if ($row['faculty'] == 'Computing') {
                            echo 'selected';
                        } ?>>Faculty of
                            Computing</option>
                        <option value="Science" <?php if ($row['faculty'] == 'Science') {
                            echo 'selected';
                        } ?>>Faculty of
                            Science</option>
                        <option value="Built Environment & Surveying" <?php if ($row['faculty'] == 'Built Environment & Surveying') {
                            echo 'selected';
                        } ?>>Faculty of Built Environment & Surveying</option>
                        <option value="Social Sciences & Humanities" <?php if ($row['faculty'] == 'Social Sciences & Humanities') {
                            echo 'selected';
                        } ?>>Faculty of Social Sciences & Humanities</option>
                        <option value="Management" <?php if ($row['faculty'] == 'Management') {
                            echo 'selected';
                        } ?>>Faculty
                            of Management</option>
                    </select>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-block">
                <a href="editProfile.php"><button type="button" class="btn btn-primary">Edit Profile</button></a>
            </div>
        </form>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var statusMessageBox = document.querySelector('.statusMessageBox1');
            if (statusMessageBox) {
                setTimeout(function () {
                    statusMessageBox.classList.add("slideOut");
                }, 4000);
            }
            var progressbar = document.querySelector('.progressbar.active');
            if (progressbar) {
                setTimeout(function () {
                    progressbar.classList.remove("active");
                    statusMessageBox.remove();
                }, 4500);
            }

            var toastCloseButtons = document.querySelectorAll('.toast-close');
            toastCloseButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var statusMessageBox = document.querySelector('.statusMessageBox1');
                    statusMessageBox.classList.add("slideOut");

                    setTimeout(function () {
                        progressbar.classList.remove("active");
                        statusMessageBox.remove();
                    }, 300);
                });
            });
        });
    </script>
</body>

</html>