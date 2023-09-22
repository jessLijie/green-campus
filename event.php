<?php
use PHPMailer\PHPMailer\PHPMailer;

require './/PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
include("connectdb.php");
session_start();
ob_start();


$currentPage = "event";
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$sql = "SELECT * FROM events";
$result = mysqli_query($con, $sql);
?>
<?php
$email = $_SESSION["email"];
$error = "";
if (isset($_POST['confirmRSVP'])) {
    $eventID = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $category = $_POST['category'];
    $locationName = $_POST['locationName'];
    $organizer = $_POST['organizer'];
    $sel_query = "SELECT * FROM `users` WHERE email='" . $email . "'";
    $results = mysqli_query($con, $sel_query);

    $row = mysqli_num_rows($results);
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div>
            <br /><a href='javascript:history.go(-1)'>Go Back</a>";
    } else {

        $output = '<p>Dear ' . $_SESSION['username'] . ',</p>';
        $output .= '<p>Thanks for registering for the event ' . $eventName . '. </br> Below are the event\'s details: </p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p>Event Name: ' . $eventName . '</p>';
        $output .= '<p>Category: ' . $category . '</p>';
        $output .= '<p>Starting on: ' . $start . '</p>';
        $output .= '<p>Ending on: ' . $end . '</p>';
        $output .= '<p>Location: ' . $locationName . '</p>';
        $output .= '<p>Organizer: ' . $organizer . '</p>';
        //output link
        $output .= '<p></p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p></p>';
        $output .= '<p></p>';
        $output .= '<p>Thanks,</p>';
        $output .= '<p>Greenify UTM</p>';
        $body = $output;
        $subject = "RSVP Confirmation - GREENIFY UTM";

        $email_to = $email;
        $fromserver = "fafalettuce2023@gmail.com"; //Enter your email here

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com"; // Enter your host here
        $mail->SMTPAuth = true;
        $mail->Username = "fafalettuce2023@gmail.com"; // Enter your email here
        $mail->Password = "fjoychryzqjjezwd"; //Enter your password here
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->IsHTML(true);
        $mail->From = "fafalettuce2023@gmail.com";
        $mail->FromName = "GREENIFY";
        $mail->Sender = $fromserver; // indicates ReturnPath header
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email_to);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "<script>alert('A RSVP confirmation email has been sent to you.');</script>";
        }
    }
}

?>

<html>

<head>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="css/event.css" />
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/forum.css" />
    <title>Greenify | Events</title>
</head>

