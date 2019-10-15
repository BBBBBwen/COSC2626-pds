<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-12">
            <h1>Invoices</h1>

            <table border='1'>
                <tr>
                    <th>Invoice Number</th>
                    <th>Parcel ID</th>
                    <th>Total</th>
                    <th>Settle</th>
                </tr>
                <?php getInvoices($_SESSION['id'], $db); ?>
            </table>
        </div>
    </div>
    
    <?php include_once("content/foot.php"); ?>
</body>
</html>
