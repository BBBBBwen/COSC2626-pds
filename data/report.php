<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="col-md-8">
            <h1> Report </h1>
            <span class="alert"><?php echo $_SESSION['failedMsg']; unset($_SESSION['failedMsg']); ?></span>
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                <textarea cols=80 rows=5 name="reportText"></textarea>
                <button class="btn btn-primary" type="submit" name="report">Submit</button>
            </form>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
