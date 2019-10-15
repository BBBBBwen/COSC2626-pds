<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>
    
    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-12">
            <h1>Current Booking</h1>

            <table border='1'>
                <tr>
                    <th>Parcel ID</th>
                    <th>Parcel Name</th>
                    <th>Receiver Name</th>
                    <th>Receiver Address</th>
                    <th>Receiver Phone Number</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                </tr>
                <?php getAllBooking($status, $db); ?>
            </table>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
