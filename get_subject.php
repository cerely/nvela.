<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost"; // or your PC IP if accessed from Pi, e.g. "10.169.34.71"
$username = "root";
$password = "";
$dbname = "attendancejframebd";

// ✅ Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
  exit;
}

date_default_timezone_set('Asia/Kolkata');
$current_day = date('l'); // e.g., Friday
$current_time = date('H:i:s'); // 13:47:00
$current_date = date('Y-m-d');

// ✅ Updated query: supports weekly + once
$sql = "
  SELECT subject_name, start_time, end_time
  FROM subjects
  WHERE (
      (repeat_type = 'weekly' AND LOWER(day) = LOWER('$current_day'))
      OR
      (repeat_type = 'once' AND DATE(start_time) = '$current_date')
  )
  AND TIME(start_time) <= '$current_time'
  AND TIME(end_time) >= '$current_time'
  LIMIT 1
";

$result = $conn->query($sql);

// ✅ Output JSON result
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode([
    "subject_name" => $row["subject_name"],
    "start_time" => $row["start_time"],
    "end_time" => $row["end_time"],
    "debug" => [
      "debug_day" => $current_day,
      "debug_time" => $current_time
    ]
  ]);
} else {
  echo json_encode([
    "subject_name" => "No Subject",
    "start_time" => "",
    "end_time" => "",
    "debug" => [
      "debug_day" => $current_day,
      "debug_time" => $current_time
    ]
  ]);
}

$conn->close();
?>
