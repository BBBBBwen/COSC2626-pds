<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-12">
            <h1>All Task</h1>
            <table border='1'>
                <tr>
                    <th>Parcel ID</th>
                    <th>Customer Name</th>
                    <th>Customer Address</th>
                    <th>Receiver Name</th>
                    <th>Receiver Address</th>
                    <th>Status</th>
                </tr>
                <?php getTasks($_SESSION['id'], $db); ?>
            </table>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
