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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/icon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Greenify UTM
            </a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="main.php"> <i class="bi bi-house"></i> Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="#"> <i class="bi bi-geo-alt"></i> Locate</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="#"> <i class="bi bi-megaphone"></i> Forum</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="#"> <i class="bi bi-journal-text"></i> Guide</a>
                    </li>
                </ul>

            </div>

        </div>

    </nav>
    <center>
        <div class="wrapper">

            <header>Sign Up</header>
            <form action="">
            <div class="field username">
                    <div class="input-area">
                        <input type="text" placeholder="Username" name="username">
                        <i class="icon fas fa-envelope"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Username can't be blank</div>
                </div>

                <div class="field email">
                    <div class="input-area">
                        <input type="text" placeholder="Email Address" name="email">
                        <i class="icon fas fa-envelope"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Email can't be blank</div>
                </div>
                <div class="field password">
                    <div class="input-area">
                        <input type="password" placeholder="Password" name="password">
                        <i class="icon fas fa-lock"></i>
                        <i class="error error-icon fas fa-exclamation-circle"></i>
                    </div>
                    <div class="error error-txt">Password can't be blank</div>
                </div>

                <input type="submit" value="Sign Up" name="login">
            </form>

            <div class="sign-txt">Already registered? <a href="login.php">Login</a></div>
        </div>
    </center>
    <?php
   
    ?>


    <script>
        const form = document.querySelector("form");
        uField = form.querySelector(".username"),
        uInput = uField.querySelector("input"),
        eField = form.querySelector(".email"),
        eInput = eField.querySelector("input"),
        pField = form.querySelector(".password"),
        pInput = pField.querySelector("input");

        form.onsubmit = (e) => {
            e.preventDefault(); //preventing from form submitting
            //if email and password is blank then add shake class in it else call specified function
            (uInput.value == "") ? uField.classList.add("shake", "error") : checkUser();
            (eInput.value == "") ? eField.classList.add("shake", "error") : checkEmail();
            (pInput.value == "") ? pField.classList.add("shake", "error") : checkPass();

            setTimeout(() => { //remove shake class after 500ms
                uField.classList.remove("shake");
                eField.classList.remove("shake");
                pField.classList.remove("shake");
            }, 500);

            uInput.onkeyup = () => { checkUser(); }
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

            function checkUser() { //checkPass function
                if (pInput.value == "") { //if pass is empty then add error and remove valid class
                    pField.classList.add("error");
                    pField.classList.remove("valid");
                } else { //if pass is empty then remove error and add valid class
                    pField.classList.remove("error");
                    pField.classList.add("valid");
                }
            }

            //if eField and pField doesn't contains error class that mean user filled details properly
            if (!eField.classList.contains("error") && !pField.classList.contains("error")&& !uField.classList.contains("error")) {
                window.location.href = form.getAttribute("action"); //redirecting user to the specified url which is inside action attribute of form tag
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>