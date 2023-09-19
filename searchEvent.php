<?php
include("connectdb.php"); 
session_start();

if(isset($_POST['search_val']) && $_POST['search_val'] !== '') {
    $searchQuery = mysqli_real_escape_string($con, $_POST['search_val']);
    
    
    $sql = "SELECT * FROM events WHERE eventName LIKE '%$searchQuery%'";
    $result = mysqli_query($con, $sql);
    echo' <div id="filteredEvents" class="ag-format-container">
                  <div class="ag-courses_box">';

    if (mysqli_num_rows($result) > 0) {
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

            
            echo '<div class="ag-courses_item">';
            echo '<a href="#" class="ag-courses-item_link" style="text-decoration:none" type="button"
                    data-toggle="modal" data-target="#exampleModal'.$row['eventID'].'">';
                    echo '<div class="ag-courses-item_bg"></div>';

                    echo '<div class="ag-courses-item_title">';
                    echo '<center style="background-color:#b1e8c9;border-top-left-radius: 30px; border-top-right-radius: 30px;">';
                    echo '<img src="' . $row['eventImage'] . '" alt="" width="100%" style="border-top-left-radius: 30px; border-top-right-radius: 30px; height: 100px; object-fit:contain;">';
                    echo '</center>';
                    echo $row['eventName'];
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Start from | ';
                    echo '<span class="ag-courses-item_date">';
                    $startDate = strtotime($row['startDate']);
                    $formattedDate = date('d/m/Y, l', $startDate);
                    echo $formattedDate;
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Duration | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['duration'];
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Category | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['category'];
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Organizer | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['organizer'];
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Location | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['locationName'];
                    echo '</span>';
                    echo '</div>';
                    

            echo '</a></div>';
                   
        }
        echo '</div></div>';
    } else {
        echo "Sorry, couldn't find anything for \" <strong>" .$_POST['search_val']. " </strong>\".";
    }
} else if ($_POST['search_val'] == '') {
    
    $sql = "SELECT * FROM events";
    $result = mysqli_query($con, $sql);
    echo' <div id="filteredEvents" class="ag-format-container">
    <div class="ag-courses_box">';
    
    if ($result) {
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

            
            echo '<div class="ag-courses_item">';
            echo '<a href="#" class="ag-courses-item_link" style="text-decoration:none" type="button"
                    data-toggle="modal" data-target="#exampleModal'.$row['eventID'].'">';
                    echo '<div class="ag-courses-item_bg"></div>';

                    echo '<div class="ag-courses-item_title">';
                    echo '<center style="background-color:#b1e8c9;border-top-left-radius: 30px; border-top-right-radius: 30px;">';
                    echo '<img src="' . $row['eventImage'] . '" alt="" width="100%" style="border-top-left-radius: 30px; border-top-right-radius: 30px; height: 100px; object-fit:contain;">';
                    echo '</center>';
                    echo $row['eventName'];
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Start from | ';
                    echo '<span class="ag-courses-item_date">';
                    $startDate = strtotime($row['startDate']);
                    $formattedDate = date('d/m/Y, l', $startDate);
                    echo $formattedDate;
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Duration | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['duration'];
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Category | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['category'];
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Organizer | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['organizer'];
                    echo '</span>';
                    echo '</div>';
                    
                    echo '<div class="ag-courses-item_date-box">';
                    echo 'Location | ';
                    echo '<span class="ag-courses-item_date">';
                    echo $row['locationName'];
                    echo '</span>';
                    echo '</div>';
                    

            echo '</a></div>';
                   
        }
        echo '</div></div>';
    } else {
        echo "Error: " . mysqli_error($con);
    }
}else {
    echo "Error: " . mysqli_error($con);
}
?>
