<?php
// ================= DB CONNECTION =================
$conn = mysqli_connect("localhost", "root", "Sdk@1259", "employee");
if (!$conn) {
    die("DB Connection Failed: " . mysqli_connect_error());
}

// ================= GET MONTH & YEAR =================
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year  = isset($_GET['year'])  ? (int)$_GET['year']  : date('Y');
$today = date("Y-m-d");

// ================= HELPER FUNCTIONS =================
function getMonthName($month) {
    return date("F", mktime(0,0,0,$month,1,2000));
}

function getNavigationDates($month, $year) {
    $prevMonth = $month - 1;
    $prevYear  = $year;
    if ($prevMonth < 1) { 
        $prevMonth = 12;
        $prevYear--; 
    }

    $nextMonth = $month + 1;
    $nextYear  = $year;
    if ($nextMonth > 12) { 
        $nextMonth = 1; 
        $nextYear++; 
    }
    
    return [
        'prev' => ['month' => $prevMonth, 'year' => $prevYear],
        'next' => ['month' => $nextMonth, 'year' => $nextYear]
    ];
}

function getStats($conn) {
    $stats = [
        'total' => 0,
        'thisMonth' => 0,
        'today' => 0,
        'upcoming' => 0
    ];
    
    // Total occasions
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM office_occasion");
    if ($row = mysqli_fetch_assoc($result)) {
        $stats['total'] = $row['total'];
    }
    
    // This month occasions
    $currentMonth = date('F');
    $currentYear = date('Y');
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM office_occasion 
                                   WHERE month = '$currentMonth' AND year = '$currentYear'");
    if ($row = mysqli_fetch_assoc($result)) {
        $stats['thisMonth'] = $row['total'];
    }
    
    // Today's occasions
    $today = date('Y-m-d');
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM office_occasion 
                                   WHERE day = '".date('d')."' 
AND month = '".date('F')."' 
AND year = '".date('Y')."'");
    if ($row = mysqli_fetch_assoc($result)) {
        $stats['today'] = $row['total'];
    }
    
    // Upcoming occasions (next 7 days)
    $nextWeek = date('Y-m-d', strtotime('+7 days'));
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM office_occasion 
                                   WHERE CONCAT(year, '-', month, '-', day) 
                                   BETWEEN DATE_ADD('$today', INTERVAL 1 DAY) AND '$nextWeek'");
    if ($row = mysqli_fetch_assoc($result)) {
        $stats['upcoming'] = $row['total'];
    }
    
    return $stats;
}

// ================= GET DATA =================
$monthName = getMonthName($month);
$nav = getNavigationDates($month, $year);
$stats = getStats($conn);

// Get occasions for current month
$occasionArr = [];
$monthName = date("F", mktime(0,0,0,$month,1,$year));
$yearStr = (string)$year;

