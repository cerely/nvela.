<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendancejframebd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');

// Query to find subject happening right now
$sql = "SELECT subject_name FROM subjects
        WHERE '$current_time' BETWEEN start_time AND end_time
        LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo $row["subject_name"];
} else {
  echo "No Subject";
}

$conn->close();
?>
