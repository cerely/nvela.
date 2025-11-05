<?php
require_once '../db.php';  // or 'db.php' if in same folder

header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');

try {
    if ($conn->connect_error) {
        echo 'error: Database connection failed - ' . $conn->connect_error;
        exit;
    }
    
    $subjectName = $_POST['subject_name'] ?? '';
    $professor = $_POST['professor'] ?? '';
    $color = $_POST['color'] ?? '#3a87ad';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';
    $day = $_POST['day'] ?? '';
    $repeat = $_POST['repeat'] ?? 'weekly';
    
    if (empty($subjectName)) {
        echo 'error: Subject name is required';
        exit;
    }
    
    if (empty($startTime) || empty($endTime)) {
        echo 'error: Start and end time are required';
        exit;
    }
    
    // Check if table exists
    $tableCheck = $conn->query("SHOW TABLES LIKE 'subjects'");
    if ($tableCheck->num_rows == 0) {
        echo 'error: Table "subjects" does not exist. Please create it first using the SQL provided.';
        exit;
    }
    
    $sql = "INSERT INTO subjects 
            (subject_name, professor, color, start_time, end_time, day, repeat_type, created_at) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        echo 'error: Prepare failed - ' . $conn->error;
        exit;
    }
    
    $stmt->bind_param("sssssss", $subjectName, $professor, $color, $startTime, $endTime, $day, $repeat);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: Execute failed - ' . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    
} catch(Exception $e) {
    error_log("save_subject error: " . $e->getMessage());
    echo 'error: Exception - ' . $e->getMessage();
}
?>