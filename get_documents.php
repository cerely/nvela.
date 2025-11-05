<?php
// get_documents.php
require_once 'db.php'; // adjust if db.php is elsewhere

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

try {
    $sql = "SELECT filename, filepath FROM documents ORDER BY uploaded_at DESC";
    $result = $conn->query($sql);

    $docs = [];
    while ($row = $result->fetch_assoc()) {
        $docs[] = $row;
    }

    echo json_encode($docs);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