<body>
    <?php include("header.php") ?>
    <div class="c-container">

        <div style="margin-left:50px;display: flex; align-items: center;">

            <div class='search-box' style="margin-right:15px;align-items:center">

                <div class="search" style="margin-bottom:0;padding-bottom:0">
                    <input id="eventSearch" class="form-control" type="text" name="search_val"
                        placeholder="Search Event" style="border-bottom: 2px solid green;border-radius:0" />
                    <button type="submit" name="search"><i class="bi bi-search" style="color: whitesmoke"></i></button>
                </div>
            </div>

            <div style="width:1000px; display:flex; align-items: center;">
                <span><i class="bi bi-funnel" style="font-size:15px; margin-right: 5px;"></i></span>
                <span style="margin-right: 5px;">Filter by:</span>
                <select id="categoryFilter" class="form-control">
                    <option value="" selected disabled>--Select a category--</option>
                    <option value="Sustainable Workshops">Sustainable Workshops</option>
                    <option value="Eco Panels">Eco Panels</option>
                    <option value="Green Marketplace">Green Marketplace</option>
                    <option value="Nature Walks">Nature Walks</option>
                </select>
                <span id="clearFilter" class="clear-filter" style="display: none;" onclick="clearFilter()"><i
                        class="bi bi-x-circle-fill" style="color:rgb(0 73 28);"></i></span>
            </div>

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <a href="manageEvent.php" style="text-decoration: none;margin-right:50px">
                    <button type="button" class="btn btn-outline-primary" style="width: 150px;">
                        Manage Event
                    </button>
                </a>
            <?php } ?>

        </div>

        <div id="filteredEvents" class="ag-format-container">
            <div class="ag-courses_box">
                <?php
                $modalContent = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $modalContent[$row['eventID']] = array(
                        'eventName' => $row['eventName'],
                        'duration' => $row['duration'],
                        'category' => $row['category'],
                        'organizer' => $row['organizer'],
                        'startDate' => $row['startDate'],
                        'endDate' => $row['endDate'],
                        'eventDescp' => $row['eventDescp'],
                        'latitude' => $row['latitude'],
                        'longitude' => $row['longitude'],
                        'locationName' => $row['locationName'],
                        'eventImage' => $row['eventImage']
                    );
                    ?>
                    <div class="ag-courses_item">

                        <a href="#" class="ag-courses-item_link" style="text-decoration:none" type="button"
                            data-toggle="modal" data-target="#exampleModal<?php echo $row['eventID']; ?>">
                            <div class="ag-courses-item_bg"></div>

                            <div class="ag-courses-item_title">
                                <center
                                    style="background-color:#b1e8c9;border-top-left-radius: 30px; border-top-right-radius: 30px;">
                                    <img src="<?php echo $row['eventImage']; ?>" alt="" width="100%" style="border-top-left-radius: 30px; border-top-right-radius: 30px;
                                        height: 100px;  
                                        object-fit:contain;
                                        ">
                                </center>
                                <?php echo $row['eventName'] ?>
                            </div>

                            <div class="ag-courses-item_date-box">
                                Start from |
                                <span class="ag-courses-item_date">
                                    <?php
                                    $startDate = strtotime($row['startDate']);
                                    $formattedDate = date('d/m/Y, l', $startDate);
                                    echo $formattedDate;
                                    ?>
                                </span>
                            </div>


                            <div class="ag-courses-item_date-box">
                                Duration |
                                <span class="ag-courses-item_date">
                                    <?php echo $row['duration'] ?>
                                </span>
                            </div>

                            <div class="ag-courses-item_date-box">
                                Category |
                                <span class="ag-courses-item_date">
                                    <?php echo $row['category'] ?>
                                </span>
                            </div>

                            <div class="ag-courses-item_date-box">
                                Organizer |
                                <span class="ag-courses-item_date">
                                    <?php echo $row['organizer'] ?>
                                </span>
                            </div>

                            <div class="ag-courses-item_date-box">
                                Location |
                                <span class="ag-courses-item_date">
                                    <?php echo $row['locationName'] ?>
                                </span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    mysqli_data_seek($result, 0);

    while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <div class="modal fade" id="exampleModal<?php echo $row['eventID']; ?>" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php echo $modalContent[$row['eventID']]['eventName']; ?>
                        </h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img src="<?php echo $modalContent[$row['eventID']]['eventImage']; ?>" alt="" width="100%">
                        <p>
                            <?php echo $modalContent[$row['eventID']]['eventDescp']; ?>
                        </p>

                        <hr>
                        <h6>Event Details:</h6>
                        <ul>
                            <li>
                                🗓️
                                <?php
                                $startDate = strtotime($modalContent[$row['eventID']]['startDate']);
                                $endDate = strtotime($modalContent[$row['eventID']]['endDate']);

                                $formattedStartDate = date('d/m/Y (H:i)', $startDate);
                                $formattedEndDate = date('d/m/Y (H:i)', $endDate);

                                echo $formattedStartDate . ' to ' . $formattedEndDate;
                                ?>
                            </li>

                            <li>⌛
                                <?php echo $modalContent[$row['eventID']]['duration']; ?>
                            </li>
                            <li>🗂️
                                <?php echo $modalContent[$row['eventID']]['category']; ?>
                            </li>
                            <li>📍
                                <?php echo $modalContent[$row['eventID']]['locationName']; ?>
                            </li>
                            <li>👤
                                <?php echo $modalContent[$row['eventID']]['organizer']; ?>
                            </li>
                        </ul>
                        <hr>
                        <p>Check out the location !</p>
                        <p>
                            <iframe width="100%" height="170" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.com/maps?q=<?php echo $modalContent[$row['eventID']]['latitude']; ?>,<?php echo $modalContent[$row['eventID']]['longitude']; ?>&hl=en&z=18&amp;output=embed">
                            </iframe>

                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" data-target="#rsvp<?php echo $row['eventID']; ?>" data-toggle="modal"
                            data-dismiss="modal" class="btn btn-outline-primary"> 🡆 RSVP</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
    mysqli_data_seek($result, 0);

    while ($row = mysqli_fetch_assoc($result)) {
        $modalContent[$row['eventID']] = array(
            'eventName' => $row['eventName'],
            'duration' => $row['duration'],
            'category' => $row['category'],
            'organizer' => $row['organizer'],
            'startDate' => $row['startDate'],
            'endDate' => $row['endDate'],
            'eventDescp' => $row['eventDescp'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'locationName' => $row['locationName'],
            'eventImage' => $row['eventImage']
        );
        ?>

        <div class="modal fade" id="rsvp<?php echo $row['eventID']; ?>" aria-hidden="true"
            aria-labelledby="rsvp<?php echo $row['eventID']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rsvp">📩 Confirm to register for this event ?</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-style:regular">

                        <p>
                            The event "<strong>
                                <?php echo $modalContent[$row['eventID']]['eventName']; ?>
                            </strong>" is happening on
                            <?php
                            $startDate = strtotime($modalContent[$row['eventID']]['startDate']);
                            $endDate = strtotime($modalContent[$row['eventID']]['endDate']);

                            $formattedStartDate = date('d/m/Y (H:i)', $startDate);
                            $formattedEndDate = date('d/m/Y (H:i)', $endDate);

                            echo $formattedStartDate . ' to ' . $formattedEndDate;
                            ?>

                        </p>
                        <p>Registering for : <strong>
                                <?php echo $_SESSION['username'] ?>
                            </strong> </br>
                            Click 'confirm' below to receive an email registered for this account.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-target="#exampleModal<?php echo $row['eventID']; ?>"
                            data-toggle="modal" data-dismiss="modal">Back to event</button>

                        <form id="rsvpForm<?php echo $row['eventID']; ?>" method="post">
                            <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
                            <input type="hidden" name="eventName"
                                value="<?php echo $modalContent[$row['eventID']]['eventName']; ?>">
                            <input type="hidden" name="category"
                                value="<?php echo $modalContent[$row['eventID']]['category']; ?>">
                            <input type="hidden" name="start" value="<?php echo $formattedStartDate ?>">
                            <input type="hidden" name="end" value="<?php echo $formattedEndDate ?>">
                            <input type="hidden" name="locationName"
                                value="<?php echo $modalContent[$row['eventID']]['locationName']; ?>">
                            <input type="hidden" name="organizer"
                                value="<?php echo $modalContent[$row['eventID']]['organizer']; ?>">

                            <button type="submit" class="btn btn-outline-primary" name="confirmRSVP"> Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <?php } ?>



    <script>
        document.getElementById('categoryFilter').addEventListener('change', function () {
            var category = this.value;
            filterEvents(category);
        });

        function filterEvents(category) {
            $.ajax({
                url: 'filterEvents.php',
                type: 'POST',
                data: { category: category },
                success: function (data) {
                    $('#filteredEvents').html(data);
                    toggleClearFilter();
                }
            });
        }

        document.getElementById('eventSearch').addEventListener('keyup', function () {
            var keyword = this.value;
            searchEvents(keyword);
        });

        function searchEvents(keyword) {
            $.ajax({
                url: 'searchEvent.php',
                type: 'POST',
                data: { search_val: keyword },
                success: function (data) {
                    $('#filteredEvents').html(data);
                }
            });
        }

        function toggleClearFilter() {
            var clearFilter = document.getElementById('clearFilter');
            var categoryFilter = document.getElementById('categoryFilter');

            if (categoryFilter.value !== "") {
                clearFilter.style.display = 'inline-block';
                clearFilter.style.cursor = 'pointer';
                clearFilter.style.padding = '0 0 0 10px';
            } else {
                clearFilter.style.display = 'none';
            }
        }

        function clearFilter() {
            window.location.href = 'event.php';
        }


    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>


</body>

</html>