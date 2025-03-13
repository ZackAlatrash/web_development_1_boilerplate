<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <!-- Link to Styles -->
    <link rel="stylesheet" href="../../assets/css/tasks_styles.css">
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
</head>
<body>
    <!-- Navbar -->
    <?php
        $activePage = 'tasks'; 
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>

    <div class="tasks-container">
        <!-- Page Title -->
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

        <!-- Add Task Button -->
        <button id="addTaskButton" class="btn primary-btn">+ Add Task</button>

        <!-- Add Task Modal -->
        <div id="addtaskModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <?php require_once(__DIR__ . "/../partials/add_task_form.php"); ?>
            </div>
        </div>

        <!-- Filters -->
        <div class="task-filters">
            <select id="filterByPriority">
                <option value="">Filtered by Date</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>

            
        </div>

        <!-- Tasks List -->
        <ul id="taskList" class="task-list"></ul>
    </div>

    <!-- Link to Scripts -->
    <script src="../../assets/js/navbar.js"></script>
    <script src="../../assets/js/tasks.js"></script>
</body>
</html>
