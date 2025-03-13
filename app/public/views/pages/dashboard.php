<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/dashboard_styles.css">
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
    <script src="/assets/fullcalender/dist/index.global.js"></script>
    <title>Dashboard</title>
</head>
<body>

    <?php
        $activePage = 'dashboard'; 
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>

    <?php
    if (!isset($_SESSION['user_id'])) {
        die("No user ID in session. Please log in.");
    }
    ?>

    <!-- Notification Modal -->
    <div id="notificationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Notifications</h2>
            <ul id="notificationsList"></ul>
        </div>
    </div>

    <!-- Main Dashboard -->
    <div class="dashboard-container">

        <!-- Header -->
        <header class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); echo "\n";?>!</h1>
        </header>

        <!-- Summary Grid -->
        <section class="dashboard-grid">
            <div class="card summary-card" id="taskSummary">
                <h3>Task Summary</h3>
                <p>Total: <span id="totalTasks">0</span></p>
                <p>Completed: <span id="completedTasks">0</span></p>
                <p>Pending: <span id="pendingTasks">0</span></p>
            </div>

            <div class="card summary-card" id="priorityBreakdown">
                <h3>Priority Breakdown</h3>
                <p>Low: <span id="lowPriority">0</span></p>
                <p>Medium: <span id="mediumPriority">0</span></p>
                <p>High: <span id="highPriority">0</span></p>
            </div>

            <div class="card summary-card" id="upcomingDeadlines">
                <h3>Upcoming Deadlines</h3>
                <ul id="deadlineList"></ul>
            </div>

            <div class="card subjects-card">
                <h3>Subjects Overview</h3>
                <ul id="subjectsList"></ul>
            </div>
        </section>

        <!-- Study Timer and Calendar in Flexbox -->
        <section class="study-and-calendar">
            <!-- Study Timer -->
            <div class="study-timer-container card">
                <h3>Study Session Timer</h3>
                <div id="timer-display" class="timer-display">25:00</div>
                <p id="timer-state" class="timer-state">Focus Session</p>

                <div class="timer-controls">
                    <button id="start-timer" class="btn timer-btn">Start</button>
                    <button id="stop-timer" class="btn timer-btn">Stop</button>
                    <button id="reset-timer" class="btn timer-btn">Reset</button>
                </div>

                <p id="session-count">Completed Sessions: 0</p>
            </div>

            <!-- Calendar -->
            <div class="calendar-container card">
                <h3>Task Calendar</h3>
                <div id="calendar"></div>
            </div>
        </section>
    </div>

    <script src="../../assets/js/dashboard.js"></script>
</body>
</html>
