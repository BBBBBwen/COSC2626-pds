<?php
session_start();
require 'connectDB.php';
$sql = "UPDATE drivers SET status='offline' WHERE id=?";
$stmt = $db->prepare($sql);
$result = $stmt->execute([$_SESSION['id']]);
session_destroy();
header("Location: /");
?>
