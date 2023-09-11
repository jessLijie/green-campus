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
        <?php
            include("./connectdb.php");
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            require './/PHPMailer/src/Exception.php';
            require './/PHPMailer/src/PHPMailer.php';
            require './PHPMailer/src/SMTP.php';

            if(isset($_POST["email"]) && (!empty($_POST["email"]))){
                $email = $_POST["email"];
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                $error="";
                if (!$email) {
                    $error ="<p>Invalid email address please type a valid email address!</p>";
                }else{
                    $sel_query = "SELECT * FROM `users` WHERE email='".$email."'";
                    $results = mysqli_query($con,$sel_query);
                    $row = mysqli_num_rows($results);
                    if ($row==""){
                    $error = "<p>No user is registered with this email address!</p>";
                    }
                }
                if($error!=""){
                    echo "<div class='error'>".$error."</div>
                    <br /><a href='javascript:history.go(-1)'>Go Back</a>";
                }else{
                    $expFormat = mktime(
                    date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
                    );
                    $expDate = date("Y-m-d H:i:s",$expFormat);
                    $key = md5((2418*2).$email);
                    $addKey = substr(md5(uniqid(rand(),1)),3,10);
                    $key = $key . $addKey;
                    // Insert Temp Table
                    mysqli_query($con,
                    "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
                    VALUES ('".$email."', '".$key."', '".$expDate."');");
                    
                    $output='<p>Dear user,</p>';
                    $output.='<p>Please click on the following link to reset your password.</p>';
                    $output.='<p>-------------------------------------------------------------</p>';
                    //output link
                    $output.='<p><a href="localhost/utm/AppDev/reset-password.php?
                    key='.$key.'&email='.$email.'&action=reset" target="_blank">
                    localhost/utm/AppDev/reset-password.php?
                    key='.$key.'&email='.$email.'&action=reset</a></p>';		
                    $output.='<p>-------------------------------------------------------------</p>';
                    $output.='<p>Please be sure to copy the entire link into your browser.
                    The link will expire after 1 day for security reason.</p>';
                    $output.='<p>If you did not request this forgotten password email, no action 
                    is needed, your password will not be reset. However, you may want to log into 
                    your account and change your security password as someone may have guessed it.</p>';   	
                    $output.='<p>Thanks,</p>';
                    $output.='<p>Greenify UTM</p>';
                    $body = $output; 
                    $subject = "Password Recovery - GREENIFY UTM";
                    
                    $email_to = $email;
                    $fromserver = "jingyi012@gmail.com"; //Enter your email here
                    
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host = "smtp.gmail.com"; // Enter your host here
                    $mail->SMTPAuth = true;
                    $mail->Username = "jingyi012@gmail.com"; // Enter your email here
                    $mail->Password = "asokwnbtgnkzmwoh"; //Enter your password here
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true);
                    $mail->From = "jingyi012@gmail.com";
                    $mail->FromName = "GREENIFY";
                    $mail->Sender = $fromserver; // indicates ReturnPath header
                    $mail->Subject = $subject;
                    $mail->Body = $body;
                    $mail->AddAddress($email_to);
                    if(!$mail->Send()){
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    }else{
                        echo "<div class='success'>
                        <p>An email has been sent to you with instructions on how to reset your password.</p>
                        </div><br /><br /><br />";
                    }
                }
            }else{
        ?>
            <div class="wrapper">
                <header>Forgot Password</header>
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
        <?php } ?>
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