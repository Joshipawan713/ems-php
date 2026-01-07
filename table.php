<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Sdk@1259');
define('DB_NAME', 'employee');

class BootstrapCalendar {
    private $month;
    private $year;
    private $db;
    
    public function __construct($month = null, $year = null) {
        $this->month = $month ?? date('n');
        $this->year = $year ?? date('Y');
        $this->connectDB();
    }
    
    private function connectDB() {
        try {
            $this->db = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    private function getMonthName($month) {
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        return $months[$month];
    }
    
    private function getDaysInMonth() {
        return date('t', strtotime($this->year . '-' . $this->month . '-01'));
    }
    
    private function getFirstDayOfWeek() {
        return date('w', strtotime($this->year . '-' . $this->month . '-01'));
    }
    
    private function getOccasionsForDay($day) {
        $stmt = $this->db->prepare(
            "SELECT * FROM office_occasion 
            WHERE day = :day 
            AND month = :month 
            AND year = :year 
            ORDER BY add_date DESC"
        );
        
        $stmt->execute([
            ':day' => str_pad($day, 2, '0', STR_PAD_LEFT),
            ':month' => str_pad($this->month, 2, '0', STR_PAD_LEFT),
            ':year' => $this->year
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getOccasionsForMonth() {
        $stmt = $this->db->prepare(
            "SELECT day, title FROM office_occasion 
            WHERE month = :month 
            AND year = :year"
        );
        
        $stmt->execute([
            ':month' => str_pad($this->month, 2, '0', STR_PAD_LEFT),
            ':year' => $this->year
        ]);
        
        $occasions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $day = (int) $row['day'];
            if (!isset($occasions[$day])) {
                $occasions[$day] = [];
            }
            $occasions[$day][] = $row['title'];
        }
        
        return $occasions;
    }
    
    public function render() {
        $prevMonth = $this->month - 1;
        $prevYear = $this->year;
        if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear--;
        }
        
        $nextMonth = $this->month + 1;
        $nextYear = $this->year;
        if ($nextMonth == 13) {
            $nextMonth = 1;
            $nextYear++;
        }
        
        // Get all occasions for the month
        $monthOccasions = $this->getOccasionsForMonth();
        
        ob_start();
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
                .calendar-container {
                    max-width: 1200px;
                    margin: 20px auto;
                    padding: 20px;
                }
                .calendar-header {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border-radius: 10px 10px 0 0;
                    padding: 25px;
                }
                .calendar-body {
                    background: white;
                    border-radius: 0 0 10px 10px;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                }
                .calendar-day-header {
                    font-weight: 600;
                    padding: 15px 0;
                    background: #f8f9fa;
                    border-bottom: 2px solid #dee2e6;
                }
                .calendar-day {
                    min-height: 120px;
                    padding: 10px;
                    border: 1px solid #e9ecef;
                    transition: all 0.3s;
                }
                .calendar-day:hover {
                    background-color: #f8f9fa;
                }
                .calendar-day.other-month {
                    background-color: #f8f9fa;
                    color: #adb5bd;
                }
                .calendar-day.today {
                    background-color: #e3f2fd;
                    border: 2px solid #2196f3;
                }
                .calendar-day.has-occasion {
                    background-color: #fff3cd;
                    border-left: 4px solid #ffc107;
                }
                .day-number {
                    font-weight: 600;
                    font-size: 1.1rem;
                    margin-bottom: 5px;
                }
                .occasion-list {
                    font-size: 0.8rem;
                    margin-top: 5px;
                }
                .occasion-item {
                    padding: 2px 5px;
                    margin: 1px 0;
                    background: #ffc107;
                    border-radius: 3px;
                    color: #212529;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    cursor: pointer;
                }
                .occasion-item:hover {
                    background: #ffca2c;
                }
                .occasion-count {
                    font-size: 0.7rem;
                    background: #dc3545;
                    color: white;
                    border-radius: 50%;
                    width: 18px;
                    height: 18px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    margin-left: 5px;
                }
                .occasion-modal .modal-dialog {
                    max-width: 500px;
                }
                .stats-card {
                    background: white;
                    border-radius: 10px;
                    padding: 15px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    margin-bottom: 20px;
                }
                .occasion-form-container {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 20px;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container-fluid calendar-container">
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h6 class="text-muted">Total Occasions</h6>
                            <h3 id="totalOccasions" class="text-primary">0</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h6 class="text-muted">This Month</h6>
                            <h3 id="monthOccasions" class="text-success">0</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h6 class="text-muted">Today</h6>
                            <h3 id="todayOccasions" class="text-warning">0</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <h6 class="text-muted">Upcoming</h6>
                            <h3 id="upcomingOccasions" class="text-info">0</h3>
                        </div>
                    </div>
                </div>
                
                <!-- Header with Navigation -->
                <div class="calendar-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" 
                           class="btn btn-light nav-btn">
                            <i class="bi bi-chevron-left"></i> <?= $this->getMonthName($prevMonth) ?>
                        </a>
                        
                        <div class="text-center">
                            <h1 class="display-5 mb-2">
                                <i class="bi bi-calendar3"></i> 
                                <?= $this->getMonthName($this->month) ?> <?= $this->year ?>
                            </h1>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="?month=<?= date('n') ?>&year=<?= date('Y') ?>" 
                                   class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-calendar-check"></i> Today
                                </a>
                                <button class="btn btn-outline-light btn-sm" onclick="printCalendar()">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                            </div>
                        </div>
                        
                        <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" 
                           class="btn btn-light nav-btn">
                            <?= $this->getMonthName($nextMonth) ?> <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Calendar Grid -->
                <div class="calendar-body">
                    <div class="row text-center calendar-day-header">
                        <?php
                        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                        foreach ($daysOfWeek as $day): ?>
                            <div class="col p-2"><?= $day ?></div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="row">
                        <?php
                        $daysInMonth = $this->getDaysInMonth();
                        $firstDay = $this->getFirstDayOfWeek();
                        $currentDay = 1;
                        $today = date('j');
                        $currentMonth = date('n');
                        $currentYear = date('Y');
                        
                        // Fill empty cells for days before the first day of month
                        for ($i = 0; $i < $firstDay; $i++): 
                            $prevMonthDay = date('j', strtotime('last day of previous month') - ($firstDay - $i - 1) * 86400);
                        ?>
                            <div class="col p-0 calendar-day other-month">
                                <div class="calendar-day h-100 d-flex flex-column">
                                    <div class="day-number text-muted">
                                        <?= $prevMonthDay ?>
                                    </div>
                                    <small class="text-muted mt-auto"><?= $this->getMonthName($prevMonth == 12 ? 1 : $prevMonth) ?></small>
                                </div>
                            </div>
                        <?php endfor;
                        
                        // Fill days of the month
                        while ($currentDay <= $daysInMonth):
                            if (($currentDay + $firstDay - 1) % 7 == 0 && $currentDay != 1): ?>
                                </div><div class="row">
                            <?php endif; 
                            
                            $hasOccasions = isset($monthOccasions[$currentDay]);
                            $isToday = ($currentDay == $today && $this->month == $currentMonth && $this->year == $currentYear);
                            ?>
                            
                            <div class="col p-0">
                                <div class="calendar-day h-100 d-flex flex-column 
                                    <?= $isToday ? 'today' : '' ?>
                                    <?= $hasOccasions ? 'has-occasion' : '' ?>"
                                    data-day="<?= $currentDay ?>"
                                    onclick="showDayOccasions(<?= $currentDay ?>, <?= $this->month ?>, <?= $this->year ?>)">
                                    
                                    <div class="d-flex justify-content-between">
                                        <div class="day-number">
                                            <?= $currentDay ?>
                                        </div>
                                        <?php if ($hasOccasions): ?>
                                            <span class="occasion-count"><?= count($monthOccasions[$currentDay]) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="occasion-list flex-grow-1">
                                        <?php if ($hasOccasions): 
                                            // Show first 2 occasions
                                            $displayOccasions = array_slice($monthOccasions[$currentDay], 0, 2);
                                            foreach ($displayOccasions as $occasion): ?>
                                                <div class="occasion-item" title="<?= htmlspecialchars($occasion) ?>">
                                                    <?= htmlspecialchars($occasion) ?>
                                                </div>
                                            <?php endforeach; 
                                            
                                            // Show "more" indicator if there are more occasions
                                            if (count($monthOccasions[$currentDay]) > 2): ?>
                                                <div class="text-muted small">
                                                    +<?= count($monthOccasions[$currentDay]) - 2 ?> more
                                                </div>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                            $currentDay++;
                        endwhile;
                        
                        // Fill empty cells for days after the last day of month
                        $lastDayCells = (7 - (($daysInMonth + $firstDay) % 7)) % 7;
                        for ($i = 1; $i <= $lastDayCells; $i++): ?>
                            <div class="col p-0 calendar-day other-month">
                                <div class="calendar-day h-100 d-flex flex-column">
                                    <div class="day-number text-muted"><?= $i ?></div>
                                    <small class="text-muted mt-auto"><?= $this->getMonthName($nextMonth) ?></small>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <!-- Monthly Summary -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h5><i class="bi bi-list-check"></i> Monthly Summary</h5>
                    <div class="row">
                        <?php 
                        $monthOccasionCount = 0;
                        foreach ($monthOccasions as $day => $occasions) {
                            $monthOccasionCount += count($occasions);
                        }
                        ?>
                        <div class="col-md-4">
                            <div class="alert alert-info">
                                <h6>Total Occasions This Month</h6>
                                <h3><?= $monthOccasionCount ?></h3>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6>All Occasions in <?= $this->getMonthName($this->month) ?>:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($monthOccasions as $day => $occasions): 
                                    foreach ($occasions as $occasion): ?>
                                        <span class="badge bg-warning text-dark">
                                            <?= $day ?>: <?= htmlspecialchars($occasion) ?>
                                        </span>
                                    <?php endforeach;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Occasion Details Modal -->
            <div class="modal fade" id="occasionModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalTitle"></h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="modalBody">
                            <!-- Occasions will be loaded here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="deleteOccasionBtn" style="display: none;">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bootstrap JS Bundle -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                // Initialize stats
                updateStats();
                
                // Form submission
                document.getElementById('addOccasionForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const date = document.getElementById('occasionDate').value;
                    const title = document.getElementById('occasionTitle').value;
                    
                    fetch('add_occasion.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            date: date,
                            title: title
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Occasion added successfully!');
                            window.location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to add occasion');
                    });
                });
                
                function showDayOccasions(day, month, year) {
                    fetch(`get_occasions.php?day=${day}&month=${month}&year=${year}`)
                        .then(response => response.json())
                        .then(data => {
                            const modalTitle = document.getElementById('modalTitle');
                            const modalBody = document.getElementById('modalBody');
                            const deleteBtn = document.getElementById('deleteOccasionBtn');
                            
                            modalTitle.innerHTML = `<i class="bi bi-calendar-event"></i> Occasions on ${day}/${month}/${year}`;
                            
                            if (data.length > 0) {
                                let html = '<div class="list-group">';
                                data.forEach(occasion => {
                                    html += `
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">${occasion.title}</h6>
                                                    <small class="text-muted">
                                                        Added by: ${occasion.added_by_id}<br>
                                                        Date: ${occasion.add_date} ${occasion.add_time}
                                                    </small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteOccasion(${occasion.id})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    `;
                                });
                                html += '</div>';
                                modalBody.innerHTML = html;
                                deleteBtn.style.display = 'none';
                            } else {
                                modalBody.innerHTML = `
                                    <div class="text-center py-4">
                                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-3">No occasions found for this day.</p>
                                        <button class="btn btn-primary" onclick="addOccasionToDate(${day}, ${month}, ${year})">
                                            <i class="bi bi-plus-circle"></i> Add Occasion
                                        </button>
                                    </div>
                                `;
                                deleteBtn.style.display = 'none';
                            }
                            
                            const modal = new bootstrap.Modal(document.getElementById('occasionModal'));
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to load occasions');
                        });
                }
                
                function addOccasionToDate(day, month, year) {
                    const dateStr = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                    document.getElementById('occasionDate').value = dateStr;
                    document.getElementById('occasionTitle').focus();
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('occasionModal'));
                    modal.hide();
                    
                    // Scroll to form
                    document.querySelector('.occasion-form-container').scrollIntoView({
                        behavior: 'smooth'
                    });
                }
                
                function deleteOccasion(id) {
                    if (confirm('Are you sure you want to delete this occasion?')) {
                        fetch('delete_occasion.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id: id })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Occasion deleted successfully!');
                                window.location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to delete occasion');
                        });
                    }
                }
                
                function updateStats() {
                    fetch('get_stats.php')
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('totalOccasions').textContent = data.total;
                            document.getElementById('monthOccasions').textContent = data.thisMonth;
                            document.getElementById('todayOccasions').textContent = data.today;
                            document.getElementById('upcomingOccasions').textContent = data.upcoming;
                        })
                        .catch(error => {
                            console.error('Error updating stats:', error);
                        });
                }
                
                function printCalendar() {
                    window.print();
                }
                
                // Keyboard navigation
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowLeft') {
                        window.location.href = '?month=<?= $prevMonth ?>&year=<?= $prevYear ?>';
                    } else if (e.key === 'ArrowRight') {
                        window.location.href = '?month=<?= $nextMonth ?>&year=<?= $nextYear ?>';
                    }
                });
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Handle month/year parameters
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Create and render calendar
$calendar = new BootstrapCalendar($month, $year);
echo $calendar->render();