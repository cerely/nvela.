<?php
include __DIR__ . "/../../db.php";

if (!isset($_GET['id'])) {
    http_response_code(400);
    die("No ID provided");
}

$id = intval($_GET['id']);

$sql = "SELECT imagename FROM userdetails WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $filename = $row['imagename']; // e.g. "user1.png"
    $filePath = __DIR__ . "/uploads/" . $filename; // path to your uploads folder

    if (file_exists($filePath)) {
        $mimeType = mime_content_type($filePath);
        header("Content-Type: " . $mimeType);

        if (isset($_GET['download'])) {
            header('Content-Disposition: attachment; filename="user_' . $id . '.' . pathinfo($filePath, PATHINFO_EXTENSION) . '"');
        }

        readfile($filePath);
    } else {
        http_response_code(404);
        echo "Image file not found on server";
    }
} else {
    http_response_code(404);
    echo "User not found";
}
