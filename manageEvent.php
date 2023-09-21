<?php
include("connectdb.php");
session_start();
$currentPage = "manageEvent";
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$sql = "SELECT * FROM events";
$result = mysqli_query($con, $sql);
?>



<html>

<head>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="css/manageEvent.css" />
    <link rel="stylesheet" href="css/forum.css" />
    <title>Greenify | Manage Event</title>
</head>

<body>
    <?php include("header.php") ?>


    <div class="table-container">

        <div style="display: flex; align-items: center;">
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
                <span id="clearFilter" class="clear-filter" style="display: none;" onclick="clearFilter()"><i
                        class="bi bi-x-circle-fill" style="color:rgb(0 73 28);"></i></span>
            </div>




            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal"
                style="margin-left:20px">
                Add Event
            </button>

        </div>


        <?php
        if (isset($successMessage)) {
            echo $successMessage;
        }
        ?>
        <table class="table table-hover" style="margin-top:20px">
            <thead class="table-success">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Event</th>
                    <th scope="col">Date</th>
                    <th scope="col">Category</th>
                    <th scope="col">Organizer</th>
                    <th scope="col">Location</th>
                    <th scope="col" colspan='2'>Action</th>

                </tr>
            </thead>
            <tbody>
                
                    <?php $modalContent = array();
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $modalContent[$row['eventID']] = array(
                            'eventID' => $row['eventID'],
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
                         <tr class="event-row" data-category="<?php echo $row['category']; ?>">
                        <th scope="row">
                            <?php echo $counter ?>
                        </th>
                        <td>
                            <?php echo $row['eventName']; ?>
                        </td>
                        <td>
                            <?php $startDate = strtotime($row['startDate']);
                            $formattedDate = date('d/m/Y, l', $startDate);
                            echo $formattedDate; ?>
                        </td>
                        <td>
                            <?php echo $row['category']; ?>
                        </td>
                        <td>
                            <?php echo $row['organizer']; ?>
                        </td>
                        <td>
                            <?php echo $row['locationName']; ?>
                        </td>
                        <td><a href="#" class="ag-courses-item_link" style="text-decoration:none" type="button"
                                data-toggle="modal" data-target="#exampleModal<?php echo $row['eventID']; ?>"><i
                                    class="bi bi-pencil-square"></i></a>
                        </td>
                        <td>
                            <a href="#" class="ag-courses-item_link" style="text-decoration:none" type="button"
                                data-toggle="modal" data-target="#deleteModal<?php echo $row['eventID']; ?>"><i
                                    class="bi bi-trash3-fill" style="color:red"></i></a>
                        </td>
                    </tr>

                </tbody>
                <?php
                $counter++;
                    }
                    ?>
        </table>

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
                                Editing
                                <?php echo $modalContent[$row['eventID']]['eventName']; ?>
                            </h5>
                            <button type="button" class="btn-close" data-dismiss="modal"></button>

                        </div>

                        <form action="updateEvent.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="eventID"
                                value="<?php echo $modalContent[$row['eventID']]['eventID']; ?>">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div cladss="form-group">
                                            <label for="eventName" class="title"><strong>🎍 Event</strong></label>
                                            <input type="text" class="form-control" id="eventName" name="eventName"
                                                value="<?php echo $modalContent[$row['eventID']]['eventName']; ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="category" class="title"><strong>🗂️ Category</strong></label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option value="" disabled>--Select a category--</option>
                                                <option value="Sustainable Workshops" <?php if ($modalContent[$row['eventID']]['category'] === 'Sustainable Workshops')
                                                    echo 'selected'; ?>>Sustainable Workshops</option>
                                                <option value="Eco Panels" <?php if ($modalContent[$row['eventID']]['category'] === 'Eco Panels')
                                                    echo 'selected'; ?>>Eco Panels</option>
                                                <option value="Green Marketplace" <?php if ($modalContent[$row['eventID']]['category'] === 'Green Marketplace')
                                                    echo 'selected'; ?>>Green Marketplace</option>
                                                <option value="Nature Walks" <?php if ($modalContent[$row['eventID']]['category'] === 'Nature Walks')
                                                    echo 'selected'; ?>>Nature Walks</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="form-group">
                                    <label for="startDate"><strong>🗓️ Start from</strong></label>
                                    <input type="datetime-local" class="form-control" id="startDate" name="startDate"
                                        value="<?php echo $modalContent[$row['eventID']]['startDate']; ?>">
                                </div><br>

                                <div class="form-group">
                                    <label for="endDate"><strong>⌛ End at</strong></label>
                                    <input type="datetime-local" class="form-control" id="endDate" name="endDate"
                                        value="<?php echo $modalContent[$row['eventID']]['endDate']; ?>">
                                </div><br>


                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="locationName"><strong>📍 Location</strong></label>
                                            <input type="text" class="form-control" id="locationName" name="locationName"
                                                value="<?php echo $modalContent[$row['eventID']]['locationName']; ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="organizer"><strong>👤 Organizer</strong></label>
                                            <input type="text" class="form-control" id="organizer" name="organizer"
                                                value="<?php echo $modalContent[$row['eventID']]['organizer']; ?>">
                                        </div>
                                    </div>
                                </div><br>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="locationName"><strong>▶️Latitude</strong></label>
                                            <input type="text" class="form-control" id="locationName" name="locationName"
                                                value="<?php echo $modalContent[$row['eventID']]['latitude']; ?>">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="organizer"><strong>⏩Longitude</strong></label>
                                            <input type="text" class="form-control" id="organizer" name="organizer"
                                                value="<?php echo $modalContent[$row['eventID']]['longitude']; ?>">
                                        </div>
                                    </div>
                                </div><br>

                                <a href="https://www.google.com/maps/@1.5602393950091624,103.63827783102548,15.9z?entry=ttu"
                                            target="_blank" class="btn btn-outline-primary"
                                            style="font-size:15px;float:right">⇲ Find the coordinates</a><br><br><br>

                                <div class="form-group">
                                    <label for="eventDescp"><strong>📢 Description</strong></label>
                                    <textarea class="form-control" id="eventDescp"
                                        name="eventDescp"><?php echo $modalContent[$row['eventID']]['eventDescp']; ?></textarea>
                                </div><br>

                                <div class="form-group">
                                    🖼️<strong>Current poster/mage</strong>
                                    <img src="<?php echo $modalContent[$row['eventID']]['eventImage']; ?>" width="100%"
                                        alt=""><br>
                                    <br>
                                    <label for="eventImage"><strong>🖼️ Upload a new poster/image</strong></label>
                                    <input type="file" class="form-control" id="eventImage" name="eventImage"
                                        accept="image/*">
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        mysqli_data_seek($result, 0);

        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="modal fade" id="deleteModal<?php echo $row['eventID']; ?>" tabindex="-1" role="dialog"
                aria-labelledby="IDModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this event?
                            <br>
                            Event : <strong>
                                <?php echo $modalContent[$row['eventID']]['eventName']; ?>
                            </strong>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a href="deleteEvent.php?eventID=<?php echo $row['eventID']; ?>&eventImage=<?php echo $modalContent[$row['eventID']]['eventImage']; ?>"
                                class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Adding Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="addEvent.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="eventName" class="title"><strong>🎍 Event</strong></label>
                                        <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Event's name"
                                            required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="category" class="title"><strong>🗂️ Category</strong></label>
                                        <select class="form-control" name="category" id="category" required>
                                            <option value="" disabled selected>--Select a category--</option>
                                            <option value="Sustainable Workshops">Sustainable Workshops</option>
                                            <option value="Eco Panels">Eco Panels</option>
                                            <option value="Green Marketplace">Green Marketplace</option>
                                            <option value="Nature Walks">Nature Walks</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="startDate"><strong>🗓️ Start from</strong></label>
                                <input type="datetime-local" class="form-control" id="startDate" name="startDate"
                                    required>
                            </div><br>

                            <div class="form-group">
                                <label for="endDate"><strong>⌛ End at</strong></label>
                                <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
                            </div><br>


                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="location"><strong>📍 Location</strong></label>
                                        <input type="text" class="form-control" id="locationName" name="locationName" placeholder="Event's location"
                                            required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="organizer"><strong>👤 Organizer</strong></label>
                                        <input type="text" class="form-control" id="organizer" name="organizer"placeholder="Event's organizer"
                                            required>
                                    </div>
                                </div>
                            </div><br>


                            <div class="form-group">
                                <label for="description"><strong>📢 Description</strong></label>
                                <textarea class="form-control" id="eventDescp" name="eventDescp" required placeholder="Event's description"></textarea>
                            </div><br>

                            <div class="form-group">
                                <label for="eventImage"><strong>🖼️ Event Poster/Image</strong></label>
                                <input type="file" class="form-control" id="eventImage" name="eventImage"
                                    accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('categoryFilter').addEventListener('change', function () {
                var category = this.value;
                filterEvents(category);
            });

            function filterEvents(category) {
                var tableRows = document.querySelectorAll('.event-row');

                tableRows.forEach(function (row) {
                    var rowCategory = row.getAttribute('data-category');

                    if (category === "" || rowCategory === category) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
                toggleClearFilter();
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
                window.location.href = 'manageEvent.php';
            }

            var statusMessageBox = document.querySelector('.statusMessageBox1');
            if(statusMessageBox){
                setTimeout(function() {
                    statusMessageBox.classList.add("slideOut");
                }, 4000);
            }
            var progressbar = document.querySelector('.progressbar.active');
            if (progressbar) {
                setTimeout(function() {
                    progressbar.classList.remove("active");
                    statusMessageBox.remove();
                }, 4500);
            }

            var toastCloseButtons = document.querySelectorAll('.toast-close');
            toastCloseButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var statusMessageBox = document.querySelector('.statusMessageBox1');
                    statusMessageBox.classList.add("slideOut");

                    setTimeout(function() {
                        progressbar.classList.remove("active");
                        statusMessageBox.remove();
                    }, 300);
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>





</body>

</html>