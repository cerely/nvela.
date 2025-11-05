<?php
include __DIR__ . '/../db.php'; // adjust as needed

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    // Prepare statement to safely fetch qrcode
    $stmt = $conn->prepare("SELECT qrcode FROM userdetails WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($qrcodeData);
        $stmt->fetch();

        header("Content-Type: image/png");
        echo $qrcodeData;
    } else {
        // If no record found, show placeholder
        header("Content-Type: image/png");
        readfile("placeholder.png");
    }

    $stmt->close();
}
$conn->close();
?>
