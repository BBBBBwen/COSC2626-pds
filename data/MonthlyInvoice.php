<?php
require 'connectDB.php';
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;

$sql = "SELECT * FROM customers;";
$stmt = $db->prepare($sql);
$stmt->execute();
$customers = $stmt->fetch(PDO::FETCH_ASSOC);
foreach($customers as $customer) {
    $to = "bowen0225@gmail.com";

    $message = "
    <html>
    <head>
    <title>Monthly Invoice for ".$customer['firstName'] . " " . $customer['lastName'] ."</title>
    </head>
    <body>
    <table>
    <tr>
        <th>parcelID</th>
        <th>invoiceID</th>
        <th>Parcel fee</th>
        <th>Gst 10%</th>
        <th>Delivery fee</th>
        <th>Total Amount</th>
    </tr>";

    $customerID = $customer['id'];
    $sql = "SELECT * FROM invoices WHERE customerID = ?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$customerID]);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $message .= "<tr>";
        $message .= "<td>". $row['parcelID'] ."</td>";
        $message .= "<td>". $row['invoiceID'] ."</td>";
        $message .= "<td>". $row['costAmount'] ."</td>";
        $message .= "<td>". $row['gstAmount'] ."</td>";
        $message .= "<td>". $row['deliveryAmount'] ."</td>";
        $total = $row['costAmount'] + $row['gstAmount'] + $row['deliveryAmount'];
        $message .= "<td>". $total ."</td>";
        $message .= "</tr>";
    }
    $message .= "</table></body></html>";

    $headers .= "From: ParcelDeliverSystem\r\n";

    try {
        $mail = new Message();
        $mail->setSender('bowen0225@gmail.com');
        $mail->addTo("527441877@qq.com");
        $mail->setSubject("Monthly Invoice");
        $mail->setTextBody($message);
        $mail->send();
        echo 'Mail Sent';
    } catch (InvalidArgumentException $e) {
        echo 'There was an error';
    }

    $file = fopen('gs://cosc2626-bucket/MonthlyInvoices.txt','w');
    fwrite($file,$message);
    fclose($file);
    echo $message;
}
?>
