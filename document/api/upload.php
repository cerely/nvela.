<?php
include __DIR__ . "/../../db.php";

if (isset($_FILES['file'])) {
    $uploadDir = __DIR__ . "/../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filename = basename($_FILES['file']['name']);
    $targetPath = $uploadDir . $filename;
    $dbPath = "uploads/" . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        // Save in DB
        $stmt = $conn->prepare("INSERT INTO documents (filename, filepath) VALUES (?, ?)");
        $stmt->bind_param("ss", $filename, $dbPath);
        $stmt->execute();
        echo json_encode(["success" => true, "file" => $filename]);
    } else {
        echo json_encode(["success" => false, "error" => "Upload failed"]);
    }
}
?>
