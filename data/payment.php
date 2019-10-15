<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<? include_once("content/head.php"); ?>

<body>
    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-6">
            <h1>Payment for <?php echo $_POST['invoiceID'] ?></h1>

            <form action="payment.php" method="POST">
                <?php include('error.php'); ?>                
                <label>Card Number</label>
                <input type="text" name="cardnum" class="input_box form-control">
                <label>Name On Card</label>
                <input type="text" name="cardname" class="input_box form-control">
                <label>Expiry Date</label>
                <input type="text" name="cardexp" class="input_box form-control" placeholder="MM/YY">
                <label>CVV</label>
                <input type="text" name="cardcvv" class="input_box form-control">

                <input type="hidden" name="invoiceID" value="<?php echo $_POST['invoiceID'] ?>">
                <button type="submit" name="payment" class="btn btn-danger">Pay Now</button>
                <button type="button" class="btn btn-primary" onclick="history.back();">Back</button>
            </form>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
