<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendancejframebd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
  exit;
}

date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');

$sql = "SELECT subject_name, start_time, end_time FROM subjects
        WHERE '$current_time' BETWEEN start_time AND end_time
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode($row);  // ✅ Send proper JSON
} else {
  echo json_encode([
    "subject_name" => "No Subject",
    "start_time" => "",
    "end_time" => ""
  ]);
}

$conn->close();
?>
