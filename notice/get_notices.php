<?php
include __DIR__ . "/../db.php";

header('Content-Type: application/json');

$sql = "SELECT * FROM notices ORDER BY timestamp DESC";
$result = $conn->query($sql);

$notices = [];
while($row = $result->fetch_assoc()) {
    $row['tags'] = $row['tags'] ? explode(",", $row['tags']) : [];
    $notices[] = $row;
}

echo json_encode($notices);
$conn->close();
?>
