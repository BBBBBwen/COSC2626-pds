<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<? include_once("content/head.php"); ?>

<body>
    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6 col-md-offset-3">
            <h1>Profile</h1>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <?php include('error.php'); ?>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $_SESSION['email']?>" disabled class="input_box form-control">

                    <label>First Name</label>
                    <input type="text" name="firstName" value="<?php echo $_SESSION['firstName']?>" class="input_box form-control">

                    <label>Last Name</label>
                    <input type="text" name="lastName" value="<?php echo $_SESSION['lastName']?>" class="input_box form-control">

                    <label>Address</label>
                    <input type="text" name="address" value="<?php echo $_SESSION['address']?>" class="input_box form-control">

                    <button type="submit" name="save" class="btn btn-danger">Save</button>
                    <a class="btn btn-primary" href="<?php echo $path ?>">Back</a>
                </form>
            </div>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
