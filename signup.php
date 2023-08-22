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
    <!--<link rel="stylesheet" href="css/main.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="pageContainer">
        <div class="wrapper">
        <?php
        include("./connectdb.php");
        $showForm=true;
        if(isset($_POST['submit'])){
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            $verify_email=mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
            $verify_username=mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

            if(mysqli_num_rows($verify_email)!=0 || mysqli_num_rows($verify_username)!=0)
            {
                if(mysqli_num_rows($verify_email)!=0){
                    echo "<div class='message'>
                    <p><img src='images/cross.png' width='20px' height='20px' style='margin-right: 10px;' />This email is used, Try another One Please!</p>
                    </div> <br>";

                    echo "<a href='javascript:self.history.back()'><button class='btnnn'>Go Back</button>";
                } else if(mysqli_num_rows($verify_username)!=0){
                    echo "<div class='message'>
                    <p><img src='images/cross.png' width='20px' height='20px' style='margin-right: 10px;' />This username is used, Try another One Please!</p>
                    </div> <br>";

                    echo "<a href='javascript:self.history.back()'><button class='btnnn'>Go Back</button>";
                }
            
            $showForm=false;

            } else{
                mysqli_query($con, "INSERT INTO users(username, uPassword, email, urole) VALUES('$username',md5('$password'), '$email', 'user')") or die("Error Occurred");
    
                echo"<div class='message'>
                <p><img src='images/tick.png' width='20px' height='20px' style='margin-right: 10px;' />Registration successfully!</p>
                </div> <br>";
                echo "<a href=./login.php><button class='btnnn'>Login Now</button>";
                $showForm=false;
            }
        }
        ?>
            <?php if($showForm) {?>
            <header>Sign Up</header>
            <form action="" method="post" id="signupform" onsubmit="return formValidation()">
            <div class="field username">
                    <div class="input-area">
                        <input type="text" placeholder="Username" name="username" onchange="checkUser()">
                        <i class="icon fas fa-envelope"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Username can't be blank</div>
                </div>

                <div class="field email">
                    <div class="input-area">
                        <input type="text" placeholder="Email Address" name="email" onchange="checkEmail()">
                        <i class="icon fas fa-envelope"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Email can't be blank</div>
                </div>
                <div class="field password">
                    <div class="input-area">
                        <input type="password" placeholder="Password" name="password" onchange="checkPass()">
                        <i class="icon fas fa-lock"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Password can't be blank</div>
                </div>

                <input type="submit" value="Sign Up" name="submit">
            </form>

            <div class="sign-txt">Already registered? <a href="login.php">Login</a></div>
        </div>
        <script>
            const form = document.getElementById("signupform");
                uField = form.querySelector(".username"),
                uInput = uField.querySelector("input"),
                eField = form.querySelector(".email"),
                eInput = eField.querySelector("input"),
                pField = form.querySelector(".password"),
                pInput = pField.querySelector("input");
                    
            function formValidation(){
                (uInput.value == "") ? uField.classList.add("shake", "error") : checkUser();
                (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
                (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();

                setTimeout(() => { //remove shake class after 500ms
                    uField.classList.remove("shake");
                    eField.classList.remove("shake");
                    pField.classList.remove("shake");
                }, 500);

                if(!uField.classList.contains("error") && !eField.classList.contains("error") && !pField.classList.contains("error")){
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

            function checkPass() { //checkPass function
                if (pInput.value == "") { //if pass is empty then add error and remove valid class
                    pField.classList.add("error");
                    pField.classList.remove("valid");
                } else { //if pass is empty then remove error and add valid class
                    pField.classList.remove("error");
                    pField.classList.add("valid");
                }
            }

            function checkUser() { //checkPass function
                console.log(uField);
                if (uInput.value == "") { //if pass is empty then add error and remove valid class
                    uField.classList.add("error");
                    uField.classList.remove("valid");
                } else { //if pass is empty then remove error and add valid class
                    uField.classList.remove("error");
                    uField.classList.add("valid");
                }
            }
        </script>
        <?php } ?>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>