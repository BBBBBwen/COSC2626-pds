<?php
include("serverV2.php");
$data = getTaskDetails($_GET['data'], $_SESSION['id'], $db);
?>

<!DOCTYPE html>
<html>

<?php include_once("content/head.php"); ?>

<body>
    
    <?php include_once("content/header.php"); ?>

    <div class="container">
        <h1>Parcel ID : <?php echo $_GET["data"]; ?></h1>
        <span class="success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></span>
        <div class="row">
            <div class="col-md-6">
                <label>Customer Name</label>
                <input type="text" value="<?php echo $data['firstName'].' '.$data['lastName'] ?>" class="input_box form-control" disabled>
                <label>Customer Address</label>
                <input type="text" value="<?php echo $data['address'] ?>" class="input_box form-control" disabled>
                <label>Customer Phone Number</label>
                <input type="text" value="<?php echo $data['contactNo'] ?>" class="input_box form-control" disabled>
            </div>

            <div class="col-md-6">
                <label>Receiver Name</label>
                <input type="text" value="<?php echo $data['receiverName'] ?>" class="input_box form-control" disabled>
                <label>Receiver Address</label>
                <input type="text" value="<?php echo $data['receiverAddress'] ?>" class="input_box form-control" disabled>
                <label>Receiver Phone Number</label>
                <input type="text" value="<?php echo $data['receiverPhone'] ?>" class="input_box form-control" disabled>
            
            </div>
        </div>
        <div class="row justify-content-md-center">
            <form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" value="<?php echo $_GET['data'] ?>" name="parcelID">
                <input type="hidden" value="<?php echo $data['address'] ?>" name="customerAdd">
                <input type="hidden" value="<?php echo $data['receiverAddress'] ?>" name="receiverAdd">
                <button type="submit" name="picked" class="btn btn-primary" <?php echo $data['parcelStatus']==2 || $data['parcelStatus']==3? 'disabled' : ''  ?>>Picked Up</button>
                <button type="submit" name="delivered" class="btn btn-warning" <?php echo $data['parcelStatus']==3 ? 'disabled' : '' ?>>Delivered</button>
                <a class="btn btn-info" href="taskRemark.php?data=<?php echo $_GET['data'] ?>">Remark</a>
            </form>
        </div>
    </div>

    <?php include_once("content/foot.php"); ?>
</body>
</html>
