<?php 
include("serverV2.php"); 
$data = getInvoiceDetails($_GET['data'], $_SESSION['id'], $db);
?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-6">
            <h1>Invoice : <?php echo $_GET['data'] ?></h1>
            <label>Parcel fee</label>
            <input type="text" value="<?php echo $data['costAmount'] ?>" class="input_box form-control" disabled>
            <label>Gst 10%</label>
            <input type="text" value="<?php echo $data['gstAmount'] ?>" class="input_box form-control" disabled>
            <label>Delivery fee</label>
            <input type="text" value="<?php echo $data['deliveryAmount'] ?>" class="input_box form-control" disabled>
            <label>Total Amount</label>
            <input type="text" value="<?php echo $data['costAmount'] + $data['gstAmount'] + $data['deliveryAmount'] ?>" class="input_box form-control" disabled>

            <form method="POST" action="payment.php">
                <input type="hidden" value="<?php echo $_GET['data'] ?>" name="invoiceID">
                <button type="submit" name="pay" class="btn btn-danger" <?php echo $data['settle'] ? 'disabled' : '' ?>>Pay</button>
                <button type="button" class="btn btn-primary" onclick="history.back();">Back</button>
            </form>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
