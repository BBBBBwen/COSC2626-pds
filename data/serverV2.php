<?php
session_start();

$errors = array();
$identity = $_SERVER['QUERY_STRING'];

require 'connectDB.php';

if(isset($_POST['login'])) {
    if (empty($_POST['email'])) { array_push($errors, "empty email"); }
    if (empty($_POST['password'])) { array_push($errors, "empty password"); }

    if (count($errors) == 0) {

        $query = "SELECT * FROM users WHERE email=:email";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            if(isset($_SESSION['id'])) {
                unset($_SESSION['id']);
            }

            $_SESSION['id'] = $user['id'];

            if($user['is_customer'] > 0) {

                $_SESSION['user'] = $user['is_customer'];

                $query = "SELECT * FROM customers WHERE id=:id";
                $stmt = $db->prepare($query);
                $stmt->bindValue(':id', $user['id']);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['email'] = $_POST['email'];

                header("Location: customerV2.php");
            } else if($user['is_driver'] > 0) {
                $_SESSION['driver'] = $user['is_driver'];

                $query = "SELECT * FROM drivers WHERE id=:id";
                $stmt = $db->prepare($query);
                $stmt->bindValue(':id', $user['id']);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['email'] = $_POST['email'];

                driverLogon($user['id'], $db);
                header("Location: driverV2.php");
            } else if($user['is_manager'] > 0) {
                $_SESSION['manager'] = $user['is_manager'];

                header("Location: manager.php");
            }
        } else {
            array_push($errors, "Wrong login information");
        }
    }
}

if(isset($_POST['register'])) {
    if (empty($_POST['email'])) {
        array_push($errors, "Please enter your email!");
    }

    if (empty($_POST['password'])) {
        array_push($errors, "Password cannot be empty!");
    }

    if ($_POST['password'] != $_POST['passwordConfirm']) {
        array_push($errors, "Password mismatch!");
    }

    if (empty($_POST['firstName'])) {
        array_push($errors, "Please enter your First name!");
    }

    if (empty($_POST['lastName'])) {
        array_push($errors, "Please enter your Last name!");
    }

    if (empty($_POST['contactNum'])) {
        array_push($errors, "Please enter your Phone Number!");
    }
    $sql = "SELECT COUNT(email) AS num FROM users WHERE email=:email";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['num'] > 0) {
        array_push($errors, "email already exists");
    }

    if(count($errors) == 0) {
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (email, password)
  			      VALUES(:email, :password)";
  	    $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':password', $hash);
        $result = $stmt->execute();
        $lastId = $db->lastInsertId();

        $sql = "INSERT INTO customers (id, firstName, lastName, address, contactNo)
                    VALUES(:id, :firstName, :lastName, :address, :contactNo)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $lastId);
        $stmt->bindValue(':firstName', $_POST['firstName']);
        $stmt->bindValue(':lastName', $_POST['lastName']);
        $stmt->bindValue(':address', $_POST['address']);
        $stmt->bindValue(':contactNo', $_POST['contactNum']);
        $result = $stmt->execute();

        if($result) {
            header('location: /');
        } else {
            array_push($errors, "fail to register");
        }
    }
}

if(isset($_POST['save'])) {
   if(empty($_POST['firstName'])) {
       array_push($errors, "First Name cannot be empty!");
   }

   if(empty($_POST['lastName'])) {
       array_push($errors, "Last Name cannot be empty!");
   }

   if(empty($_POST['address'])) {
       array_push($errors, "Address cannot be empty!");
   }

   if(count($errors) == 0) {
       $sql = "UPDATE customers SET firstName=?, lastName=?, address=? WHERE id=?";
       $stmt =$db->prepare($sql);
       $result = $stmt->execute([$_POST['firstName'], $_POST['lastName'], $_POST['address'], $_SESSION['id']]);

       if($result) {
           $_SESSION['firstName'] = $_POST['firstName'];
           $_SESSION['lastName'] = $_POST['lastName'];
           $_SESSION['address'] = $_POST['address'];

           header("Refresh:0");
       } else {
           array_push($errors, "Update failed!");
       }
   }
}

