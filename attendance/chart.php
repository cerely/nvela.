<?php
include __DIR__ . "/../db.php"; // DB connection

// Fetch past week + today attendance
$labels = [];
$data   = [];
$backgroundColors = [];
$borderColors = [];

// Generate last 7 days + today range
$days = [];
for ($i = 7; $i >= 0; $i--) {
    $days[] = date('Y-m-d', strtotime("-$i days"));
}

// Get attendance from DB
$sql = "SELECT DATE(date) as day, COUNT(DISTINCT userid) as total_present
        FROM userattendance
        WHERE date >= CURDATE() - INTERVAL 7 DAY
        GROUP BY day";
$result = $conn->query($sql);

$attendance = [];
while ($row = $result->fetch_assoc()) {
    $attendance[$row['day']] = $row['total_present'];
}

// Build chart data
foreach ($days as $day) {
    $labels[] = $day;
    $count = isset($attendance[$day]) ? $attendance[$day] : 0;
    $data[] = $count;

    if ($count > 0) {
        // Present → filled bar
        $backgroundColors[] = 'rgba(75, 192, 192, 0.6)';
        $borderColors[] = 'rgba(75, 192, 192, 1)';
    } else {
        // Absent → empty bar with outline only
        $backgroundColors[] = 'rgba(0,0,0,0)'; // transparent
        $borderColors[] = 'rgba(200, 0, 0, 1)'; // red outline
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Past Week + Today Attendance</h2>
<canvas id="attendanceChart" width="600" height="300"></canvas>

<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Total Present',
            data: <?= json_encode($data) ?>,
            backgroundColor: <?= json_encode($backgroundColors) ?>,
            borderColor: <?= json_encode($borderColors) ?>,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        scales: { 
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
