<?php
require_once(__DIR__ . '/../models/ResourceModel.php');
require_once(__DIR__ . '/utils/ResponseHelper.php');

class ResourceApiController
{
    
    private $resourceModel;

    public function __construct()
    {
        $this->resourceModel = new ResourceModel();
    }

    
    public function uploadResource()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type = $_POST['type'] ?? '';
            $taskId = $_POST['task_id'] ?? null;
            $subjectId = $_POST['subject_id'] ?? null;

            if (!isset($_SESSION['user_id'])) {
                ResponseHelper::sendError('User not authenticated', 401);
                return;
            }

            $userId = $_SESSION['user_id'];

            try {
                if ($type === 'file' && isset($_FILES['file'])) {
                    
                    $targetDir = __DIR__ . '/../uploads/';
                    $fileName = basename($_FILES['file']['name']);
                    $filePath = $targetDir . $fileName;

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                        $resourcePath = 'uploads/' . $fileName;
                        $this->resourceModel->addResource($userId, $taskId, $subjectId, 'file', $resourcePath, null);
                    } else {
                        throw new Exception('Failed to move uploaded file.');
                    }
                } elseif ($type === 'link') {
                    $link = $_POST['resource_path'] ?? '';
                    if (empty($link)) {
                        throw new Exception('Link cannot be empty.');
                    }
                    $this->resourceModel->addResource($userId, $taskId, $subjectId, 'link', $link, null);
                } elseif ($type === 'note') {
                    $note = $_POST['note'] ?? '';
                    if (empty($note)) {
                        throw new Exception('Note cannot be empty.');
                    }
                    $this->resourceModel->addResource($userId, $taskId, $subjectId, 'note', null, $note);
                } else {
                    throw new Exception('Invalid resource type.');
                }

                ResponseHelper::sendJson(['message' => 'Resource uploaded successfully']);
            } catch (Exception $e) {
                error_log('Error uploading resource: ' . $e->getMessage());
                ResponseHelper::sendError($e->getMessage(), 500);
            }
        } else {
            ResponseHelper::sendError('Invalid request method', 405);
        }
    }






    
    public function getAllResources()
    {
        try {
            $resources = $this->resourceModel->getResources();
            ResponseHelper::sendJson($resources);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch resources', 500);
        }
    }

    
    public function getResourcesBySubject($subjectId)
    {
        try {
            if (empty($subjectId)) {
                throw new Exception('Subject ID is required.');
            }

            $resources = $this->resourceModel->getResourcesBySubject($subjectId);
            ResponseHelper::sendJson($resources);
        } catch (Exception $e) {
            ResponseHelper::sendError($e->getMessage(), 500);
        }
    }
    public function getUserResources()
    {
        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError('User not authenticated', 401);
            return;
        }

        $userId = $_SESSION['user_id'];

        try {
            $resources = $this->resourceModel->getResourcesByUserId($userId);
            ResponseHelper::sendJson($resources);
        } catch (Exception $e) {
            ResponseHelper::sendError('Failed to fetch resources', 500);
        }
    }


}
