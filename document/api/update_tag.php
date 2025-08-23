<?php
include __DIR__ . "/../db.php";
$table = "documents";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id  = isset($_POST["id"]) ? (int)$_POST["id"] : 0;
  $tag = isset($_POST["tag"]) ? trim($_POST["tag"]) : "";
  if ($id > 0) {
    $stmt = $conn->prepare("UPDATE {$table} SET tag=? WHERE id=?");
    $stmt->bind_param("si", $tag, $id);
    $stmt->execute();
    $stmt->close();
    echo "OK";
  } else {
    http_response_code(400);
    echo "Invalid id";
  }
}
$conn->close();
