<?php
require_once(__DIR__ . '/../models/TasksModel.php');
require_once(__DIR__ . '/utils/ResponseHelper.php');

class GroupTasksApiController {
    private $tasksModel;

    public function __construct() {
        $this->tasksModel = new TasksModel();
    }

    // Fetch tasks for a group
    public function getTasksByGroup($groupId) {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('User not authenticated', 401);
            return;
        }

        try {
            $tasks = $this->tasksModel->getTasksByGroupId($groupId);
            ResponseHelper::sendJson($tasks);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch group tasks', 500);
        }
    }

    // Create a new group task
    public function createGroupTask() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Decode JSON input
            $data = json_decode(file_get_contents('php://input'), true);
        
            // Extract and validate fields
            $title = $data['title'] ?? '';
            $description = $data['description'] ?? null;
            $priority = $data['priority'] ?? 'Low';
            $dueDate = $data['due_date'] ?? null;
            $groupId = $data['group_id'] ?? null;
        
            if (empty($title) || empty($groupId)) {
                ResponseHelper::sendError('Title and Group ID are required', 400);
                return;
            }
        
            try {
                // Get current user ID from session
                $userId = $_SESSION['user_id'] ?? null;
                if (!$userId) {
                    ResponseHelper::sendError('User not authenticated', 401);
                    return;
                }
            
                // Handle nullable subjectId
                $subjectId = $data['subject_id'] ?? null;
            
                // Convert priority and dueDate
                $priorityEnum = PriorityEnum::fromString($priority);
                $dueDateObj = $dueDate ? new DateTime($dueDate) : null;
            
                // Create Task DTO
                $taskDTO = new TasksDTO(
                    id: 0,
                    subjectId: null, // Supports null value
                    userId: null,
                    title: $title,
                    description: $description,
                    priority: $priorityEnum,
                    dueDate: $dueDateObj,
                    isCompleted: false,
                    groupId: $groupId
                );
            
                // Insert into the database
                $this->tasksModel->createTask($taskDTO);
            
                // Success response
                ResponseHelper::sendJson(['message' => 'Group task created successfully']);
            } catch (Exception $e) {
                error_log('Error creating group task: ' . $e->getMessage());
                ResponseHelper::sendError('Failed to create group task', 500);
            }
        } else {
            ResponseHelper::sendError('Invalid request method', 405);
        }
    }


    public function deleteGroupTask($taskId)
    {
        try
        {
            $this->tasksModel->deleteTask($taskId);
            ResponseHelper::sendJson(['message' => 'Task deleted successfully']);
        }
        catch(Exception $e)
        {
            ResponseHelper::sendError("Failed to fetch tasks", 500);
        }
    }
    public function completeGroupTask($taskId)
    {
        try
        {
            $this->tasksModel->completeTask($taskId);
            ResponseHelper::sendJson(['message' => 'Task completed successfully']);
        }
        catch(Exception $e)
        {
            ResponseHelper::sendError("Failed to complete task", 500);
        }
    }
}
