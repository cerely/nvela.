<?php
require_once '../db.php'; // adjust path if needed

header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *'); // allow local JS requests

try {
    if (!isset($_POST['id'])) {
        echo "missing_id";
        exit;
    }

    $id = intval($_POST['id']); // sanitize

    if ($conn->connect_error) {
        echo "db_error";
        exit;
    }

    // Prepare the delete query
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "success";
        } else {
            echo "not_found";
        }
    } else {
        echo "query_failed";
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo "error: " . $e->getMessage();
}
?>