if(isset($_POST['booking'])) {
    if(empty($_POST['receiverName'])) {
        array_push($errors, "Receiver name cannot be empty!");
    }

    if(empty($_POST['receiverAddress'])) {
        array_push($errors, "Receiver address cannot be empty!");
    }

    if(empty($_POST['receiverPhone'])) {
        array_push($errors, "Receiver phone cannot be empty!");
    }

    if(count($errors) == 0) {
        $sql = "INSERT INTO bookings (parcelID, customerID, parcelName, receiverName, receiverAddress, receiverPhone) VALUES(?,?,?,?,?,?)";

        $stmt = $db->prepare($sql);
        $parcelID = date("Ymdhis").'-'.$_SESSION['id'];
        $result = $stmt->execute([$parcelID, $_SESSION['id'], $_POST['parcelName'], $_POST['receiverName'], $_POST['receiverAddress'], $_POST['receiverPhone']]);

        if($result) {
            header("Location: allBooking.php?type=current");
        } else {
            array_push($errors, "Fail to book job");
        }
    }
}

if(isset($_POST['payment'])) {
    if(empty($_POST['cardnum'])) {
        array_push($errors, "Card Number cannot be empty!");
    }

    if(empty($_POST['cardname'])) {
        array_push($errors, "Card Name cannot be empty!");
    }

    if(empty($_POST['cardexp'])) {
        array_push($errors, "Card Expiry cannot be empty!");
    }

    if(empty($_POST['cardcvv'])) {
        array_push($errors, "Card CVV cannot be empty!");
    }

    if(count($errors) == 0) {
        madePayment($db, $_POST['cardnum'], $_POST['cardname'], $_POST['cardexp'], $_POST['cardcvv'], $_POST['invoiceID']);
    }
}

if(isset($_POST['picked'])) {
    updateTask("picked", $_POST['parcelID'], $_SESSION['id'], $db);
}

if(isset($_POST['delivered'])) {
    updateTask('delivered', $_POST['parcelID'], $_SESSION['id'], $db);
}

if(isset($_POST['remark'])) {
    setRemark($_POST['parcelID'], $_POST['remarkText'], $_SESSION['id'], $db);
}

if(isset($_POST['report'])) {
    driverReport($_POST['reportText'], $_SESSION['id'], $db);
}

/* For customer booking list */
if($_GET['type'] == "current") {
    $status = "< 3";
} else {
    $status = "= 3";
}

/* For header path */
if($_SESSION['user']) {
    $path = 'customerV2.php';
} else if($_SESSION['driver']) {
    $path = 'driverV2.php';
} else {
    $path = '/';
}

/* Get all the booking for customer, current / history */
function getAllBooking($status, $db) {
    $sql = "SELECT a.parcelID, a.parcelName, a.receiverName, a.receiverAddress, a.receiverPhone, b.status, a.timestamp FROM bookings a JOIN parcel_status b ON a.parcelStatus = b.id WHERE a.customerID = ? AND a.parcelStatus ".$status;
    $stmt = $db->prepare($sql);
    $stmt->execute([$_SESSION['id']]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>";
        echo "<a href='bookingDetails.php?data=".$row['parcelID']."'>".$row['parcelID']."</a>";
        echo "</td>";
        echo "<td>". $row['parcelName'] ."</td>";
        echo "<td>". $row['receiverName'] ."</td>";
        echo "<td>". $row['receiverAddress'] ."</td>";
        echo "<td>". $row['receiverPhone'] ."</td>";
        echo "<td>". $row['status'] ."</td>";
        echo "<td>". $row['timestamp'] ."</td>";
        echo "</tr>";
    }
}

/* Get specific booking details */
function getBookingDetails($parcelID, $db) {
    $sql = "SELECT info, location, timestamp FROM parcel_location WHERE parcelID = ? order by timestamp ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute([$parcelID]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>". $row['info'] ."</td>";
        echo "<td>". $row['location'] ."</td>";
        echo "<td>". $row['timestamp'] ."</td>";
        echo "</tr>";
    }
}

function getCoordinate($parcelID, $db) {
    $sql = "SELECT * FROM tasks WHERE parcelID=?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$parcelID]);
    $driverID = $stmt->fetch(PDO::FETCH_ASSOC);
    $driverID = $driverID['driverID'];

    $sql = "SELECT * FROM drivers WHERE id=?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$driverID]);
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);
    $address = $driver['lastKnowPosition'];
    $geo = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&key=AIzaSyAtgbDVO3hASMchsL0gyj4b-Itpg5_u-_o");
    $geo = json_decode($geo, true);
    return $geo;
}

/* Display all message in inbox */
function getMessage($user, $db) {
    $sql = "SELECT parcelID, timestamp FROM inbox WHERE customerID = ? order by timestamp DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>";
        echo "<a href='message.php?data=".$row['parcelID']."'>".$row['parcelID']."</a>";
        echo "</td>";
        echo "<td>". $row['timestamp'] ."</td>";
        echo "</tr>";
    }
}

