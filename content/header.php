    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="<?php echo $path ?>">PBS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                    <?php if(isset($_SESSION['user'])) {
                        echo '<a class="btn btn-outline-warning" href="../data/customerInbox.php">Inbox</a>';
                    } ?>
                    <?php if(isset($_SESSION['id'])) {
                        echo '<a class="btn btn-outline-info" href="../data/profileV2.php">Profile</a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../data/register.php">Register</a>';
                    } ?>
                    </li>
                    <li class="nav-item">
                    <?php if(isset($_SESSION['id'])) {
                        echo '<a class="btn btn-outline-danger" href="../data/logout.php">Logout</a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../data/login.php">Login</a>';
                    } ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
