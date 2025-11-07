<?php
header('Content-Type: application/json');

// Include DB connection (make sure this path is correct)
include_once("../db.php");

date_default_timezone_set("Asia/Kolkata");

$day = date('l'); // e.g. Friday
$time = date('H:i:s');

// Debug array
$debug = [
    "debug_day" => $day,
    "debug_time" => $time
];

// SQL query
$sql = "
  SELECT subject_name
  FROM subjects
  WHERE (
      (repeat_type = 'weekly' AND LOWER(day) = LOWER(?))
      OR
      (repeat_type = 'once' AND DATE(start_time) = CURDATE())
  )
  AND TIME(start_time) <= ?
  AND TIME(end_time) >= ?
  LIMIT 1
";


// Prepare the statement
$stmt = $conn->prepare($sql);

// If preparation failed, show the error
if (!$stmt) {
    echo json_encode([
        "error" => "SQL prepare failed",
        "mysqli_error" => $conn->error,
        "query" => $sql,
        "debug" => $debug
    ]);
    exit;
}

$stmt->bind_param("sss", $day, $time, $time);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "subject_name" => $row['subject_name'],
        "debug" => $debug
    ]);
} else {
    echo json_encode([
        "subject_name" => "No Subject",
        "debug" => $debug
    ]);
}
?>
