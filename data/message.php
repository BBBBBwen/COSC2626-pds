<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-8">
            <h1>Message - ParcelID : <?php echo $_GET["data"] ?></h1>
            <textarea cols=100 rows=10 disabled><?php getMessageRemark($_GET["data"], $_SESSION['id'], $db) ?></textarea>
        </div>
        <div class="col-md-8">
            <button type="button" class="btn btn-primary" onclick="history.back();">Back</button>
        </div>
    </div>
</body>
</html>
