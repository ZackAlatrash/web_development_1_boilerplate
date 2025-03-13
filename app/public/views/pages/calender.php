<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
    <link rel="stylesheet" href="../../assets/css/caledar_styles.css">
    <script src="../../assets/fullcalender/dist/index.global.js"></script>
    <title>Task Calendar</title>
</head>
<body>
    <?php
        $activePage = 'calendar';
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>
    <div class="calendar-container">
        <h1>Task Calendar</h1>

        <div class="calendar-toolbar">
            <div>
                <label for="priorityFilter">Priority:</label>
                <select id="priorityFilter">
                    <option value="">All</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>
            <div>
                <label for="subjectFilter">Subject:</label>
                <select id="subjectFilter">
                    <option value="">All</option>
                </select>
            </div>
        </div>

        <div class="calendar-card">
            <div id="calendar"></div>
        </div>

        <div class="legend">
            <span class="legend-item green">Completed</span>
            <span class="legend-item red">Pending</span>
        </div>
    </div>

    <script src="../../assets/js/navbar.js"></script>
    <script src="../../assets/js/calender.js"></script>
</body>
</html>
