<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>
<body>
    
    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-8">
            <h1> Welcome <?php echo $_SESSION['firstName'].' '.$_SESSION['lastName']?> </h1>

            <?php 
                if(isset($_SESSION['message'])) {
                    echo "<div class='success'>";
                    echo $_SESSION['message'];
                    echo "</div>";
                    unset($_SESSION['message']); 
                }
            ?>
            <a class="btn btn-primary" href="booking.php">Booking</a>
            <a class="btn btn-danger" href="allBooking.php?type=current">Current Booking</a>
            <a class="btn btn-info" href="allBooking.php?type=history">Booking History</a>
            <a class="btn btn-warning" href="allInvoices.php">Invoices</a>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
