<?php
include __DIR__ . '/../db.php';
// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Prepare query
$sql = "SELECT name, qrcode FROM userdetails WHERE name LIKE '%$search%'";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 40px;
        }
        h1 {
            text-align: center;
        }
        .search-box {
            text-align: center;
            margin-bottom: 30px;
        }
        input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .user-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .user-card {
            background: white;
            width: 400px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .user-info {
            font-weight: bold;
        }
        img {
            height: 80px;
            width: 80px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .download-btn {
            padding: 6px 10px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .download-btn:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>

<h1>QR Codes</h1>

<div class="search-box">
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by name..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>
</div>

<div class="user-list">
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = htmlspecialchars($row['name']);
        $imageData = base64_encode($row['qrcode']);
        echo "
        <div class='user-card'>
            <div class='user-info'>$name</div>
            <img src='data:image/png;base64,$imageData' alt='QR Code'>
            <a href='download.php?name=" . urlencode($name) . "'>
                <button class='download-btn'>Download PNG</button>
            </a>
        </div>";
    }
} else {
    echo "<p>No records found.</p>";
}
$conn->close();
?>
</div>

</body>
</html>
