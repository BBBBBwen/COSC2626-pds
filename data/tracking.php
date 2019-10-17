<?php
session_start();
require 'connectDB.php';
function tracking($db) {
    if(isset($_SESSION['id'])) {
        $geocodeFromLatLong = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$_COOKIE['co']."&sensor=false&key=AIzaSyAtgbDVO3hASMchsL0gyj4b-Itpg5_u-_o");
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        $address = ($status=="OK")?$output->results[1]->formatted_address:'';

        $sql = "UPDATE drivers SET lastKnowPosition = :lastKnowPosition WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':lastKnowPosition', $address);
        $stmt->bindValue(':id', $_SESSION['id']);
        $stmt->execute();

     $sql = "SELECT * FROM drivers WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$driverID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $address = $result['lastKnowPosition'];

        $sql = "SELECT * FROM tasks t JOIN bookings b ON t.parcelID = b.parcelID JOIN customers c ON t.customerID = c.id JOIN parcel_status ps ON b.parcelStatus = ps.id WHERE t.driverID = ? AND b.parcelStatus = 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$driverID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0) {
            $sql = "INSERT INTO parcel_location (parcelID, info, location) VALUES(?,?,?)";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([$result['parcelID'], $result['parcelStatus'], $address]);
        }
    } else {
        echo "Tracking not available";
    }
}
?>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position) {
    document.cookie = "co=" + position.coords.latitude + "," + position.coords.longitude;
}
getLocation();
</script>