/* Get specific message with remark */
function getMessageRemark($parcelID, $user, $db) {
    $sql = "SELECT remark FROM inbox WHERE customerID = ? AND parcelID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user, $parcelID]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $data['remark'];
}

/* Get all invoice */
function getInvoices($user, $db) {
    $sql = "SELECT invoiceID, parcelID, settle, (costAmount + gstAmount + deliveryAmount) AS total FROM invoices WHERE customerID = ? ORDER BY timestamp DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>";
        echo "<a href='invoice.php?data=".$row['invoiceID']."'>".$row['invoiceID']."</a>";
        echo "</td>";
        echo "<td>". $row['parcelID'] ."</td>";
        echo "<td>$". $row['total'] ."</td>";
        echo "<td>". ($row['settle'] ? "Paid" : "Unpaid") ."</td>";
        echo "</tr>";
    }
}

/* Get invoice details */
function getInvoiceDetails($invoiceID, $user, $db) {
    $sql = "SELECT costAmount, gstAmount, deliveryAmount, settle FROM invoices WHERE customerID = ? AND invoiceID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user, $invoiceID]);

    return $data = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* Insert into payment table and update invoice */
function madePayment($db, $cardnum, $cardname, $cardexp, $cardcvv, $invoiceid) {
    $sql = "INSERT INTO payment (invoiceID, cardName, cardNum, cardExp, cardCVV) VALUES(?,?,?,?,?)";

    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$invoiceid, $cardname, $cardnum, $cardexp, $cardcvv]);

    if($result) {

        $sql = "UPDATE invoices SET settle=1 WHERE invoiceID=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$invoiceid]);

        $_SESSION['message'] = "Payment Success for Invoice : ". $invoiceid;
        header("Location: customerV2.php");
    } else {
        array_push($errors, "Failed to made payment!");
    }
}

/* Get all assigned task for driver */
function getTasks($driver, $db) {
    $sql = "SELECT t.parcelID, b.receiverName, b.receiverAddress, c.address, c.firstName, c.lastName, ps.status FROM tasks t JOIN bookings b ON t.parcelID = b.parcelID JOIN customers c ON t.customerID = c.id JOIN parcel_status ps ON b.parcelStatus = ps.id WHERE t.driverID = ? AND b.parcelStatus < 3 ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$driver]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>";
        echo "<a href='task.php?data=".$row['parcelID']."'>".$row['parcelID']."</a>";
        echo "</td>";
        echo "<td>". $row['firstName'] ." ". $row['lastName'] ."</td>";
        echo "<td>". $row['address'] ."</td>";
        echo "<td>". $row['receiverName'] ."</td>";
        echo "<td>". $row['receiverAddress'] ."</td>";
        echo "<td>". $row['status'] ."</td>";
        echo "</tr>";
    }
}

/* Get assigned task details for driver */
function getTaskDetails($parcelID, $driver, $db) {
   $sql = "SELECT b.receiverName, b.receiverAddress, b.receiverPhone, b.parcelStatus, c.address, c.firstName, c.lastName, c.contactNo FROM tasks t JOIN bookings b ON t.parcelID = b.parcelID JOIN customers c ON t.customerID = c.id WHERE t.driverID = ? AND t.parcelID = ?";
   $stmt = $db->prepare($sql);
   $stmt->execute([$driver, $parcelID]);

   return $data = $stmt->fetch(PDO::FETCH_ASSOC);
}


function assginTask($driverID, $db) {
    $sql = "SELECT * FROM tasks t JOIN bookings b ON t.parcelID = b.parcelID JOIN customers c ON t.customerID = c.id JOIN parcel_status ps ON b.parcelStatus = ps.id WHERE t.driverID = ? AND b.parcelStatus < 3";
    $stmt = $db->prepare($sql);
    $stmt->execute([$driverID]);

    if($stmt->rowCount() < 1 && isset($_SESSION['id'])) {
        $sql = "SELECT * FROM drivers WHERE id=:driverID;";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':driverID', $driverID);
        $stmt->execute();
        $driver = $stmt->fetch(PDO::FETCH_ASSOC);
        $address = $driver['lastKnowPosition'];

        $sql = "SELECT b.parcelID, c.id, c.address FROM customers c JOIN bookings b ON b.customerID = c.id WHERE b.parcelStatus=1;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $selectID;
        $selectParcelID;
        $minDis = 1000000000;

        while($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $temp = getDistace($address, $data['address']);
            if($temp < $minDis) {
                $selectID = $data['id'];
                $selectParcelID = $data['parcelID'];
                $minDis = $temp;
            }
        }

        $sql = "INSERT INTO tasks (parcelID, customerID, driverID) VALUES(:parcelID, :customerID, :driverID)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':parcelID', $selectParcelID);
        $stmt->bindValue(':customerID', $selectID);
        $stmt->bindValue(':driverID', $driverID);
        $result = $stmt->execute();
    }
}

