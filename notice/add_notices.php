<?php
header('Content-Type: application/json');

// DB Connection
$host = "attendance.cb6y0yii0m0z.ap-south-1.rds.amazonaws.com:3306";
$username = "admin";
$password = "amazonaws";
$database = "attendancejframebd";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB connection failed: " . $conn->connect_error]);
    exit;
}

// Read JSON body
$input = json_decode(file_get_contents("php://input"), true);

$title = $input["title"] ?? '';
$content = $input["content"] ?? '';
$priority = $input["priority"] ?? 'medium';
$category = $input["category"] ?? 'general';
$tags = isset($input["tags"]) ? (is_array($input["tags"]) ? implode(",", $input["tags"]) : $input["tags"]) : '';

// Validate
if (empty($title) || empty($content)) {
    echo json_encode(["success" => false, "error" => "Title and content are required"]);
    exit;
}

// Insert
$stmt = $conn->prepare("INSERT INTO notices (title, content, priority, category, tags) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $content, $priority, $category, $tags);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Notice added successfully"]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
