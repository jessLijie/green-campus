<?php
include("connectdb.php");

$sql = "SELECT itemName, item_lat, item_lng, itemImage FROM labelled_item";
$result = mysqli_query($con, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
mysqli_close($con);
echo json_encode($data);
?>