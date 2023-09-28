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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="pageContainer">
        <div class="wrapper">
            <?php
            include("./connectdb.php");
            $showForm = true;
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $matricNo = $_POST['matricNo'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $statusMsg = '';
                $targetDir = "images/cardMatricImg/";

                $verify_email = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
                $verify_username = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
                $verify_matricNo = mysqli_query($con, "SELECT matricNo FROM users WHERE matricNo='$matricNo'");

                if (mysqli_num_rows($verify_email) != 0 || mysqli_num_rows($verify_username) != 0 || mysqli_num_rows($verify_matricNo) != 0) {
                    if (mysqli_num_rows($verify_email) != 0) {
                        echo "<div class='message'>
                    <p><img src='images/cross.png' width='20px' height='20px' style='margin-right: 10px;' />This email is used, Try another One Please!</p>
                    </div> <br>";

                        echo "<a href='javascript:self.history.back()'><button class='btnnn'>Go Back</button></a>";
                    } else if (mysqli_num_rows($verify_username) != 0) {
                        echo "<div class='message'>
                    <p><img src='images/cross.png' width='20px' height='20px' style='margin-right: 10px;' />This username is used, Try another One Please!</p>
                    </div> <br>";

                        echo "<a href='javascript:self.history.back()'><button class='btnnn'>Go Back</button></a>";
                    } else if (mysqli_num_rows($verify_matricNo) != 0) {
                        echo "<div class='message'>
                    <p><img src='images/cross.png' width='20px' height='20px' style='margin-right: 10px;' />This matric number is used, Try another One Please!</p>
                    </div> <br>";

                        echo "<a href='javascript:self.history.back()'><button class='btnnn'>Go Back</button></a>";
                    }

                    $showForm = false;

                } else {
                    mysqli_query($con, "INSERT INTO users(username, matricNo, uPassword, email, urole, status) VALUES('$username', '$matricNo', md5('$password'), '$email', 'user', 'PENDING')") or die("Error Occurred");

                    $last_id = mysqli_insert_id($con);

                    if ($_FILES["file"]["name"]) {

                        $cardMatricImgName = explode('.', $_FILES["file"]["name"]);
                        $ext = end($cardMatricImgName);
                        $cardMatricImgName = "matricNoImg-" . $last_id . "-" . mt_rand(00000, 99999) . "." . $ext;
                        $fileName = $cardMatricImgName;

                        $targetFilePath = $targetDir . $fileName;
                        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                        if (in_array($fileType, $allowTypes)) {
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                                $insert = mysqli_query($con, "UPDATE users SET matricImg = ('" . $fileName . "') WHERE userID = '$last_id'");
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
                    echo "<div class='message'>
                    <p><img src='images/tick.png' width='20px' height='20px' style='margin-right: 10px;' />We have received your registration. Our team is currently in the process of validating the information provided. Once the validation process is complete, you will receive an email notifying you of the outcome of your registration.</p>
                    </div> <br>";
                    echo "<a href=./login.php><button class='btnnn'>Login Now</button></a>";
                    $showForm = false;
                }
            }
            ?>
            <?php if ($showForm) { ?>
                <header>Sign Up</header>
                <form action="" method="post" enctype="multipart/form-data" id="signupform"
                    onsubmit="return formValidation()">
                    <div class="field username">
                        <div class="input-area">
                            <input type="text" placeholder="Username" name="username" onchange="checkUser()">
                            <i class="icon fas fa-envelope"></i>
                            <i class="error error-icon fas fa-exclamation-circle"></i>
                        </div>
                        <div class="error error-txt">Username can't be blank</div>
                    </div>
                    <div class="field matricNo">
                        <div class="input-area" style="display: flex; gap: 1px">
                            <div><input type="text" placeholder="Matric Number" name="matricNo" onchange="checkMatricNo()"  oninput="this.value = this.value.toUpperCase()">
                            </div>
                            <div>
                                <div data-bs-toggle="tooltip" data-bs-placement="right"
                                    data-bs-title="Please provide a clear picture of your matric card for registration.">
                                    <button type="button" class="btn btn-outline-secondary" id="custom-click-button"
                                        data-bs-toggle="modal" data-bs-target="#uploadMatricImgModal"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="25" height="30" fill="currentColor"
                                            class="bi bi-image-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z" />
                                        </svg><span class="visually-hidden">Button</span></button>
                                </div>
                            </div>
                            <i class="icon fas fa-envelope"></i>
                            <i class="error error-icon fas fa-exclamation-circle"></i>
                        </div>
                        <div class="error error-txt" id="errorTxt">Matric Number can't be blank</div>
                        <div id="upload-errorTxt" style="color: #dc3545; text-align: left; margin-top: 0px;"></div>


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

                    <div class="modal fade" id="uploadMatricImgModal" tabindex="-1"
                        aria-labelledby="uploadMatricImgModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen-sm-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="uploadMatricImgModalLabel"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                            class="bi bi-image-fill" viewBox="0 0 19 19">
                                            <path
                                                d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z" />
                                        </svg>Card Matric Image</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="upload-container">
                                        <div class="upload-card">
                                            <div class="field matricImg">
                                            </div>
                                            <h3>Please provide a clear picture of your matric card for registration</h3>
                                            <div class="upload-drop_box">
                                                <header>
                                                    <h4>Select File here</h4>
                                                </header>
                                                <p>Files Supported: JPG, PNG, JPEG , GIF </p>
                                                <div><svg xmlns="http://www.w3.org/2000/svg" width="70" height="70"
                                                        class="upload-image" fill="currentColor"
                                                        class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                                        <path
                                                            d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                                        <defs>
                                                            <linearGradient id="MyGradient">
                                                                <stop offset="5%" stop-color="var(--color-start)" />
                                                                <stop offset="95%" stop-color="var(--color-stop)" />
                                                            </linearGradient>
                                                        </defs>
                                                    </svg></div>

                                                <input type="file" hidden="hidden" accept=".jpg, .png, .jpeg, .gif"
                                                    id="real-file" name="file" style="display:none;"
                                                    onchange="checkMatricImg()">

                                                <button type="button" class="upload-btn" id="custom-upload-button">Choose
                                                    File</button>
                                                <p id="custom-text">No file chosen, yet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="submit" value="Sign Up" name="submit">
                </form>

                <div class="sign-txt">Already registered? <a href="login.php">Login</a></div>
            </div>
            <script>
                const form = document.getElementById("signupform");
                uField = form.querySelector(".username"),
                    uInput = uField.querySelector("input"),
                    mField = form.querySelector(".matricNo"),
                    mInput = mField.querySelector("input"),
                    eField = form.querySelector(".email"),
                    eInput = eField.querySelector("input"),
                    pField = form.querySelector(".password"),
                    pInput = pField.querySelector("input"),
                    mImgField = form.querySelector(".matricImg"),
                    realFileBtn = document.getElementById("real-file"),
                    customClickBtn = document.getElementById("custom-click-button"),
                    customBtn = document.getElementById("custom-upload-button"),
                    customTxt = document.getElementById("custom-text");

                function formValidation() {

                    (uInput.value == "") ? uField.classList.add("shake", "error") : checkUser();
                    (mInput.value == "") ? mField.classList.add("shake", "error") : checkMatricNo();
                    (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
                    (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();
                    if (realFileBtn.value == "") {
                        mImgField.classList.add("error");
                        checkMatricImg();

                    } else {
                        checkMatricImg();
                    }

                    setTimeout(() => { //remove shake class after 500ms
                        uField.classList.remove("shake");
                        mField.classList.remove("shake");
                        eField.classList.remove("shake");
                        pField.classList.remove("shake");
                    }, 500);

                    if (!uField.classList.contains("error") && !mField.classList.contains("error") && !eField.classList.contains("error") && !pField.classList.contains("error") && !mImgField.classList.contains("error")) {
                        console.log("success");
                        return true;
                    } else {
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
                        if(pInput.value.length < 8){
                            pField.querySelector(".error-txt").innerHTML = "The password must more than 8 character or number";
                            pField.classList.add("error");
                            pField.classList.remove("valid");
                        }else{
                           pField.classList.remove("error");
                            pField.classList.add("valid"); 
                        }
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

                function checkMatricNo() { //checkPass function
                    let pattern = /^[A-Z]{1}\d{2}[A-Z]{2}\d{4}$/;
                    if (!mInput.value.match(pattern)) { //if pass is empty then add error and remove valid class
                        if (mInput.value == "") {
                            if (realFileBtn.value != "") {
                                document.getElementById("errorTxt").innerHTML = "Matric Number can't be blank";
                            } else {
                                document.getElementById("errorTxt").innerHTML = "Enter your matric number and matric card image";
                            }
                        } else {
                            if (realFileBtn.value != "") {
                                document.getElementById("errorTxt").innerHTML = "Enter a valid matric number";
                            } else {
                                document.getElementById("errorTxt").innerHTML = "Enter a valid matric number and insert your matric card image";
                            }
                        }

                        if (mImgField.classList.contains("error")) {
                            if (mInput.value == "") {
                                document.getElementById("errorTxt").innerHTML = "Enter your matric number and matric card image";
                            } else {
                                document.getElementById("errorTxt").innerHTML = "Enter a valid matric number and insert your matric card image";
                            }
                        }

                        if (document.getElementById("errorTxt").innerHTML != "") {
                            document.getElementById("upload-errorTxt").innerHTML = "";
                        }

                        mField.classList.add("error");
                        mField.classList.remove("valid");
                    } else { //if pass is empty then remove error and add valid class
                        if (mImgField.classList.contains("error")) {
                            document.getElementById("upload-errorTxt").innerHTML = "Please insert your matric card image";
                        }
                        document.getElementById("errorTxt").innerHTML = "";
                        mField.classList.remove("error");
                        mField.classList.add("valid");
                    }
                }

                function checkMatricImg() { //checkPass function
                    if (realFileBtn.value == "") { //if pass is empty then add error and remove valid class
                        if (mInput.value == "") {
                            document.getElementById("errorTxt").innerHTML = "Enter your matric number and matric card image";
                            customClickBtn.style.borderColor = "#dc3545";
                        } else if (mInput.value != "") {
                            document.getElementById("upload-errorTxt").innerHTML = "Please insert your matric card image";
                            customClickBtn.style.borderColor = "#dc3545";
                        }

                        if (document.getElementById("errorTxt").innerHTML != "") {
                            document.getElementById("upload-errorTxt").innerHTML = "";
                        }

                        mImgField.classList.add("error");
                        mImgField.classList.remove("valid");
                    } else { //if pass is empty then remove error and add valid class
                        if (mInput.value == "") {
                            document.getElementById("errorTxt").innerHTML = "Matric Number can't be blank";
                        } else {
                            document.getElementById("errorTxt").innerHTML = "Enter a valid matric number";
                        }
                        document.getElementById("upload-errorTxt").innerHTML = "";
                        customClickBtn.style.borderColor = "#5372F0";
                        mImgField.classList.remove("error");
                        mImgField.classList.add("valid");
                    }
                }

                customBtn.addEventListener("click", function () {
                    realFileBtn.click();
                });

                realFileBtn.addEventListener("change", function () {
                    if (realFileBtn.value) {
                        customTxt.innerHTML = realFileBtn.value;
                    } else {
                        customTxt.innerHTML = "No file chosen, yet.";
                    }
                });

                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

            </script>
        <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>