<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/add_task_styles.css">
    <title>Add Task</title>
</head>
<body>
    <h1>Add a Task</h1>
    <form id="addTaskForm">

        <div class="form-group">
            <label for="title">Task Title</label>
            <input type="text" name="title" id="title" placeholder="Enter task title" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter task description (optional)"></textarea>
        </div>

        <div class="form-group">
            <label for="priority">Priority</label>
            <select name="priority" id="priority" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date">
        </div>

        <div class="form-group">
            <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id" required>
                <option value="" disabled selected>Select a Subject</option>
            </select>
        </div>
        <button type="submit" class="btn add-task-button">>Add Task</button>
    </form>

    <p id="responseMessage"></p>

    <script src="addTask.js"></script>
</body>
</html>