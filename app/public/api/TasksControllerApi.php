<?php
require_once(__DIR__."/../api/utils/ResponseHelper.php");
require_once(__DIR__. "/../models/TasksModel.php");
require_once(__DIR__. "/../dto/TasksDTO.php");
class TaskApiController
{
    private $taskModel;
    public function __construct() {
        $this->taskModel = new TasksModel();
    }

    public function getTasksByUser()
    {
        if(isset($_SESSION["user_id"]))
        {
            try
            {
                $tasks = $this->taskModel->getTasksByUserId($_SESSION["user_id"]);
                ResponseHelper::sendJson($tasks);
            }
            catch(Exception $e)
            {
                ResponseHelper::sendError("Failed to fetch tasks", 500);
            }
            
        }
        else
        {
            header('Location: /login');
        }
    }

    public function deleteTask($taskId)
    {
        try
        {
            $this->taskModel->deleteTask($taskId);
            ResponseHelper::sendJson(['message' => 'Task deleted successfully']);
        }
        catch(Exception $e)
        {
            ResponseHelper::sendError("Failed to fetch tasks", 500);
        }
    }

    public function addTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
        
            if (empty($input['title']) || empty($input['subject_id'])) {
                ResponseHelper::sendError("Task title and subject_id are required", 400);
                return;
            }
        
            try {
                $taskDTO = new TasksDTO(
                    id: 0,
                    subjectId: intval($input['subject_id']),
                    userId: $_SESSION['user_id'],
                    title: $input['title'],
                    description: $input['description'] ?? null,
                    priority: PriorityEnum::fromString($input['priority'] ?? 'Medium'),
                    dueDate: !empty($input['due_date']) ? new DateTime($input['due_date']) : null,
                    isCompleted: false
                );
            
                $this->taskModel->createTask($taskDTO);
            
                ResponseHelper::sendJson(['message' => 'Task added successfully']);
            } catch (Exception $e) {
                ResponseHelper::sendError("Failed to add task", 500);
            }
        }
    }


    public function completeTask($taskId)
    {
        try
        {
            $this->taskModel->completeTask($taskId);
            ResponseHelper::sendJson(['message' => 'Task completed successfully']);
        }
        catch(Exception $e)
        {
            ResponseHelper::sendError("Failed to complete task", 500);
        }
    }

    
}