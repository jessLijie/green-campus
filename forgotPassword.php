<?php session_start(); ob_start();?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Greenify UTM</title>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="pageContainer">
        <div class="wrapper">

            <header>Forgot Password</header>

            <?php
            include("./connectdb.php");

            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $encrypted_password=md5($password);

                $sql = "SELECT * FROM users WHERE email='$email' && upassword='$encrypted_password'";
                $result = mysqli_query($con, $sql);
                
                if(mysqli_num_rows($result)===1){
                    $row = mysqli_fetch_array($result);
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['userID'] = $row['userID'];
                    $_SESSION['login'] = "yes";
                    $_SESSION['role'] = $row["urole"];

                    if($_SESSION['role'] == "admin")
                        header("location:./adminHome.php");
                    else
                        header("location:./userHome.php");
                }
                else{
                    echo "<div class='error'>
                    <p>Wrong username or password.</p>
                    </div>";
                }
            }
            
            ?>

            <form action="" method="post" id="forgotPasswordForm" onsubmit="return formValidation()">
                <div class="field email">
                    <div class="input-area">
                        <input type="text" placeholder="Email Address" name="email" id="email" onchange="checkEmail()">
                        <i class="icon fas fa-envelope"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Email can't be blank</div>
                </div>
                <input type="submit" value="Submit" name="submit">
            </form>

            <div class="sign-txt"><a href="login.php">Back to login</a></div>
        </div>
    </div>
    
    <script>
            const form = document.getElementById("forgotPasswordForm");
                eField = form.querySelector(".email"),
                eInput = eField.querySelector("input"),
                pField = form.querySelector(".password"),
                pInput = pField.querySelector("input");
                    
            function formValidation(){
                (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
                (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();

                setTimeout(() => { //remove shake class after 500ms
                    eField.classList.remove("shake");
                    pField.classList.remove("shake");
                }, 500);

                if(!eField.classList.contains("error") && !pField.classList.contains("error")){
                    console.log("success");
                    return true;
                } else{
                    console.log("error");
                    return false;
                }
            }

            function checkEmail() { //checkEmail function
                let pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/; //pattern for validate email
                if (!eInput.value.match(pattern)) { //if pattern not matched then add error and remove valid class
                    eField.classList.add("error");
                    eField.classList.remove("valid");
                    let errorTxt = eField.querySelector(".error-txt");
                    //if email value is not empty then show please enter valid email else show Email can't be blank
                    (eInput.value != "") ? errorTxt.innerText = "Enter a valid email address" : errorTxt.innerText = "Email can't be blank";
                } else { //if pattern matched then remove error and add valid class
                    eField.classList.remove("error");
                    eField.classList.add("valid");
                }
            }

        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>