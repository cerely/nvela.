<?php
include __DIR__ . "/../db.php";
header('Content-Type: application/json');

$id = intval($_GET['id']);

$sql = "DELETE FROM notices WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}
$conn->close();
?>
