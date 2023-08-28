<?php
include("connectdb.php");
session_start();
$currentPage = "event";
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
} ?>


<html>

<head>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="css/event.css" />
    <title>Greenify | Locate</title>
</head>

<body>
    <?php include("header.php") ?>
    <div class="c-container">
        <div class="ag-format-container">
            <div class="ag-courses_box">
                <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link" style="text-decoration:none" type="button"
                        data-toggle="modal" data-target="#exampleModal">
                        <div class="ag-courses-item_bg"></div>

                        <div class="ag-courses-item_title">
                            <center><img src="images/sample.png" alt="" width="100%"
                                    style="border-top-left-radius: 25px; border-top-right-radius: 25px; padding-top:10px">
                            </center>
                            Go-Green Week : Cultivating Awareness, Nurturing Nature.
                        </div>

                        <div class="ag-courses-item_date-box">
                            Date |
                            <span class="ag-courses-item_date">
                                27.08.2023, Sunday
                            </span>
                        </div>

                        <div class="ag-courses-item_date-box">
                            Duration |
                            <span class="ag-courses-item_date">
                                7 day(s) 0 hour(s) 0 minute(s)
                            </span>
                        </div>

                        <div class="ag-courses-item_date-box">
                            Category |
                            <span class="ag-courses-item_date">
                                Campaign
                            </span>
                        </div>

                        <div class="ag-courses-item_date-box">
                            Organizer |
                            <span class="ag-courses-item_date">
                                Faculty of Computing
                            </span>
                        </div>

                        <div class="ag-courses-item_date-box">
                            Location |
                            <span class="ag-courses-item_date">
                                N28a, Faculty of Computing
                            </span>
                        </div>


                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Go-Green Week</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="images/sample.png" alt="" width="100%">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                        <hr>
                    <h6>Event Details:</h6>
                    <ul>
                        <li>🗓️ 27.08.2023 - 03.09.2023</li>
                        <li>📍 N28a, Faculty of Computing</li>
                        <li>🗂️ Campaign</li>

                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-primary"> 🡆 RSVP</button>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBte_REyjpbShM5sBpPLVEXRgFRsCbohes&map_ids=79fc16395651c35a&callback=initMap">
        </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>




</body>

</html>