$q = mysqli_query($conn, "SELECT * FROM office_occasion 
                          WHERE month = '$monthName' AND year = '$yearStr'
                          ORDER BY CAST(day AS UNSIGNED), add_date DESC");

while($row = mysqli_fetch_assoc($q)){
    $day = (int)$row['day'];
    if (!isset($occasionArr[$day])) {
        $occasionArr[$day] = [];
    }
    $occasionArr[$day][] = $row;
}

// Calendar calculations
$firstDayOfMonth = date('w', strtotime("$year-$month-01"));
$daysInMonth = date('t', strtotime("$year-$month-01"));

// Get previous month days for empty cells
$prevMonthDays = date('t', strtotime("first day of previous month"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Office Occasion Calendar</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
/* ===== ENHANCED CSS ===== */
.calendar-container { 
    max-width:1400px; 
    margin:20px auto; 
    padding:20px; 
    background:#f8f9fa;
}
.calendar-header { 
    background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); 
    color:white; 
    border-radius:15px 15px 0 0; 
    padding:25px 30px; 
    margin-bottom:20px;
}
.calendar-body { 
    background:white; 
    border-radius:15px; 
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    overflow:hidden;
}
.calendar-day-header { 
    font-weight:600; 
    padding:15px 0; 
    background:#f8f9fa; 
    border-bottom:2px solid #dee2e6; 
    color:#495057;
}
.calendar-day { 
    min-height:140px; 
    padding:12px; 
    border:1px solid #e9ecef; 
    transition:all 0.3s ease;
    position:relative;
    cursor:pointer;
}
.calendar-day:hover { 
    background:#f1f3f4; 
    transform:translateY(-2px);
    box-shadow:0 4px 8px rgba(0,0,0,0.1);
}
.calendar-day.other-month { 
    background:#f8f9fa; 
    color:#adb5bd; 
}
.calendar-day.today { 
    background:#e3f2fd; 
    border:2px solid #2196f3;
    box-shadow:0 0 0 3px rgba(33,150,243,0.1);
}
.calendar-day.has-occasion { 
    background:#fff9e6; 
    border-left:5px solid #ffc107;
}
.day-number { 
    font-weight:700; 
    font-size:1.2rem; 
    margin-bottom:8px;
}
.occasion-item { 
    font-size:12px; 
    padding:4px 8px; 
    margin:3px 0; 
    background:linear-gradient(to right, #ffc107, #ffb300); 
    border-radius:5px; 
    color:#212529;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    transition:all 0.2s;
}
.occasion-item:hover {
    background:linear-gradient(to right, #ffb300, #ffa000);
    transform:translateX(3px);
}
.occasion-count {
    position:absolute;
    top:10px;
    right:10px;
    background:#dc3545;
    color:white;
    border-radius:50%;
    width:22px;
    height:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:bold;
}
.stats-card {
    background:white;
    border-radius:10px;
    padding:20px;
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
    text-align:center;
    transition:transform 0.3s;
    height:100%;
}
.stats-card:hover {
    transform:translateY(-5px);
}
.stats-card h3 {
    font-weight:700;
    margin:10px 0 0 0;
}
.stats-card h6 {
    color:#6c757d;
    font-size:0.9rem;
}
.nav-btn {
    padding:10px 20px;
    font-weight:600;
    border-radius:8px;
    transition:all 0.3s;
}
.nav-btn:hover {
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
.occasion-more {
    font-size:11px;
    color:#6c757d;
    text-align:center;
    margin-top:3px;
    font-style:italic;
}
.month-summary {
    background:linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-radius:10px;
    padding:20px;
    margin-top:20px;
}
.badge-occasion {
    padding:8px 12px;
    margin:5px;
    border-radius:20px;
    font-size:0.85rem;
    background:linear-gradient(45deg, #ffc107, #ff9800);
    color:#000;
    font-weight:500;
}
</style>
</head>
<body>
<div class="container-fluid calendar-container">

    <!-- STATISTICS CARDS -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card border-start border-primary border-4">
                <h6><i class="bi bi-calendar-check me-2"></i>Total Occasions</h6>
                <h3 class="text-primary"><?php echo $stats['total']; ?></h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card border-start border-success border-4">
                <h6><i class="bi bi-calendar-month me-2"></i>This Month</h6>
                <h3 class="text-success"><?php echo $stats['thisMonth']; ?></h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card border-start border-warning border-4">
                <h6><i class="bi bi-calendar-day me-2"></i>Today</h6>
                <h3 class="text-warning"><?php echo $stats['today']; ?></h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card border-start border-info border-4">
                <h6><i class="bi bi-calendar-event me-2"></i>Upcoming</h6>
                <h3 class="text-info"><?php echo $stats['upcoming']; ?></h3>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <div class="calendar-header">
        <div class="d-flex justify-content-between align-items-center">
            <a href="?month=<?= $nav['prev']['month'] ?>&year=<?= $nav['prev']['year'] ?>" 
               class="btn btn-light nav-btn">
                <i class="bi bi-chevron-left me-2"></i> <?= getMonthName($nav['prev']['month']) ?>
            </a>

            <div class="text-center">
                <h1 class="display-5 mb-2"><i class="bi bi-calendar3 me-3"></i><?= $monthName ?> <?= $year ?></h1>
                <div class="d-flex justify-content-center gap-3">
                    <a href="?month=<?= date('m') ?>&year=<?= date('Y') ?>" 
                       class="btn btn-outline-light btn-sm">
                        <i class="bi bi-calendar-check me-2"></i> Today
                    </a>
                    <button class="btn btn-outline-light btn-sm" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i> Print
                    </button>
                </div>
            </div>

            <a href="?month=<?= $nav['next']['month'] ?>&year=<?= $nav['next']['year'] ?>" 
               class="btn btn-light nav-btn">
                <?= getMonthName($nav['next']['month']) ?> <i class="bi bi-chevron-right ms-2"></i>
            </a>
        </div>
    </div>

    <!-- CALENDAR -->
    <div class="calendar-body">
        <!-- Day Headers -->
        <div class="row text-center calendar-day-header">
            <div class="col p-2 text-danger">Sun</div>
            <div class="col p-2">Mon</div>
            <div class="col p-2">Tue</div>
            <div class="col p-2">Wed</div>
            <div class="col p-2">Thu</div>
            <div class="col p-2">Fri</div>
            <div class="col p-2 text-primary">Sat</div>
        </div>

        <!-- Calendar Grid -->
        <div class="row">
            <?php
            // Empty cells for days before month start
            for($i = 0; $i < $firstDayOfMonth; $i++){
                $dayNum = $prevMonthDays - ($firstDayOfMonth - $i - 1);
                echo '<div class="col p-0">';
                echo '<div class="calendar-day other-month">';
                echo '<div class="day-number text-muted">' . $dayNum . '</div>';
                echo '<small class="text-muted">Prev</small>';
                echo '</div></div>';
            }

            // Days of current month
            for($day = 1; $day <= $daysInMonth; $day++){
                $fullDate = sprintf("%04d-%02d-%02d", $year, $month, $day);
                $hasOccasions = isset($occasionArr[$day]);
                $isToday = ($fullDate == $today);
                
                $classes = "calendar-day h-100 d-flex flex-column";
                if ($isToday) $classes .= " today";
                if ($hasOccasions) $classes .= " has-occasion";
                
                echo '<div class="col p-0">';
                echo '<div class="'.$classes.'" onclick="showDayDetails('.$day.', '.$month.', '.$year.')">';
                
                // Day number
                echo '<div class="day-number">'.$day.'</div>';
                
                // Occasion count badge
                if ($hasOccasions) {
                    $count = count($occasionArr[$day]);
                    echo '<span class="occasion-count">'.$count.'</span>';
                }
                
                // Occasions list (show max 2)
                if ($hasOccasions) {
                    echo '<div class="occasion-list flex-grow-1">';
                    $displayCount = min(2, count($occasionArr[$day]));
                    for ($i = 0; $i < $displayCount; $i++) {
                        $occasion = $occasionArr[$day][$i];
                        echo '<div class="occasion-item" title="'.htmlspecialchars($occasion['title']).'">';
                        echo htmlspecialchars(substr($occasion['title'], 0, 20));
                        if (strlen($occasion['title']) > 20) echo '...';
                        echo '</div>';
                    }
                    
                    // Show "more" indicator if there are more occasions
                    if (count($occasionArr[$day]) > 2) {
                        $moreCount = count($occasionArr[$day]) - 2;
                        echo '<div class="occasion-more">+'.$moreCount.' more</div>';
                    }
                    echo '</div>';
                }
                
                echo '</div></div>';

                // Start new row every 7 days
                if (($day + $firstDayOfMonth) % 7 == 0 && $day != $daysInMonth) {
                    echo '</div><div class="row">';
                }
            }
            
            // Empty cells after month end
            $daysDisplayed = $daysInMonth + $firstDayOfMonth;
            $remainingCells = (7 - ($daysDisplayed % 7)) % 7;
            
            for($i = 1; $i <= $remainingCells; $i++){
                echo '<div class="col p-0">';
                echo '<div class="calendar-day other-month">';
                echo '<div class="day-number text-muted">'.$i.'</div>';
                echo '<small class="text-muted">Next</small>';
                echo '</div></div>';
            }
            ?>
        </div>
    </div>

    <!-- MONTHLY SUMMARY -->
    <?php
    $monthOccasionCount = 0;
    foreach ($occasionArr as $day => $occasions) {
        $monthOccasionCount += count($occasions);
    }
    
    if ($monthOccasionCount > 0){ ?>
    <div class="month-summary mt-4">
        <h5 class="mb-3"><i class="bi bi-list-check me-2"></i>Monthly Summary - <?= $monthOccasionCount ?> Occasions in <?= $monthName ?></h5>
        <div class="d-flex flex-wrap">
            <?php 
            ksort($occasionArr);
            foreach ($occasionArr as $day => $occasions){
                foreach ($occasions as $occasion){ ?>
                    <span class="badge-occasion">
                        <i class="bi bi-calendar-event me-1"></i>
                        <?= $day ?>: <?= htmlspecialchars($occasion['title']) ?>
                    </span>
                <?php }
            } ?>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showDayDetails(day, month, year) {
    // You can implement AJAX to fetch day details or redirect to a details page
    alert('Showing details for: ' + day + '/' + month + '/' + year + '\n\nYou can implement AJAX here to fetch occasion details.');
    
    // Example AJAX implementation (uncomment and create the PHP file):
    /*
    fetch('get_day_details.php?day=' + day + '&month=' + month + '&year=' + year)
        .then(response => response.json())
        .then(data => {
            // Show modal with data
            console.log(data);
        });
    */
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowLeft') {
        window.location.href = '?month=<?= $nav['prev']['month'] ?>&year=<?= $nav['prev']['year'] ?>';
    } else if (e.key === 'ArrowRight') {
        window.location.href = '?month=<?= $nav['next']['month'] ?>&year=<?= $nav['next']['year'] ?>';
    } else if (e.key === 't' || e.key === 'T') {
        window.location.href = '?month=<?= date('m') ?>&year=<?= date('Y') ?>';
    }
});

// Auto-refresh every 5 minutes
setTimeout(function() {
    location.reload();
}, 300000);
</script>
</body>
</html>
<?php
mysqli_close($conn);
?>