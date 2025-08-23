<?php
include __DIR__ . "/../db.php";

$result = $conn->query("SELECT * FROM documents ORDER BY uploaded_at DESC");
$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}
echo json_encode($files);
?>
