<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>
    
    <div class="container">
        <div class="col-md-12">
            <h1>Inbox</h1>

            <table border='1'>
                <tr>
                    <th>Parcel ID</th>
                    <th>Timestamp</th>
                </tr>
                <?php getMessage($_SESSION["id"], $db); ?>
            </table>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
