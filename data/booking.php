<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>
    
    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <h1>Booking</h1>
            <form method="POST" action="booking.php">
                <?php include('error.php'); ?>
                <label>Parcel Name</label>
                <input class="input_box form-control" type="text" name="parcelName">

                <label>Receiver Name</label>
                <input class="input_box form-control" type="text" name="receiverName">

                <label>Receiver Address</label>
                <input class="input_box form-control" type="text" name="receiverAddress">

                <label>Receiver Phone Number</label>
                <input class="input_box form-control" type="text" name="receiverPhone">

                <button type="submit" name="booking" class="btn btn-danger">Book</button>
                <a class="btn btn-primary" href="<?php echo $path ?>">Back</a>
            </form>
        </div>
    </div>
</body>
</html>
