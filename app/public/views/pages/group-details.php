<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Details</title>
    <link rel="stylesheet" href="../../assets/css/group_details.css">
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
    <link rel="stylesheet" href="../../assets/fontawesome-free-6.7.2-web/css/all.min.css">
</head>
<body>
    <?php
        $activePage = 'groups'; 
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>
    <div class="group-details-container">
        <!-- Group Information -->
        <div class="group-info">
            <h1 id="groupName">Group Name</h1>
            <p id="groupDescription">Group Description</p>
        </div>

        <!-- Shared Tasks Section -->
        <div class="group-tasks">
            <h2><i class="fas fa-tasks"></i> Shared Tasks</h2>
            <ul id="groupTasksList"></ul>

            <!-- Add Task Button -->
            <div class="add-task-button">
                <button id="openTaskModal" class="btn add-task-btn">
                    <i class="fas fa-plus"></i> Add Task
                </button>
            </div>
        </div>

        <!-- Group Management Section -->
        <div class="group-management">
            <h2><i class="fas fa-users-cog"></i> Group Management</h2>
            
            <!-- Group Members -->
            <div class="members-section">
                <h3>Group Members</h3>
                <ul id="groupMembersList"></ul>
            </div>

            <!-- Invite User -->
            <div class="add-user">
                <h3>Invite User</h3>
                <form id="addUserForm">
                    <input type="text" id="userIdentifier" placeholder="Enter username or email" required>
                    <button type="submit"><i class="fas fa-user-plus"></i> Invite</button>
                </form>
                <p id="addUserResponse"></p>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeTaskModal">&times;</span>
            <h2>Add a New Task</h2>
            <form id="addTaskForm">
                <div class="form-group">
                    <label for="taskTitle">Task Title</label>
                    <input type="text" id="taskTitle" placeholder="Enter task title" required>
                </div>

                <div class="form-group">
                    <label for="taskDescription">Description</label>
                    <textarea id="taskDescription" rows="4" placeholder="Enter task description"></textarea>
                </div>

                <div class="form-group">
                    <label for="taskPriority">Priority</label>
                    <select id="taskPriority" required>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="taskDueDate">Due Date</label>
                    <input type="date" id="taskDueDate" required>
                </div>

                <button type="submit" class="btn add-task-btn">Add Task</button>
            </form>
        </div>
    </div>

    <script src="../../assets/js/groupDetails.js"></script>
</body>
</html>
