<?php
include __DIR__ . "/../db.php"; // Your DB connection

// Get month and year from GET or default to current
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Total days in that month
$totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Today's date to avoid showing future days
$today = new DateTime();
$cutoffDate = new DateTime("$year-$month-$totalDays");
$isFutureMonth = $cutoffDate > $today;

// --- Fetch all users ---
$users = [];
$sqlUsers = "SELECT id, name FROM userdetails";
$resultUsers = $conn->query($sqlUsers);

if ($resultUsers) {
    while ($row = $resultUsers->fetch_assoc()) {
        $users[$row['id']] = [
            'name' => $row['name'],
            'attendance' => array_fill(1, $totalDays, 'A') // default Absent
        ];
    }
}

// --- Fetch attendance for the selected month ---
$startDate = "$year-$month-01";
$endDate = "$year-$month-$totalDays";

$sqlAtt = "SELECT userid, DATE(date) as date 
           FROM userattendance 
           WHERE date BETWEEN '$startDate' AND '$endDate'";
$resultAtt = $conn->query($sqlAtt);

if ($resultAtt) {
    while ($row = $resultAtt->fetch_assoc()) {
        $userId = $row['userid'];
        $day = (int)date('j', strtotime($row['date']));
        if (isset($users[$userId])) {
            $users[$userId]['attendance'][$day] = 'P'; // Mark as Present
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Sheet</title>
    
</head>
<body>

<h2>Attendance for <?= date('F Y', strtotime("$year-$month-01")) ?></h2>

<form method="get">
    Month: <input type="number" name="month" min="1" max="12" value="<?= $month ?>">
    Year: <input type="number" name="year" min="2000" max="2100" value="<?= $year ?>">
    <button type="submit">View</button>
</form>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <?php for ($d = 1; $d <= $totalDays; $d++): ?>
                <th><?= $d ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td class="name"><?= htmlspecialchars($user['name']) ?></td>
                <?php for ($d = 1; $d <= $totalDays; $d++): 
                    $cellDate = new DateTime("$year-$month-$d");
                    $symbol = $user['attendance'][$d];
                    if ($cellDate > $today) {
                        $symbol = '-'; // Future date
                    }
                ?>
                    <td><?= $symbol ?></td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
