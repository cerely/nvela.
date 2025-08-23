<?php
$host = "attendance.cb6y0yii0m0z.ap-south-1.rds.amazonaws.com:3306";
$username = "admin";
$password = "amazonaws";
$database = "attendancejframebd";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
