<?php session_start();
ob_start();
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Greenify UTM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/userManage.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include("connectdb.php");

    if (isset($_SESSION['approveUser'])) {
        echo $_SESSION['approveUser'];
        unset($_SESSION['approveUser']);
    }

    if (isset($_SESSION['disapproveUser'])) {
        echo $_SESSION['disapproveUser'];
        unset($_SESSION['disapproveUser']);
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './/PHPMailer/src/Exception.php';
    require './/PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    function sendEmail($email, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com"; // Enter your host here
        $mail->SMTPAuth = true;
        $mail->Username = "fafalettuce2023@gmail.com"; // Enter your email here
        $mail->Password = "fjoychryzqjjezwd"; // Enter your password here
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->IsHTML(true);
        $mail->From = "fafalettuce2023@gmail.com";
        $mail->FromName = "GREENIFY";
        $mail->Sender = "fafalettuce2023@gmail.com"; // indicates ReturnPath header
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email);

        if (!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

    if (isset($_GET['approvedUserId'])) {
        $id = $_GET['approvedUserId'];

        $query = mysqli_prepare($con, "SELECT email FROM users WHERE userID = ?");
        mysqli_stmt_bind_param($query, "i", $id);
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];

        $sql = "UPDATE users SET status = 'APPROVED' WHERE userID = '$id'";
        if (mysqli_query($con, $sql)) {
            $subject = "Registration Approved - GREENIFY UTM";
            $body = '<p>Dear user,</p>';
            $body .= '<p>We are pleased to inform you that your registration has been approved. Please click on the following link to login into your account:</p>';
            $body .= '<p><a href="localhost/utm/AppDev/login.php">localhost/utm/AppDev/login.php</a></p>';
            $body .= '<p>Congratulations and welcome to our community!</p>';
            $body .= '<p>Thanks,</p>';
            $body .= '<p>Greenify UTM</p>';

            if (sendEmail($email, $subject, $body)) {
                echo "<div class='success'><p>An email has been sent to the user account</p></div><br /><br /><br />";
                $_SESSION['approveUser'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-check2 toast-icon greenColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Success</span>
                                                <span class='message-text text-2'>User approved, and email send successfully</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active greenColor'></div>
                                    </div>";
            } else {
                echo "Email could not be sent.";
                $_SESSION['approveUser'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>User approved successfully but failed to sent the email</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
            }

        } else {
            echo "Error approving user: " . mysqli_error($con);
            $_SESSION['approveUser'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to approve the user</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";

        }
        header('Location: manageUser.php');
        exit;
    }

    if (isset($_GET['disapprovedUserId'])) {
        $id = $_GET['disapprovedUserId'];

        $query = mysqli_prepare($con, "SELECT * FROM users WHERE userID = ?");
        mysqli_stmt_bind_param($query, "i", $id);
        mysqli_stmt_execute($query);
        $result = mysqli_stmt_get_result($query);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        unlink("images\cardMatricImg/" . $row['matricImg']);

        $sql = "DELETE FROM users WHERE userID = '$id'";
        if (mysqli_query($con, $sql)) {
            $subject = "Registration Disapproved - GREENIFY UTM";
            $body = '<p>Dear user,</p>';
            $body .= '<p>We regret to inform you that your registration for Greenify UTM has been disapproved. Our review process identified certain factors that did not meet our registration criteria at this time.</p>';
            $body .= '<p>We appreciate your interest in Greenify UTM and encourage you to consider reapplying in the future if your circumstances change or if you believe there may have been a misunderstanding.</p>';
            $body .= '<p>Thank you for your understanding, and we wish you the best in your endeavors.</p>';
            $body .= '<p>Greenify UTM</p>';

            if (sendEmail($email, $subject, $body)) {
                echo "<div class='success'><p>An email has been sent to the user account</p></div><br /><br /><br />";
                echo "<div class='success'><p>An email has been sent to the user account</p></div><br /><br /><br />";
                $_SESSION['disapproveUser'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-check2 toast-icon greenColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Success</span>
                                                <span class='message-text text-2'>User disapproved, and email send successfully</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active greenColor'></div>
                                    </div>";
            } else {
                echo "Email could not be sent.";
                $_SESSION['disapproveUser'] = "<div class='statusMessageBox1'>
                                            <div class='toast-content'>
                                            <i class='bi bi-x toast-icon redColor'></i>
                                            <div class='message'>
                                                <span class='message-text text-1'>Failed</span>
                                                <span class='message-text text-2'>User disapproved successfully but failed to sent the email</span>
                                            </div>
                                            </div>
                                            <i class='bi bi-x toast-close'></i>
                                            <div class='progressbar active redColor'></div>
                                        </div>";
            }


        } else {
            echo "Error disapproving user: " . mysqli_error($con);
            $_SESSION['disapproveUser'] = "<div class='statusMessageBox1'>
                                        <div class='toast-content'>
                                        <i class='bi bi-x toast-icon redColor'></i>
                                        <div class='message'>
                                            <span class='message-text text-1'>Failed</span>
                                            <span class='message-text text-2'>Failed to disapprove the user</span>
                                        </div>
                                        </div>
                                        <i class='bi bi-x toast-close'></i>
                                        <div class='progressbar active redColor'></div>
                                </div>";
        }
        header('Location: manageUser.php');
        exit;
    }
    ?>
    <div>
        <div class="user-container">
            <a class="goback" href="adminHome.php">
                <i class="bi bi-arrow-left-short"></i>
                <span>Back</span>
            </a>
            <h1 class="title-text">Manage User</h1>
        </div>
        <div class="table-container">
            <?php
            $result = mysqli_query($con, "SELECT * FROM users WHERE status != 'APPROVED'");

            if (mysqli_num_rows($result) > 0) {
                echo <<<HTML
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Matric Number</th>
                    <th scope="col">Card Matric Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
    HTML;

                while ($row = mysqli_fetch_array($result)) {
                    echo <<<HTML
            <tr>
                <th scope="row">{$row['userID']}</th>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td>{$row['matricNo']}</td>
                <td><button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                data-bs-target="#openImgModal{$row['userID']}">Open Image <i class="bi bi-box-arrow-up-right"></i></i></button></td>
                <td><button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#approveModal{$row['userID']}"><i class="bi bi-clipboard-check-fill"></i></button>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                data-bs-target="#disapproveModal{$row['userID']}"><i class="bi bi-trash3-fill"></i></button></td>
            </tr>

            <!-- approve model -->
            <div class="modal fade" id="approveModal{$row['userID']}" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="approveModalLabel"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-clipboard-check-fill" viewBox="0 0 19 19">
                                <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z"/>
                                </svg> Confirm Approval</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6 style="font-weight:normal;">Are you sure you want to approve this user?</h6>
                            <h6><span style="font-weight:normal;">Matric Number: </span>{$row['matricNo']}</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="manageUser.php?approvedUserId={$row['userID']}"><button type="button" class="btn btn-primary">Approve</button></a>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- disapprove model -->
            <div class="modal fade" id="disapproveModal{$row['userID']}" tabindex="-1" aria-labelledby="disapproveModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="disapproveModalLabel"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 19 19">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>Confirm Deletion</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6 style="font-weight:normal;">Are you sure you want to disapprove this user?</h6>
                            <h6><span style="font-weight:normal;">Matric Number: </span>{$row['matricNo']}</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="manageUser.php?disapprovedUserId={$row['userID']}"><button type="button" class="btn btn-danger">Disapprove</button></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- open image model -->
            <div class="modal fade" id="openImgModal{$row['userID']}" tabindex="-1" aria-labelledby="openImgModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="openImgModalLabel"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-images" viewBox="0 0 19 19">
                                <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                                </svg> Card Matric Image-Matric Number-{$row['matricNo']}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="images/cardMatricImg/{$row['matricImg']}" width="765px" alt="error">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        HTML;
                }

                echo <<<HTML
            </tbody>
        </table>
    HTML;
            }
            ?>

        </div>
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