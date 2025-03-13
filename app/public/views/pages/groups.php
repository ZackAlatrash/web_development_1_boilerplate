<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Groups</title>
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
    <link rel="stylesheet" href="../../assets/css/groups_styles.css">
</head>
<body>
    <?php
        $activePage = 'groups';
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>

    <div class="group-container">
        <h1>My Groups</h1>
        
        <!-- Add Group Button -->
        <button id="addGroupButton" class="btn add-group-btn">+ Create Group</button>

        <!-- Add Group Modal -->
        <div id="addGroupModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Create New Group</h2>
                <form id="addGroupForm">
                    <div class="form-group">
                        <label for="group_name">Group Name:</label>
                        <input type="text" id="group_name" name="group_name" placeholder="Enter group name" required>
                    </div>
                    <div class="form-group">
                        <label for="group_description">Group Description:</label>
                        <textarea id="group_description" name="description" placeholder="Enter group description"></textarea>
                    </div>
                    <button type="submit" class="btn create-group-btn">Create</button>
                </form>
            </div>
        </div>

        <!-- Groups List -->
        <ul id="groupList" class="group-list">
            <!-- Group items will be populated dynamically -->
        </ul>
    </div>

    <script src="../../assets/js/navbar.js"></script>
    <script src="../../assets/js/groups.js"></script>
</body>
</html>
