<?php
include("connectdb.php");
session_start();
$currentPage = "locate";
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
} ?>


<html>

<head>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="css/locate.css" />
    <link rel="stylesheet" href="css/forum.css" />
    <title>Greenify | Locate</title>
</head>

<body>
    <?php include("header.php") ?>

    <?php
    if (isset($successMessage)) {
        echo $successMessage;
    }
    ?>
    <div class="map-container">
        <div id="map"></div>
        <div class="info">



            <center>
                <div style="display: flex; align-items: center;">
                    <span><i class="bi bi-funnel" style="font-size:15px; margin-right: 5px;"></i></span>
                    <span style="margin-right: 5px;">Filter by:</span>
                    <select id="itemTypeFilter" class="form-select" onchange="applyMarkersFilter()"
                        style="width:200px;">
                        <option value="">All Items</option>
                        <option value="hub">Recycle Hub</option>
                        <option value="bus">Bus Stop</option>
                        <option value="park">Green Park</option>
                        <option value="bike">Campus Bike Station</option>
                    </select>
                </div>

                <div class="labelled-items">

                    <table class="table1" cellpadding="11px" cellspacing="0">
                        <tr>
                            <td style="width:30%"><img src="images/hub.png" alt="" width=25px style="float:right"></td>
                            <td>Recycle Hub</td>
                        </tr>
                        <tr>
                            <td><img src="images/bus.png" alt="" width=25px style="float:right"></td>
                            <td>Bus Stop</td>
                        </tr>
                        <tr>
                            <td><img src="images/park.png" alt="" width=25px style="float:right"></td>
                            <td>Green Park</td>
                        </tr>
                        <tr>
                            <td><img src="images/bike.png" alt="" width=25px style="float:right"></td>
                            <td>Campus Bike Station</td>

                        </tr>

                        </tr>
                    </table>

                    <p id="tips">💡 Tips : Click on the icons on map to start navigation ! </p>
                </div>
            </center>

            <!-- Button trigger modal -->
            <?php if($_SESSION['role']=='admin'){ ?>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-outline-danger"
                    style="margin-top:20px;width:100px;margin-right:15px" data-bs-toggle="modal"
                    data-bs-target="#deleteModal">
                    Delete
                </button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal" style="margin-top:20px;width:100px;margin-right:75px">
                    Create
                </button>
            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="deleteModalLabel">🗑 Delete Items</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Choose item to be deleted :
                            <select id="deleteItemTypeFilter" class="form-select" onchange="applyDeleteFilter()">
                                <option value="">All Items</option>
                                <option value="hub">Recycle Hub</option>
                                <option value="bus"> Bus Stop</option>
                                <option value="park">Green Park</option>
                                <option value="bike">Campus Bike Station</option>
                            </select>
                            <br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $selectQuery = "SELECT * FROM labelled_item";
                                    $result = mysqli_query($con, $selectQuery);

                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<tr class="item-row ' . $row['itemName'] . '">';
                                        echo '<td ><img src="' . $row['itemImage'] . '" alt="" width="20px"> &nbsp' . ucfirst($row['itemName']) . ' </td>';
                                        echo '<td>' . number_format($row['item_lat'], 3) . '</td>';
                                        echo '<td>' . number_format($row['item_lng'], 3) . '</td>';
                                        echo '<td><button class="btn btn-outline-danger" onclick="showDeleteConfirmation(' . $row['itemID'] . ')">-</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                                <div id="totalItemCount"></div>
                                <br>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">📍Creating landmark</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="insert_positions.php" method="post">
                                Choose the labelled item to mark on map: <br> <br>
                                <div id="radios">
                                    <label for="hub" class="material-icons">
                                        <input type="radio" name="mode" id="hub" value="hub" checked />
                                        <span><img src="images/hub.png" alt="" width="20px"></span>
                                    </label>
                                    <label for="bus" class="material-icons">
                                        <input type="radio" name="mode" id="bus" value="bus" />
                                        <span><img src="images/bus.png" alt="" width="20px"></span>
                                    </label>
                                    <label for="park" class="material-icons">
                                        <input type="radio" name="mode" id="park" value="park" />
                                        <span><img src="images/park.png" alt="" width="20px"></span>
                                    </label>
                                    <label for="bike" class="material-icons">
                                        <input type="radio" name="mode" id="bike" value="bike" />
                                        <span><img src="images/bike.png" alt="" width="20px"></span>
                                    </label>
                                </div>

                                <br> <br>

                                Choose the location of selected item: <br> <br>

                                <table class="table2">
                                    <tr>
                                        <td style="width:40%; text-align: right; padding-right:10px"> <label
                                                for="lat">Latitude:</label></td>
                                        <td><input type="text" id="lat" name="lat"></td>
                                    </tr>
                                    <tr>
                                        <td style="width:40%; text-align: right; padding-right:10px"><label
                                                for="lgn">Longitude:</label></td>
                                        <td><input type="text" id="lgn" name="lgn"></td>
                                    </tr>
                                </table>

                                <br>
                                <div class="card">
                                    <div class="card-header">
                                        💡 Tips
                                    </div>
                                    <div class="card-body">
                                        <ol>
                                            <li>Navigate to the link below</li>
                                            <li>Locate the desired location</li>
                                            <li>Right-click to copy the coordinates</li>
                                            <li>Paste the coordinates respectively!</li>
                                        </ol>

                                        <a href="https://www.google.com/maps/@1.5602393950091624,103.63827783102548,15.9z?entry=ttu"
                                            target="_blank" class="btn btn-outline-primary"
                                            style="font-size:15px;float:right">Find the coordinates</a>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Create</button>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var markers = [];

        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 1.5602393950091624, lng: 103.63827783102548 },
                zoom: 16,
                mapId: '79fc16395651c35a',
                mapTypeControlOptions: {
                    mapTypeIds: ['roadmap', 'terrain']
                }
            });

            fetchPositionsFromDatabase();
        }
        function fetchPositionsFromDatabase() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_positions.php", true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var positions = JSON.parse(xhr.responseText);
                        createMarkersFromPositions(positions);

                    } else {
                        console.error("Error fetching positions from the database");
                    }
                }
            };

            xhr.send();
        }


        var infoWindowOpen = false;

        function createMarkersFromPositions(positions) {
            for (let i = 0; i < positions.length; i++) {
                const currentMarker = positions[i];
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(currentMarker.item_lat), lng: parseFloat(currentMarker.item_lng) },
                    map,
                    icon: {
                        url: currentMarker.itemImage,
                        scaledSize: new google.maps.Size(25, 25)
                    },
                    animation: google.maps.Animation.DROP
                });


                marker.itemType = currentMarker.itemName;
                markers.push(marker);
                marker.addListener('click', function () {
                    redirectToGoogleMapsPage(marker.getPosition());
                });

                const tooltip = new google.maps.InfoWindow({
                    content: `Click me !`
                });

                marker.addListener('mouseover', function () {
                    tooltip.open(map, marker);
                    infoWindowOpen = true;
                    setTimeout(() => {
                        if (infoWindowOpen) {
                            document.querySelector(".gm-ui-hover-effect").style.display = "none";
                        }
                    }, 10);
                });

                marker.addListener('mouseout', function () {
                    tooltip.close();
                    infoWindowOpen = false;
                    setTimeout(() => {
                        document.querySelector(".gm-ui-hover-effect").style.display = "";
                    }, 10);
                });


            }

        }
        function redirectToGoogleMapsPage(position) {
            const lat = position.lat();
            const lng = position.lng();
            const googleMapsURL = `https://www.google.com/maps/dir/Current+Location/${lat},${lng}`;
            window.open(googleMapsURL, '_blank');
        }




        function applyMarkersFilter() {
            const selectedItemType = document.getElementById('itemTypeFilter').value;
            console.log("Selected item type:", selectedItemType);

            markers.forEach(marker => {
                const markerType = marker.itemType;
                console.log("Marker item type:", markerType);

                if (selectedItemType === '' || markerType === selectedItemType) {
                    marker.setVisible(true);
                } else {
                    marker.setVisible(false);
                }
            });
        }



        function showDeleteConfirmation(itemId) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = "delete_positions.php?id=" + itemId;
            }
        }
        function applyDeleteFilter() {
            const selectedItemType = document.getElementById('deleteItemTypeFilter').value;
            const itemRows = document.querySelectorAll('.item-row');
            let totalCount = 0;

            itemRows.forEach(row => {
                const itemType = row.classList[1];
                if (selectedItemType === '' || itemType === selectedItemType) {
                    row.style.display = 'table-row';
                    totalCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const totalCountDisplay = document.getElementById('totalItemCount');
            totalCountDisplay.innerHTML = `Total labelled <strong>${selectedItemType}</strong> item(s) : ${totalCount}`;

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
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBte_REyjpbShM5sBpPLVEXRgFRsCbohes&map_ids=79fc16395651c35a&callback=initMap">
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>



</body>

</html>