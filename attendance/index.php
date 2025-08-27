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
    <link rel="stylesheet" href="att.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" />
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <p>nvela.</p>
            </div>

            <div class="nav-icons">
                <a href="../main.html" class="nav-ico">
                    <span class="material-symbols-outlined">dashboard</span>
                </a>
                <a href="http://localhost/NVELAMAIN/document/nvela.php" class="nav-ico">
                    <span class="material-symbols-outlined">description</span>
                </a>
                <a href="#control" class="nav-ico">
                    <span class="material-symbols-outlined">discover_tune</span>
                </a>
                <a href="#database" class="nav-ico">
                    <span class="material-symbols-outlined">database</span>
                </a>
            </div>

            <div class="search">
                <span class="material-symbols-outlined">search</span>
                <p class="search-txt">Search in dashboard</p>
            </div>

            <div class="settings">
                <span class="material-symbols-outlined">settings</span>
            </div>

            <div class="profile">
                <div class="profile-photo">
                    <img src="../images/pfp.jpg" alt="Profile">
                </div>
                <div class="profile-desc">
                    <p class="p1">Logged in as,</p>
                    <p class="p2">Admin</p>
                    
                </div>
            </div>
        </nav>
    </header>
    <div class="month">
        <h2>Attendance for <?= date('F Y', strtotime("$year-$month-01")) ?></h2>
        <form method="get">
            Month: <input type="number" name="month" min="1" max="12" value="<?= $month ?>">
            Year: <input type="number" name="year" min="2000" max="2100" value="<?= $year ?>">
            <button type="submit">View</button>
        </form>
    </div>

    <div class="main">
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
    </div>

</body>
</html>
