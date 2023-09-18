<?php
include("connectdb.php");
session_start();
$currentPage = "event";
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$sql = "SELECT * FROM events";
$result = mysqli_query($con, $sql);
?>

?>


<html>

<head>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="css/event.css" />
    <title>Greenify | Events</title>
</head>

<body>
    <?php include("header.php") ?>
    <div class="c-container">

        <div style="margin-left:50px;display: flex; align-items: center;">
            <div style="width:900px; display:flex; align-items: center;">
                <span><i class="bi bi-funnel" style="font-size:15px; margin-right: 5px;"></i></span>
                <span style="margin-right: 5px;">Filter by:</span>
                <select id="categoryFilter" class="form-control">
                    <option value="" selected disabled>--Select a category--</option>
                    <option value="Sustainable Workshops">Sustainable Workshops</option>
                    <option value="Eco Panels">Eco Panels</option>
                    <option value="Green Marketplace">Green Marketplace</option>
                    <option value="Nature Walks">Nature Walks</option>
                </select>
                <span id="clearFilter" class="clear-filter" style="display: none;"
                    onclick="clearFilter()"><i class="bi bi-x-circle-fill" style="color:rgb(0 73 28);"></i></span>
            </div>




            <?php if ($_SESSION['role'] == 'admin') { ?>
                <a href="manageEvent.php" style="text-decoration: none;">
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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal" > 🡆 RSVP</button></a>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

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