<?php include("serverV2.php"); ?>
<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>
    
    <?php include_once("content/header.php"); ?>

    <div class="container">

        <div class="row justify-content-md-center">
            <div class="col-md-6 col-md-offset-3">
                <h1>Log in</h1>
                <form method="POST" action="login.php">
                    <?php include('error.php'); ?>

                    <label>Email</label>
                    <input class="input_box form-control" type="email" name="email">
                    <label>Password</label>
                    <input class="input_box form-control" type="password" name="password">
                    
  		            <button type="submit" name="login" class="btn btn-primary">Login</button>
  	                <p>Not yet a member? <a href="register.php">Sign up</a></p>
                </form>
            </div>
        </div>
    </div>

  <?php include_once("content/foot.php"); ?>

</body>
</html>
