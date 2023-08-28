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

        input[type=text],
        input[type=email] {
            background-color: #EEEEEE;
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
    <?php include('header.php');
    include("connectdb.php");

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

            <div class="d-grid gap-2 d-md-block">
                <a href="editProfile.php"><button type="button" class="btn btn-primary">Edit Profile</button></a>
            </div>
        </form>

    </div>
</body>

</html>