function getDistace($from, $to) {
    $distanceData = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?&origins=".urlencode($from)."&destinations=".urlencode($to)."&key=AIzaSyAtgbDVO3hASMchsL0gyj4b-Itpg5_u-_o");
    $data = json_decode($distanceData);
    $distance = floor($data->rows[0]->elements[0]->distance->value / 1000);
    return $distance;
}

function calculatePrice($parcelID, $timeStamp, $db) {
    $sql = "SELECT * FROM tasks WHERE parcelID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$parcelID]);
    $ids = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$ids['customerID']]);
    $customerAddress = $stmt->fetch(PDO::FETCH_ASSOC);
    $customerID = $customerAddress['id'];
    $customerAddress = $customerAddress['address'];

    $sql = "SELECT * FROM bookings WHERE parcelID = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$parcelID]);
    $receiverAddress = $stmt->fetch(PDO::FETCH_ASSOC);
    $receiverAddress = $receiverAddress['receiverAddress'];

    $price = getDistace($customerAddress, $receiverAddress);
    $gst = $price * 0.1;
    $deliverPrice = $price * 0.2;

    $sql = "INSERT INTO invoices (parcelID, invoiceID, customerID, costAmount, gstAmount, deliveryAmount) VALUES(?,?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$parcelID, $timeStamp, $customerID, $price, $gst, $deliverPrice]);
}

/* Update the task status (Picked Up and Delivered) */
function updateTask($type, $parcelID, $driver, $db) {
    $sql = "SELECT * FROM bookings WHERE parcelID = ?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$parcelID]);
    $stat = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM drivers WHERE id = ?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$driver]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $address = $result['lastKnowPosition'];

    if($type == "picked" && $stat['parcelStatus'] == 1) {
        $sql = "UPDATE bookings SET parcelStatus = 2 WHERE parcelID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$parcelID]);

        $sql = "UPDATE tasks SET pickedDate = now() WHERE parcelID = ? AND driverID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$parcelID, $driver]);

        $sql = "INSERT INTO parcel_location (parcelID, info, location) VALUES(?,?,?)";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$parcelID, "Picked Up", $address]);

        $_SESSION['message'] = "Parcel Successful Picked Up";
    }

    if($type == "delivered" && $stat['parcelStatus'] == 2) {
        $sql = "UPDATE bookings SET parcelStatus = 3 WHERE parcelID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$parcelID]);

        $sql = "UPDATE tasks SET deliveredDate = now() WHERE parcelID = ? AND driverID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$parcelID, $driver]);

        $sql = "INSERT INTO parcel_location (parcelID, info, location) VALUES(?,?,?)";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$parcelID, "Delivered", $address]);
        calculatePrice($parcelID, $parcelID, $db);
        $_SESSION['message'] = "Parcel Successful Delivered";
    }
}

/** Add Remark to the task **/
function setRemark($parcelID, $remark, $driver, $db) {
    if(!empty($remark)) {
        $sql = "SELECT customerID FROM tasks WHERE parcelID = ? AND driverID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$parcelID, $driver]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "INSERT INTO inbox (parcelID, remark, customerID) VALUES(?,?,?)";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$parcelID, $remark, $data['customerID']]);

        if($result) {
            $_SESSION['message'] = "Remark Successful Added";
            header("Location: task.php?data=".$parcelID);
        } else {
            $_SESSION['failedMsg'] = "Failed To Add Remark!";
        }
    } else {
        $_SESSION['failedMsg'] = "Cannot submit empty remark!";
    }
}

/* Driver report */
function driverReport($text, $driver, $db) {
    if(!empty($text)) {
        $sql = "INSERT INTO report (driverID, report) VALUES(?,?)";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([$driver, $text]);

        if($result) {
            $_SESSION['message'] = "Report submitted.";
            header("Location: driverV2.php");
        } else {
            $_SESSION['failedMsg'] = "Failed to report!";
        }
    } else {
        $_SESSION['failedMsg'] = "Cannot submit empty report!";
    }
}

function driverLogon($id, $db) {
    $sql = "UPDATE drivers SET status='online' WHERE id=?";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$id]);
}

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .');';
    echo '</script>';
}
?>
