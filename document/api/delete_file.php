<?php
include __DIR__ . "/../db.php";
$table = "documents";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;
  if ($id > 0) {
    // Find file path
    $stmt = $conn->prepare("SELECT filepath FROM {$table} WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($filepath);
    $stmt->fetch();
    $stmt->close();

    if (!empty($filepath)) {
      $absPath = __DIR__ . "/../" . $filepath;
      if (file_exists($absPath)) {
        unlink($absPath);
      }
    }

    // Delete row
    $stmt = $conn->prepare("DELETE FROM {$table} WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "OK";
  } else {
    http_response_code(400);
    echo "Invalid id";
  }
}
$conn->close();
