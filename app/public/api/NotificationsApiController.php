<?php
require_once(__DIR__ . '/../models/TasksModel.php');
require_once(__DIR__ . '/utils/ResponseHelper.php');

class NotificationsApiController {
    private $taskModel;

    public function __construct() {
        $this->taskModel = new TasksModel();
    }

    public function getNotifications() {
        

        $userId = 1;
        try {
            $tasksDueSoon = $this->taskModel->getTasksDueSoon($userId);
            ResponseHelper::sendJson($tasksDueSoon);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch notifications', 500);
        }
    }
}
