<?php session_start(); 
$currentPage = "home"; 
if(isset($_SESSION['userID'])){
    $userID = $_SESSION['userID'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .calculator {
      background: #f4f4f4;
      padding: 20px;
    }

    .calculatorResult {
      display: inline-flex;
      align-items: center;
      font-size: 15px;
      line-height: 24px;
      color: #3cce88;
      background-color: #eee;
      border: 1px solid;
      border-color: #3cce88;
      padding: 4px 6px;
      margin: 0 0 4px;
      width: 100%;
      height: 48px;
      text-indent: 10px;
      font-weight: 700;
      border-radius: 2px;
      outline: 0;
      box-shadow: 0 0 0 transparent;
    }

    input[type="number"] {
      font-size: 15px;
      line-height: 24px;
      color: #333;
      background-color: #FFFFFF;
      border: 1px solid;
      border-color: white;
      padding: 4px 6px;
      margin: 0 0 4px;
      width: 100%;
      min-height: 48px;
      text-indent: 10px;
      font-weight: 400;
      border-radius: 2px;
      outline: 0;
      box-shadow: 0 0 0 transparent;
    }
  </style>
</head>

<body>
    <?php include("header.php"); ?>
  <div class="d-flex flex-nowrap" style="margin: 2%">
    <div class="overflow-auto" style="height: 500px; width: 3800px; margin: 4%; ">
    <div style="display: inline-flex; width:100%; justify-content: space-between">
      <div style="display: inline-flex">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane"
              type="submit" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="campusNews-tab" data-bs-toggle="tab" data-bs-target="#campusNews-tab-pane"
              type="button" role="tab" aria-controls="campusNews-tab-pane" aria-selected="false">Campus News</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events-tab-pane"
              type="button" role="tab" aria-controls="events-tab-pane" aria-selected="false">Events</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="achievements-tab" data-bs-toggle="tab" data-bs-target="#achievements-tab-pane"
              type="button" role="tab" aria-controls="achievements-tab-pane" aria-selected="false">Achievements</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="facilities-tab" data-bs-toggle="tab" data-bs-target="#facilities-tab-pane"
              type="button" role="tab" aria-controls="facilities-tab-pane" aria-selected="false">Facilities</button>
          </li>
        </ul>
      </div>
      <div style="display: inline-flex; margin-right: 1.5%">
        <form class="d-flex" action="userSearch.php" method="GET">
          <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
  </div>

      <?php
      include("connectdb.php");

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
          <?php $result1 = mysqli_query($con, "SELECT * FROM newsfeed");
          newsfees($result1); ?>
        </div>
        <div class="tab-pane fade" id="campusNews-tab-pane" role="tabpanel" aria-labelledby="campusNews-tab"
          tabindex="0"><?php $result2 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Campus News'");
          newsfees($result2); ?>
        </div>
        <div class="tab-pane fade" id="events-tab-pane" role="tabpanel" aria-labelledby="events-tab" tabindex="0">
          <?php $result3 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Events'");
          newsfees($result3); ?>
        </div>
        <div class="tab-pane fade" id="achievements-tab-pane" role="tabpanel" aria-labelledby="achievements-tab"
          tabindex="0"><?php $result4 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Achievements'");
          newsfees($result4); ?>
        </div>
        <div class="tab-pane fade" id="facilities-tab-pane" role="tabpanel" aria-labelledby="facilities-tab"
          tabindex="0"><?php $result5 = mysqli_query($con, "SELECT * FROM newsfeed WHERE category = 'Facilities'");
          newsfees($result5); ?>
        </div>
      </div>
    </div>

    <div class="calculator" style="width: 100%; margin: 2%; margin-left: 0">
      <h2>Carbon Footprint Calculator</h2>
      <label for="kwh">Electricity consumption (kWh):</label>
      <input type="number" id="kwh" step="any" placeholder="Enter kilowatt-hours" value="0" oninput="calculateCarbon()">
      <p id="errorKwh" style="color: red"></p>
      <label for="petrol">Petrol consumption (L):</label>
      <input type="number" id="petrol" step="any" placeholder="Enter litres" value="0" oninput="calculateCarbon()">
      <p id="errorPetrol" style="color: red"></p>
      <label for="waste">Household waste generated (kg):</label>
      <input type="number" id="waste" step="any" placeholder="Enter kilograms" value="0" oninput="calculateCarbon()">
      <p id="errorWaste" style="color: red"></p>
      <h6>Estimated Carbon Footprint :</h6>
      <div>
        <p id="result" class="calculatorResult">0.00 KG of CO2</p>
      </div><br>
      <h6>Equivalent Number of Trees :</h6>
      <div>
        <p id="tree" class="calculatorResult">0 Trees </p>
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

</body>

</html>