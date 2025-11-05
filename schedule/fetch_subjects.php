<?php
require_once '../db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    if ($conn->connect_error) {
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
    
    $sql = "SELECT * FROM subjects ORDER BY start_time";
    $result = $conn->query($sql);
    
    $events = [];

    // Day name to FullCalendar day number mapping
    $dayMap = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6
    ];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $repeatType = $row['repeat'] ?? $row['repeat_type'] ?? 'once'; // your DB may use either name
            $dayName = $row['day'] ?? '';
            $color = $row['color'] ?? '#3a87ad';

            // Weekly events — repeat every week on the same day
            if (strtolower($repeatType) === 'weekly' && isset($dayMap[$dayName])) {
                $events[] = [
                    'id' => $row['id'],
                    'title' => $row['subject_name'] . "\n" . ($row['professor'] ?? ''),
                    'daysOfWeek' => [$dayMap[$dayName]], // 🔁 repeat weekly
                    'startTime' => date('H:i:s', strtotime($row['start_time'])),
                    'endTime' => date('H:i:s', strtotime($row['end_time'])),
                    'color' => $color,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'extendedProps' => [
                        'professor' => $row['professor'] ?? '',
                        'day' => $dayName,
                        'repeat' => $repeatType
                    ]
                ];
            } 
            // One-time events
            else {
                $startTime = $row['start_time'];
                $endTime = $row['end_time'];

                // Ensure proper ISO format for FullCalendar
                if (strpos($startTime, 'T') === false) {
                    $startTime = str_replace(' ', 'T', $startTime);
                }
                if (strpos($endTime, 'T') === false) {
                    $endTime = str_replace(' ', 'T', $endTime);
                }

                $events[] = [
                    'id' => $row['id'],
                    'title' => $row['subject_name'] . "\n" . ($row['professor'] ?? ''),
                    'start' => $startTime,
                    'end' => $endTime,
                    'color' => $color,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'extendedProps' => [
                        'professor' => $row['professor'] ?? '',
                        'day' => $dayName,
                        'repeat' => $repeatType
                    ]
                ];
            }
        }
    }

    echo json_encode($events);
    $conn->close();

} catch(Exception $e) {
    error_log("fetch_subjects error: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch subjects: ' . $e->getMessage()]);
}
?>
