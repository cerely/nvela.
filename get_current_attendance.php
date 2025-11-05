<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendancejframebd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  echo json_encode(["error" => "Database connection failed"]);
  exit;
}

date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d');

// ✅ Fetch attendance for today, format date as DD-MM-YY
$sql = "
  SELECT 
    u.name AS student_name,
    DATE_FORMAT(a.checkin, '%d-%m-%y') AS checkin_date
  FROM userattendance a
  INNER JOIN userdetails u ON a.userid = u.id
  WHERE DATE(a.date) = ?
  ORDER BY a.checkin ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
  echo json_encode(["error" => "Query failed: " . $conn->error]);
  $conn->close();
  exit;
}

if ($result->num_rows > 0) {
  $attendance = [];
  while ($row = $result->fetch_assoc()) {
    $attendance[] = [
      "student_name" => $row["student_name"],
      "checkin" => $row["checkin_date"]
    ];
  }
  echo json_encode(["attendance" => $attendance]);
} else {
  echo json_encode(["message" => "No attendance records found for today"]);
}

$conn->close();
?>
