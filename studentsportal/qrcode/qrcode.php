<?php
include __DIR__ . "/../../db.php";

$nameSelected = null;
$imageData = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT id, name FROM userdetails WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $nameSelected = $row['name'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search User</title>
    <style>
        .square {
            width: 250px;
            height: 250px;
            object-fit: cover;
            border: 2px solid #ccc;
            border-radius: 8px;
        }
        .download-btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .download-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Search User</h2>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Enter name">
        <button type="submit">Search</button>
    </form>

    <?php if (isset($_GET['search'])): ?>
        <h3>Search Results:</h3>
        <ul>
        <?php
        $search = "%" . $_GET['search'] . "%";
        $sql = "SELECT id, name FROM userdetails WHERE name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li><a href='?id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</a></li>";
            }
        } else {
            echo "<li>No users found</li>";
        }
        ?>
        </ul>
    <?php endif; ?>

    <?php if ($nameSelected): ?>
        <hr>
        <h3><?php echo htmlspecialchars($nameSelected); ?>'s Image</h3>
        <img class="square" 
             src="image.php?id=<?php echo $_GET['id']; ?>" 
             alt="<?php echo htmlspecialchars($nameSelected); ?>">
        <br><br>
        <a href="image.php?id=<?php echo $_GET['id']; ?>&download=1">
            <button class="download-btn" type="button">Download Image</button>
        </a>
    <?php endif; ?>
</body>
</html>
