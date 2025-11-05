<?php
include __DIR__ . '/../db.php';

if (!isset($_GET['name'])) {
    die("Name not specified.");
}

$name = $_GET['name'];

// Fetch the corresponding QR code
$sql = "SELECT qrcode FROM userdetails WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $imageData = $row['qrcode'];

    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="' . $name . '_QR.png"');
    echo $imageData;
} else {
    echo "QR code not found for $name";
}

$stmt->close();
$conn->close();
?>
