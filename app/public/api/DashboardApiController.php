<?php
require_once(__DIR__ . '/../models/TasksModel.php');
require_once(__DIR__ . '/utils/ResponseHelper.php');

class DashboardApiController {
    private $taskModel;

    public function __construct() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        error_log("[DEBUG] Session Data: " . print_r($_SESSION, true));

        $this->taskModel = new TasksModel();
    }

    public function getSummary() {
        if (!isset($_SESSION['user_id'])) {
            error_log("[DEBUG] User not authenticated: No user_id in session.");
            ResponseHelper::sendError('User not authenticated', 401);
            return;
        }


        $userId = $_SESSION["user_id"];

        try {
            $totalTasks = $this->taskModel->countTotalTasks($userId);
            $taskStatus = $this->taskModel->countTasksByStatus($userId);
            $priorityBreakdown = $this->taskModel->groupTasksByPriority($userId);
            $upcomingDeadlines = $this->taskModel->getUpcomingDeadlines($userId);

            ResponseHelper::sendJson([
                'totalTasks' => $totalTasks,
                'taskStatus' => $taskStatus,
                'priorityBreakdown' => $priorityBreakdown,
                'upcomingDeadlines' => $upcomingDeadlines,
            ]);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch dashboard data', 500);
        }
    }
}
