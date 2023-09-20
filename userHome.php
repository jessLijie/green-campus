<?php session_start();
$currentPage = "home";
if (isset($_SESSION['userID'])) {
  $userID = $_SESSION['userID'];
}
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
  <link rel="stylesheet" href="./css/dashboard.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</head>

<body>
  <?php
  include("header.php");
  include("connectdb.php");

  $query = "%%";
  $searchMsg = "";

  if (isset($_GET['query'])) {
    $query = mysqli_real_escape_string($con, $_GET['query']);
    $query = "%" . $query . "%";
    $searchMsg = "<h5>Search results for : " . $_GET['query'] . "</h5>";
  }
  ?>
  <div class="d-flex flex-nowrap" style="margin: 40px 10px;">
    <div class="overflow-auto">
      <div style="display: inline-flex; width:100%; justify-content: space-between">
        <div style="display: inline-flex">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation" style="padding: 0">
              <a href="userHome.php" style="text-decoration: none"><button class="nav-link active" id="all-tab"
                  data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="submit" role="tab"
                  aria-controls="all-tab-pane" aria-selected="true" style="padding: 8px 16px;">All</button></a>
            </li>
            <li class="nav-item" role="presentation" style="padding: 0">
              <button class="nav-link" id="campusNews-tab" data-bs-toggle="tab" data-bs-target="#campusNews-tab-pane"
                type="button" role="tab" aria-controls="campusNews-tab-pane" aria-selected="false"
                style="padding: 8px 16px;">Campus News</button>
            </li>
            <li class="nav-item" role="presentation" style="padding: 0">
              <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events-tab-pane"
                type="button" role="tab" aria-controls="events-tab-pane" aria-selected="false"
                style="padding: 8px 16px;">Events</button>
            </li>
            <li class="nav-item" role="presentation" style="padding: 0">
              <button class="nav-link" id="achievements-tab" data-bs-toggle="tab"
                data-bs-target="#achievements-tab-pane" type="button" role="tab" aria-controls="achievements-tab-pane"
                aria-selected="false" style="padding: 8px 16px;">Achievements</button>
            </li>
            <li class="nav-item" role="presentation" style="padding: 0">
              <button class="nav-link" id="facilities-tab" data-bs-toggle="tab" data-bs-target="#facilities-tab-pane"
                type="button" role="tab" aria-controls="facilities-tab-pane" aria-selected="false"
                style="padding: 8px 16px;">Facilities</button>
            </li>
          </ul>
        </div>
        <div style="display: inline-flex; margin-right: 1.5%">
          <form class="d-flex" action="" method="GET">
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>

      <?php

      function newsfees($result)
      {
        echo '<div class="d-flex flex-wrap" style="gap: 20px">';
        while ($row = mysqli_fetch_array($result)) {

          echo '<a href="newsPost.php?id=' . $row['id'] . '" style="text-decoration:none">';
          echo '<div class="card" style="width: 18rem;">';
          echo '<img src="images/newsImg/' . $row['image_url'] . '" class="card-img-top" style="width:286px; height:180px; alt="..."/>';
          echo '<div class="card-body">';
          echo '<h5 class="card-title" style="font-size: 18px">' . $row['title'] . '</h5>';
          // echo '<p class="card-text" style="font-size: 14px">' . implode(' ', array_slice(explode(' ', $row['content']), 0, 10)) . '...</p>';
          echo '<p class="card-text" style="font-size: 14px">' . substr($row['content'], 0, 65) . '...</p>';
          echo '</div>';
          echo '</div>';
          echo '</a>';

        }
        echo '</div>';
      }

      ?>
      <div class="tab-content" id="myTabContent" style="padding-top: 1%; padding-bottom: 1%;">
        <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
          <?php $result1 = mysqli_query($con, "SELECT * FROM newsfeed WHERE title LIKE '$query' ORDER BY id DESC");
          if (mysqli_num_rows($result1) > 0) {
            echo $searchMsg;
            newsfees($result1);
          } else {
            if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM newsfeed"))) {
              echo '<h2 class="noResult">We could not find anything for " ' . $_GET['query'] . '".</h2>';
            } else {
              echo '<h2 class="noResult">No news yet.</h2>';
            }
          }
          ?>
        </div>
        <div class="tab-pane fade" id="campusNews-tab-pane" role="tabpanel" aria-labelledby="campusNews-tab"
          tabindex="0">
          <?php $result2 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Campus News'");
          if (mysqli_num_rows($result2) > 0) {
            newsfees($result2);
          } else {
            echo '<h2 class="noResult">No news yet.</h2>';
          } ?>
        </div>
        <div class="tab-pane fade" id="events-tab-pane" role="tabpanel" aria-labelledby="events-tab" tabindex="0">
          <?php $result3 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Events'");
          if (mysqli_num_rows($result3) > 0) {
            newsfees($result3);
          } else {
            echo '<h2 class="noResult">No news yet.</h2>';
          } ?>
        </div>
        <div class="tab-pane fade" id="achievements-tab-pane" role="tabpanel" aria-labelledby="achievements-tab"
          tabindex="0">
          <?php $result4 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Achievements'");
          if (mysqli_num_rows($result4) > 0) {
            newsfees($result4);
          } else {
            echo '<h2 class="noResult">No news yet.</h2>';
          } ?>
        </div>
        <div class="tab-pane fade" id="facilities-tab-pane" role="tabpanel" aria-labelledby="facilities-tab"
          tabindex="0">
          <?php $result5 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Facilities'");
          if (mysqli_num_rows($result5) > 0) {
            newsfees($result5);
          } else {
            echo '<h2 class="noResult">No news yet.</h2>';
          } ?>
        </div>
      </div>
    </div>

    <div class="calculator">
      <h2>Carbon Footprint Calculator</h2>
      <label for="kwh">Electricity consumption (kWh)</label>
      <input type="number" id="kwh" class="focus-ring" step="any" placeholder="Enter kilowatt-hours" value="0"
        oninput="calculateCarbon()">
      <p id="errorKwh" style="color: red"></p>
      <label for="petrol">Petrol consumption (L)</label>
      <input type="number" id="petrol" class="focus-ring" step="any" placeholder="Enter litres" value="0"
        oninput="calculateCarbon()">
      <p id="errorPetrol" style="color: red"></p>
      <label for="waste">Household waste generated (kg)</label>
      <input type="number" id="waste" class="focus-ring" step="any" placeholder="Enter kilograms" value="0"
        oninput="calculateCarbon()">
      <p id="errorWaste" style="color: red"></p>
      <h6>Estimated Carbon Footprint</h6>
      <div>
        <p class="calculatorResult"><span id="result">0.00 KG of CO2</span>&nbsp<img src="images/carbon-footprint.png"
            class="swing" width="25" height="25"></p>
      </div><br>
      <h6>Equivalent Number of Trees <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor"
          class="bi bi-info-circle" viewBox="0 0 20 20" data-bs-toggle="tooltip" data-bs-placement="right"
          data-bs-custom-class="custom-tooltip"
          data-bs-title="1 mature tree (> 5 years) can absorb on average 40kg of CO2 a year.">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
          <path
            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
        </svg></h6>
      <div>
        <p class="calculatorResult"><span id="tree">0 Trees</span>&nbsp<img src="images/tree.png" class="swing"
            width="25" height="25"></p>
        <div>
        </div>
      </div>

      <script>
        function calculateCarbon() {
          var kwh = parseFloat(document.getElementById("kwh").value);
          var petrol = parseFloat(document.getElementById("petrol").value);
          var waste = parseFloat(document.getElementById("waste").value);

          if (isNaN(kwh)) {
            document.getElementById("errorKwh").textContent = "Please enter a valid value for electricity consumption.";
            document.getElementById("kwh").style.borderColor = "red";
          } else {
            document.getElementById("errorKwh").textContent = "";
            document.getElementById("kwh").style.borderColor = "white";
          }

          if (isNaN(petrol)) {
            document.getElementById("errorPetrol").textContent = "Please enter a valid value for petrol consumption.";
            document.getElementById("petrol").style.borderColor = "red";
          } else {
            document.getElementById("errorPetrol").textContent = "";
            document.getElementById("petrol").style.borderColor = "white";
          }

          if (isNaN(waste)) {
            document.getElementById("errorWaste").textContent = "Please enter a valid value for household waste generated .";
            document.getElementById("waste").style.borderColor = "red";
          } else {
            document.getElementById("errorWaste").textContent = "";
            document.getElementById("waste").style.borderColor = "white";
          }

          var carbonEmission;
          carbonEmission = (kwh * 0.78) + (petrol * 2.3228) + (waste * 0.52);

          if (isNaN(carbonEmission)) {
            carbonEmission = 0;
          }

          document.getElementById("result").textContent = carbonEmission.toFixed(2) + " KG of CO2";
          document.getElementById("tree").textContent = (carbonEmission / 40).toFixed(0) + " Trees";
        }
      </script>

      <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
      </script>

</body>

</html>