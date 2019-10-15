<?php include('serverV2.php') ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>

    <?php include_once("content/header.php"); ?>

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6 col-md-offset-3">
            <h1>Registeration</h1>
                <form method="POST" action="register.php">
                    <?php include("error.php"); ?>

                    <label>Email</label>
                    <input class="input_box form-control" type="email" name="email">
                    <label>Password</label>
                    <input class="input_box form-control" type="password" name="password">
                    <label>Confirm Password</label>
                    <input class="input_box form-control" type="password" name="passwordConfirm">

                    <label>First Name</label>
                    <input class="input_box form-control" type="text" name="firstName">
                    <label>Last Name</label>
                    <input class="input_box form-control" type="text" name="lastName">
                    <label>Address</label>
                    <input class="input_box form-control" type="text" name="address">
                    <label>Contact Number</label>
                    <input class="input_box form-control" type="text" name="contactNum">

                    <button type="submit" name="register" class="btn btn-danger">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>

</html>
