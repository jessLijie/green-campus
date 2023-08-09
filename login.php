<?php session_start(); ?>
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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php include('header.php'); ?>
    <center>
        <div class="wrapper">

            <header>Login</header>

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

                    if($row['urole'] === 'admin'){
                        //admin dashboard
                        header("location: ./admin/adminHome.php");
                    }
                    else{
                        //user dashboard
                        header("location: ./main.php");
                    }
                }
                else{
                    echo "<div class='error'>
                    <p>Wrong username or password.</p>
                    </div>";
                }
            }
            
            ?>

            <form action="" method="post">
                <div class="field email">
                    <div class="input-area">
                        <input type="text" placeholder="Email Address" name="email" id="email">
                        <i class="icon fas fa-envelope"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Email can't be blank</div>
                </div>
                <div class="field password">
                    <div class="input-area">
                        <input type="password" placeholder="Password" name="password" id="password">
                        <i class="icon fas fa-lock"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Password can't be blank</div>
                </div>
                <div class="pass-txt"><a href="./forgotPassword.php">Forgot password?</a></div>
                <input type="submit" value="Login" name="submit">
            </form>

            <div class="sign-txt">Not yet register? <a href="signup.php">Signup now</a></div>
        </div>
    </center>
    
    <script>/*
        const form = document.querySelector("form");
        eField = form.querySelector(".email"),
            eInput = eField.querySelector("input"),
            pField = form.querySelector(".password"),
            pInput = pField.querySelector("input");

        form.onsubmit = (e) => {
            e.preventDefault(); //preventing from form submitting
            //if email and password is blank then add shake class in it else call specified function
            (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
            (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();

            setTimeout(() => { //remove shake class after 500ms
                eField.classList.remove("shake");
                pField.classList.remove("shake");
            }, 500);

            eInput.onkeyup = () => { checkEmail(); } //calling checkEmail function on email input keyup
            pInput.onkeyup = () => { checkPass(); } //calling checkPassword function on pass input keyup

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

            function checkPass() { //checkPass function
                if (pInput.value == "") { //if pass is empty then add error and remove valid class
                    pField.classList.add("error");
                    pField.classList.remove("valid");
                } else { //if pass is empty then remove error and add valid class
                    pField.classList.remove("error");
                    pField.classList.add("valid");
                }
            }
        }
*/
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>